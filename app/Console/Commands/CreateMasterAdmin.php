<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateMasterAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:master-admin {--email} {--password} {--confirm-password} {--name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new master admin.';

    /**
     * Execute the console command.
     */
    public function handle(): bool
    {
        $email = $this->option('email') ?: $this->ask('What is your email address?', 'trupen@gmail.com');

        $permissions = Permission::pluck('id')->toArray();

        if (User::where('email', $email)->exists()) {
            $admin = User::where('email', $email)->first('id');
        } else {
            $name = $this->ask('What is your name?');
            $password = $this->option('password') ?: $this->secret('Please enter password');
            $confirmPassword = $this->option('confirm-password') ?: $this->secret('Please enter confirm password');

            if ($password !== $confirmPassword) {
                $this->error('Password and Confirm Password not match!');

                return false;
            }

            $admin = User::create([
                'email' => $email,
                'password' => bcrypt($password),
                'name' => $name,
            ]);
        }
        $role = Role::firstOrCreate(['name' => 'Admin']);
        $role->permissions()->sync($permissions);
        $admin->roles()->sync($role);

        Artisan::call('optimize:clear');
        $this->info("$admin->name Created Successfully!!");

        return true;
    }
}
