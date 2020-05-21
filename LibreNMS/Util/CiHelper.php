<?php
/**
 * CiHelper.php
 *
 * -Description-
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2020 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\Util;

use Illuminate\Support\Str;

class CiHelper
{
    private $options;
    private $changedFiles;
    private $changed = [
        'docs' => 0,
        'python' => [],
        'bash' => [],
        'php' => [],
        'os-php' => [],
        'os' => [],
    ];
    private $quiet = false;
    private $commandOnly = false;
    private $failFast = false;
    private $docsOnly = false;
    private $completedTests = [
        'lint' => false,
        'style' => false,
        'unit' => false,
    ];
    private $fullChecks = false;
    private $modules;

    public function __construct()
    {
        $this->parseOptions();
        $this->detectChangedFiles();
        $this->checkOptions();
    }

    public function run()
    {
        // run tests in the order they were specified

        $return = 0;
        foreach (array_keys($this->options) as $opt) {
            $ret = 0;
            if ($opt == 'l' || $opt == 'lint') {
                $ret = $this->runCheck('lint');
            } elseif ($opt == 's' || $opt == 'style') {
                $ret = $this->runCheck('style');
            } elseif ($opt == 'u' || $opt == 'unit') {
                $ret = $this->runCheck('unit');
            }

            if ($this->failFast && $ret !== 0 && $ret !== 250) {
                exit($ret);
            } else {
                $return += $ret;
            }
        }

        return $return;
    }

    public function allChecksComplete()
    {
        return array_reduce($this->completedTests, function ($result, $check) {
            return $result && $check;
        }, false);
    }

    /**
     * Runs phpunit
     *
     * @return int the return value from phpunit (0 = success)
     */
    public function checkUnit()
    {
        $phpunit_bin = $this->checkExec('phpunit');

        $phpunit_cmd = "$phpunit_bin --colors=always";

        if ($this->failFast) {
            $phpunit_cmd .= ' --stop-on-error --stop-on-failure';
        }

        if (!$this->fullChecks) {
            if (!empty($this->changed['os']) && empty(array_diff($this->changed['php'], $this->changed['os-php']))) {
                echo 'Only checking os: ' . implode(', ', $this->changed['os']) . PHP_EOL;

                $filter = implode('.*|', $this->changed['os']);
                // include tests that don't have data providers and only data sets that match
                $phpunit_cmd .= " --group os --filter '/::test[A-Za-z]+$|::test[A-Za-z]+ with data set \"$filter.*\"$/'";
            }

            if ($this->docsOnly) {
                $phpunit_cmd .= " --group docs";
            }

            if ($this->checkOpt('m', 'module')) {
                $phpunit_cmd .= ' tests/OSModulesTest.php';
            }
        }

        return $this->execute('unit', $phpunit_cmd);
    }

    /**
     * Runs phpcs --standard=PSR2 against the code base
     *
     * @return int the return value from phpcs (0 = success)
     */
    public function checkStyle()
    {
        $phpcs_bin = $this->checkExec('phpcs');

        $cs_cmd = "$phpcs_bin -n -p --colors --extensions=php --standard=misc/phpcs_librenms.xml ./";

        return $this->execute('style', $cs_cmd);
    }

    /**
     * Runs php -l and tests for any syntax errors
     *
     * @return int the return value from running php -l (0 = success)
     */
    public function checkLint()
    {
        $parallel_lint_bin = $this->checkExec('parallel-lint');

        // matches a substring of the relative path, leading / is treated as absolute path
        $lint_excludes = ['vendor/'];

        $lint_exclude = $this->buildPhpLintExcludes('--exclude ', $lint_excludes);
        $lint_cmd = "$parallel_lint_bin $lint_exclude ./";

        return $this->execute('PHP lint', $lint_cmd);
    }

    /**
     * Run the specified check and return the return value.
     * Make sure it isn't skipped by SKIP_TYPE_CHECK env variable and hasn't been run already
     *
     * @param string $type type of check lint, style, or unit
     * @param array $options command specific options
     * @return int the return value from the check (0 = success)
     */
    public function runCheck($type)
    {
        if (getenv('SKIP_' . strtoupper($type) . '_CHECK') || $this->completedTests[$type]) {
            echo ucfirst($type) . " check skipped.\n";
            return 0;
        }

        $function = 'check' . ucfirst($type);
        if (method_exists($this, $function)) {
            $this->completedTests[$type] = true;
            return $this->$function();
        }

        return 1;
    }

    /**
     * @param string $name
     * @param string $command
     * @return int
     */
    private function execute(string $name, string $command): int
    {
        if ($this->commandOnly) {
            echo $command . PHP_EOL;
            return 250;
        }

        echo "Running $name check... ";

        if (!$this->quiet) {
            echo PHP_EOL;
            passthru($command, $return);
            return $return;
        }

        exec($command, $output, $return);

        if ($return > 0) {
            echo "failed\n";
            print(implode(PHP_EOL, $output) . PHP_EOL);
        } else {
            echo "success\n";
        }

        return $return;
    }

    /**
     * Extract os name from path and validate it exists.
     *
     * @param $php_file
     * @return null|string
     */
    private function osFromPhp($php_file)
    {
        $os = basename($php_file, '.inc.php');

        if (file_exists("includes/definitions/$os.yaml")) {
            return $os;
        }

        return null;
    }

    private function osFromFile($file)
    {
        if (Str::startsWith($file, 'includes/definitions/')) {
            return basename($file, '.yaml');
        } elseif (Str::startsWith($file, ['includes/polling', 'includes/discovery'])) {
            return $this->osFromPhp($file);
        } elseif (Str::startsWith($file, 'LibreNMS/OS/')) {
            if (preg_match('#LibreNMS/OS/[^/]+.php#', $file)) {
                // convert class name to os name
                preg_match_all("/[A-Z][a-z]*/", basename($file, '.php'), $segments);
                $osname = implode('-', array_map('strtolower', $segments[0]));
                $os = $this->osFromPhp($osname);
                if ($os) {
                    return $os;
                }
                return $this->osFromPhp(str_replace('-', '_', $osname));
            }
        } elseif (Str::startsWith($file, ['tests/snmpsim/', 'tests/data/'])) {
            [$os,] = explode('_', basename(basename($file, '.json'), '.snmprec'), 2);
            return $os;
        }

        return null;
    }

    private function detectChangedFiles()
    {
        $changed_files = getenv('FILES')
            ? rtrim(getenv('FILES'))
            : exec("git diff --diff-filter=d --name-only master | tr '\n' ' '|sed 's/,*$//g'");
        $this->changedFiles = $changed_files ? explode(' ', $changed_files) : [];

        foreach ($this->changedFiles as $file) {
            if (Str::startsWith($file, 'doc/')) {
                $this->changed['docs']++;
            } elseif (Str::endsWith($file, '.py')) {
                $this->changed['python'][] = $file;
            } elseif (Str::endsWith($file, '.sh')) {
                $this->changed['bash'][] = $file;
            } elseif (Str::endsWith($file, '.php')) {
                $this->changed['php'][] = $file;
            }

            // cause full tests to run
            if ($file == 'composer.lock' || $file == '.travis.yml') {
                $this->fullChecks = true;
            }

            // check if os owned file or generic php file
            if (!empty($os_name = $this->osFromFile($file))) {
                $this->changed['os'][] = $os_name;
                if (Str::endsWith($file, '.php')) {
                    $this->changed['os-php'][] = $file;
                }
            }
        }

        $this->changed['os'] = array_unique($this->changed['os']);

        // If we have more than 4 (arbitrary number) of OS' then blank them out
        // Unit tests may take longer to run in a loop so fall back to all.
        if (count($this->changed['os']) > 4) {
            $this->changed['os'] = [];
        }
    }

    private function parseOptions(): void
    {
        $short_opts = 'lsufqcho:m:';
        $long_opts = [
            'lint',
            'style',
            'unit',
            'os:',
            'module:',
            'fail-fast',
            'quiet',
            'snmpsim',
            'db',
            'commands',
            'help',
        ];
        $this->options = getopt($short_opts, $long_opts);

        $filename = basename($_SERVER["SCRIPT_FILENAME"]);
        if ($this->checkOpt('h', 'help')) {
            echo "LibreNMS Code Tests Script
Running $filename without options runs all checks.
  -l, --lint      Run php lint checks to test for valid syntax
  -s, --style     Run phpcs check to check for PSR-2 compliance
  -u, --unit      Run phpunit tests
  -o, --os        Specific OS to run tests on. Implies --unit, --db, --snmpsim
  -m, --module    Specific Module to run tests on. Implies --unit, --db, --snmpsim
  -f, --fail-fast Quit when any failure is encountered
  -q, --quiet     Hide output unless there is an error
      --db        Run unit tests that require a database
      --snmpsim   Use snmpsim for unit tests
  -c, --commands  Print commands only, no checks
  -h, --help      Show this help text.\n";
            exit();
        }
    }

    private function checkOptions()
    {
        $this->quiet = $this->checkOpt('q', 'quiet');
        $this->commandOnly = $this->checkOpt('c', 'commands');
        $this->failFast = $this->checkOpt('f', 'fail-fast');

        if ($os = $this->checkOpt('os', 'o')) {
            // enable unit tests, snmpsim, and db
            $this->options['u'] = false;
            $this->options['snmpsim'] = false;
            $this->options['db'] = false;
        }

        if ($modules = $this->checkOpt('m', 'module')) {
            $this->modules = $modules;
            putenv("TEST_MODULES=$modules");
            // enable unit tests, snmpsim, and db
            $this->options['u'] = false;
            $this->options['snmpsim'] = false;
            $this->options['db'] = false;
        }

        if (!$this->checkOpt('l', 'lint', 's', 'style', 'u', 'unit')) {
            // no test specified, run all tests in this order
            $this->options += ['u' => false, 's' => false, 'l' => false];
        }

        if ($this->checkOpt('snmpsim')) {
            putenv('SNMPSIM=1');
        }

        if ($this->checkOpt('db')) {
            putenv('DBTEST=1');
        }

        // No php files, skip the php checks.
        if (!empty($this->changedFiles) && empty($this->changed['php'])) {
            putenv('SKIP_LINT_CHECK=1');
            putenv('SKIP_STYLE_CHECK=1');
        }

        // If we have no php files and no OS' found then also skip unit checks.
        if (!empty($this->changedFiles) && empty($this->changed['php']) && empty($this->changed['os'])) {
            if ($this->changed['docs'] > 0) {
                $this->docsOnly = true;
            } else {
                putenv('SKIP_UNIT_CHECK=1');
            }
        }
    }

    /**
     *  Check if the given options array contains any of the $opts specified
     *
     * @param string ...$opts options to check for
     * @return bool If one of the specified options is set
     */
    private function checkOpt(...$opts)
    {
        foreach ($opts as $option) {
            if (isset($this->options[$option])) {
                if ($this->options[$option] === false) {
                    // no data, return that option is enabled
                    return true;
                }
                return $this->options[$option];
            }
        }

        return false;
    }

    /**
     * Check for an executable and return the path to it
     * If it does not exist, run composer update.
     * If composer isn't installed, print error and exit.
     *
     * @param string $exec the name of the executable to check
     * @return string path to the executable
     */
    private function checkExec($exec)
    {
        $path = "vendor/bin/$exec";

        if (is_executable($path)) {
            return $path;
        }

        echo "Running composer install to install developer dependencies.\n";
        passthru("scripts/composer_wrapper.php install");

        if (is_executable($path)) {
            return $path;
        }

        echo "\nRunning installing deps with composer failed.\n You should try running './scripts/composer_wrapper.php install' by hand\n";
        echo "You can find more info at http://docs.librenms.org/Developing/Validating-Code/\n";
        exit(1);
    }

    /**
     * Build a list of exclude arguments from an array
     *
     * @param string $exclude_string such as "--exclude"
     * @param array $excludes array of directories to exclude
     * @return string resulting string
     */
    private function buildPhpLintExcludes($exclude_string, $excludes)
    {
        $result = '';
        foreach ($excludes as $exclude) {
            $result .= $exclude_string . $exclude . ' ';
        }

        return $result;
    }
}
