<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'viewage:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register a new user';

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
	    if (! $user = $this->createUser()) {
		    $this->info('Error: User creation failed. Please try again');
		    return;
	    }
    }

	private function createUser()
	{
		$this->info('Creating user account');

		$email = $this->ask('Email Address');

		try
		{
			Validator::make(['email' => $email], ['email' => 'email'])->validate();
		} catch (ValidationException $e) {
			$this->info('Error: Invalid email. aborting.');
			return false;
		}

		$password = $this->secret('Password');
		$confirmPassword = $this->secret('Confirm Password');

		if ($password != $confirmPassword)
		{
			$this->info('Error: Passwords do not match. aborting.');
			return false;
		}

		return User::create([
			'email' => $email,
			'password' => Hash::make($password),
		]);
	}
}
