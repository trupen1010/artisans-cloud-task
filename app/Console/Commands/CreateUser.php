<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {role : The role for the user (admin or teacher)} {--email} {--password} {--confirm-password} {--name} {--phone}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin or teacher user.';

    /**
     * Execute the console command.
     */
    public function handle(): bool
    {
        $roleInput = strtolower($this->argument('role'));

        // Validate role
        if (! in_array($roleInput, ['admin', 'teacher'])) {
            $this->error('Role must be either "admin" or "teacher"!');

            return false;
        }

        $email = $this->option('email') ?: $this->ask('What is your email address?', 'trupen@gmail.com');

        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $user = User::where('email', $email)->first();
            $this->info("User with email {$email} already exists.");
        } else {
            // Get user details
            $name = $this->option('name') ?: $this->ask('What is your name?');
            $password = $this->option('password') ?: $this->secret('Please enter password');
            $confirmPassword = $this->option('confirm-password') ?: $this->secret('Please enter confirm password');

            if ($password !== $confirmPassword) {
                $this->error('Password and Confirm Password do not match!');

                return false;
            }

            // Create user
            $user = User::create([
                'email' => $email,
                'password' => bcrypt($password),
                'name' => $name,
            ]);
        }

        // Handle role assignment
        if ($roleInput === 'admin') {
            return $this->createAdmin($user);
        } else {
            return $this->createTeacher($user);
        }
    }

    /**
     * Create admin user with all permissions.
     */
    private function createAdmin(User $user): bool
    {
        $permissions = Permission::pluck('id')->toArray();
        $role = Role::firstOrCreate(['name' => 'Admin']);
        $role->permissions()->sync($permissions);
        $user->roles()->sync($role);

        Artisan::call('optimize:clear');
        $this->info("{$user->name} created successfully as Admin!");

        return true;
    }

    /**
     * Create teacher user with teacher permissions.
     */
    private function createTeacher(User $user): bool
    {
        // Get phone number for teacher
        $phone = $this->option('phone') ?: $this->ask('What is the teacher\'s phone number?');

        // Create teacher record if it doesn't exist
        $teacher = Teacher::where('user_id', $user->id)->first();
        if (! $teacher) {
            $teacher = Teacher::create([
                'user_id' => $user->id,
                'phone' => $phone,
                'status' => 'active',
            ]);
        }

        // Assign teacher role with appropriate permissions
        $role = Role::where('name', 'Teacher')->first();
        if (! $role) {
            $this->error('Teacher role not found! Please run seeders first.');

            return false;
        }

        $user->roles()->sync($role);

        Artisan::call('optimize:clear');
        $this->info("{$user->name} created successfully as Teacher!");

        return true;
    }
}
