<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class DashboardAccount extends Command
{
    protected $signature = 'dashboard:account {email}';

    protected $description = 'Create or update a shared dashboard account with a hidden password prompt';

    public function handle(): int
    {
        $email = strtolower(trim($this->argument('email')));
        $validator = Validator::make(compact('email'), ['email' => 'required|email|max:255']);
        if ($validator->fails()) {
            $this->error($validator->errors()->first());

            return self::FAILURE;
        }
        $user = User::where('email', $email)->first();
        if ($user && ! $this->confirm('Update this existing account password?')) {
            return self::FAILURE;
        }
        $password = $this->secret('New password (at least 12 characters, upper/lowercase, number and symbol)');
        $confirmation = $this->secret('Confirm new password');
        $validator = Validator::make(['password' => $password, 'password_confirmation' => $confirmation], [
            'password' => ['required', 'confirmed', Password::min(12)->mixedCase()->numbers()->symbols()],
        ]);
        if ($validator->fails()) {
            $this->error($validator->errors()->first());

            return self::FAILURE;
        }
        $user ??= new User(['name' => 'Meso Travels Admin', 'email' => $email]);
        $user->forceFill(['password' => $password])->save();
        $this->info('Account saved. Sign in at '.route('login'));

        return self::SUCCESS;
    }
}
