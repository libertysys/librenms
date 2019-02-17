<?php

namespace App\Console\Commands;

use App\Console\LnmsCommand;
use LibreNMS\ComposerHelper;
use LibreNMS\Config;
use LibreNMS\Util\OSDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class CleanFiles extends LnmsCommand
{
    protected $name = 'clean:files';

    private $dirs = [
        "app/",
        "bootstrap/",
        "contrib/",
        "database/",
        "doc/",
        "html/",
        "includes/",
        "LibreNMS/",
        "licenses/",
        "mibs/",
        "misc/",
        "resources/",
        "routes",
        "scripts/",
        "sql-schema/",
        "tests/",
    ];
    private $gitignores = [
        '.gitignore',
        'bootstrap/cache/.gitignore',
        'logs/.gitignore',
        'rrd/.gitignore',
        'storage/app/.gitignore',
        'storage/app/public/.gitignore',
        'storage/debugbar/.gitignore',
        'storage/framework/cache/.gitignore',
        'storage/framework/cache/data/.gitignore',
        'storage/framework/sessions/.gitignore',
        'storage/framework/testing/.gitignore',
        'storage/framework/views/.gitignore',
        'storage/logs/.gitignore',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->setDescription(__('commands.clean:files.description'));
        $this->addOption('vendor', null, InputOption::VALUE_NONE);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm(__('commands.clean:files.confirm'))) {
            foreach ($this->getCommands() as $command) {
                $process = new Process($command, Config::installDir());
                $this->line($process->getCommandLine(), null, OutputInterface::VERBOSITY_VERY_VERBOSE);

                if ($this->getOutput()->isVerbose()) {
                    $process->setTty(true);
                }
                $process->run();
            }

            $this->postCleanup();

            $this->info(__('commands.clean:files.done'));
            return 0;
        }
        return 1;
    }

    /**
     * Build the list of commands to clean
     *
     * @return array
     */
    private function getCommands(): array
    {
        $commands = [
            ['git', 'reset'],
            ['git', 'checkout', '.'],
            array_merge(['git', 'clean', '-d', '-f'], $this->dirs),
            array_merge(['git', 'checkout'], $this->gitignores), // fix gitignore missing or messed up file modes
        ];

        if ($this->option('vendor')) {
            $commands[] = ['git', 'clean', '-x', '-d', '-f', 'vendor/'];
        }
        return $commands;
    }

    private function postCleanup(): void
    {
        ComposerHelper::install(!$this->getOutput()->isVerbose());
        OSDefinition::updateCache(true);

        // remove patch files
        foreach (glob(ApplyPullRequest::getPatchSaveDir('/*.diff')) as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}
