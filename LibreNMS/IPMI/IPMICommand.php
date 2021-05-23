<?php

/**
 * IPMICommand.php
 *
 * IPMI Comand
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
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * @link       https://www.librenms.org
 * @copyright  2021 Trym Lund Flogard
 * @author     Trym Lund Flogard <trym@flogard.no>
 */

namespace LibreNMS\IPMI;

use Exception;
use LibreNMS\Config;
use LibreNMS\Util\Debug;
use LibreNMS\Proc;

/**
 * Represents an executable IPMICommand.
 */
final class IPMICommand
{
    private $command;
    private $proc;

    /**
     * Create a new instance of the IPMICommand class.
     * @param array $command The command to run and its arguments.
     */
    public function __construct(array $command)
    {
        $this->command = $command;
    }

    /**
     * Executes the command.
     *
     * @return null|string The standard output of the command. Null if exit code is greater than 0.
     */
    public function execute()
    {
        if ($this->proc != null) {
            throw new Exception("The command has already been executed.");
        }
        
        $this->printInput($this->command);

        $this->proc = new Proc($this->command);
        $out = $this->proc->getOutput();
        
        $this->printOutput($out);

        return $this->proc->getExitCode() > 0 ? null : $out[0];
    }

    /**
     * Gets a value indicating whether the command returned an error.
     */
    public function hasError(): bool
    {
        return !$this->proc->isRunning() && $this->proc->getExitCode() > 0;
    }

    private static function printInput(array $input)
    {
        if (!(Debug::isVerbose() || Debug::isEnabled())) {
            return;
        }

        $inputString = join(' ', $input);
        $patterns = [
            '/-c\' \'[\S]+\'/',
            '/-u\' \'[\S]+\'/',
            '/-U\' \'[\S]+\'/',
            '/-A\' \'[\S]+\'/',
            '/-X\' \'[\S]+\'/',
            '/-P\' \'[\S]+\'/',
            '/-H\' \'[\S]+\'/',
            '/(udp|udp6|tcp|tcp6):([^:]+):([\d]+)/',
        ];
        $replacements = [
            '-c\' \'COMMUNITY\'',
            '-u\' \'USER\'',
            '-U\' \'USER\'',
            '-A\' \'PASSWORD\'',
            '-X\' \'PASSWORD\'',
            '-P\' \'PASSWORD\'',
            '-H\' \'HOSTNAME\'',
            '\1:HOSTNAME:\3',
        ];

        $filtered = preg_replace($patterns, $replacements, $inputString);
        c_echo('IPMI[%c' . $filtered . "%n]\n");
    }

    private function printOutput(array $outErr)
    {
        d_echo($outErr[0] . PHP_EOL);

        if ($this->proc->getExitCode()) {
            d_echo('Exitcode: ' . $this->proc->getExitCode());
            d_echo($outErr[1]);
        }
    }
}
