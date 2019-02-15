<?php
/**
 * AddUserCommand.php
 *
 * CLI command to add a user to LibreNMS
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
 * @copyright  2019 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Console\Commands;

use App\Console\LnmsCommand;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Validator;

class AddUserCommand extends LnmsCommand
{
    protected $name = 'user:add';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->setDescription(__('commands.user:add.description'));

        $this->addArgument('username', InputArgument::REQUIRED);
        $this->addOption('password', 'p', InputOption::VALUE_REQUIRED);
        $this->addOption('role', 'r', InputOption::VALUE_REQUIRED, __('commands.user:add.options.role', ['roles' => '[normal, global-read, admin]']), 'normal');
        $this->addOption('email', 'e', InputOption::VALUE_REQUIRED);
        $this->addOption('full-name', 'l', InputOption::VALUE_REQUIRED);
        $this->addOption('descr', 's', InputOption::VALUE_REQUIRED);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $roles = [
            'normal' => 1,
            'global-read' => 5,
            'admin' => 10
        ];

        $validator = Validator::make($this->arguments() + $this->options(), [
            'username' => ['required', Rule::unique('users', 'username')->where('auth_type', 'mysql')],
            'email' => 'email',
            'role' => Rule::in(array_keys($roles))
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            collect($validator->getMessageBag()->all())->each(function ($message) {
                $this->error($message);
            });
            return 1;
        }

        // set get password
        $password = $this->option('password');
        if (!$password) {
            $password = $this->secret(__('commands.user:add.password-request'));
        }

        $user = new User([
            'username' => $this->argument('username'),
            'level' => $roles[$this->option('role')],
            'descr' => (string)$this->option('descr'),
            'email' => (string)$this->option('email'),
            'realname' => (string)$this->option('full-name'),
            'auth_type' => 'mysql',
        ]);
        $user->password = $password;
        $user->save();

        $this->info(__('commands.user:add.success', ['username' => $user->username]));
        return 0;
    }
}
