<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin user for application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        do {
            if (!empty($user)) {
                $this->info('Email address is currently in use, please try again or type exit.');
            }
            $email = $this->ask('Email Address For Admin?');
        } while (($user = User::where('email', $email)->exists()) && $email !== 'exit');

        if ($email === 'exit') {
            $this->info('Exiting');
            exit(0);
        }

        $name = $this->ask('Name for this admin user?');
        $password = $this->ask('Password for this admin user?');

        $this->info('You have given the following details:');
        $this->info('Email address: ' . $email);
        $this->info('Name: ' . $name);
        $this->info('Password:' . $password);

        if (!$this->confirm('Create this user?')) {
            exit(0);
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => Carbon::now(),
        ]);

        if ($user) {
            $this->info('User created, you may now log in.');
            exit(0);
        }

        $this->error('Unable to create user.');
        exit(0);
    }
}
