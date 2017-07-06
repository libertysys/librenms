#!/usr/bin/env php
<?php
/**
 * composer_wrapper.php
 *
 * Wrapper for composer to use system provided composer or download and use composer.phar
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
 * @copyright  2017 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

$install_dir = realpath(__DIR__ . '/..');
chdir($install_dir);

$exec = false;

$path_exec = shell_exec("which composer 2> /dev/null");
if (!empty($path_exec)) {
    $exec = trim($path_exec);
} elseif (is_file($install_dir . '/composer.phar')) {
    $exec = 'php ' . $install_dir . '/composer.phar';
} else {
    // Download composer.phar (code from the composer web site)
    @copy('https://getcomposer.org/installer', 'composer-setup.php');
    if (@hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') {
        // Installer verified
        shell_exec('php composer-setup.php');
        $exec = 'php ' . $install_dir . '/composer.phar';
    }
    @unlink('composer-setup.php');
}

if ($exec) {
    passthru("$exec " . implode(' ', array_splice($argv, 1)) . ' 2>&1');
} else {
    echo "Composer not available, please manually install composer.\n";
}
