<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // ✅ Assign default role ID 3 (safely)
        $defaultRole = Role::find(2);
        if ($defaultRole) {
            $user->assignRole($defaultRole);
        }

        // Create wallet
        $wallet = Wallet::create([
            'user_id' => $user->id,
            'amount' => 20,
            'type' => 'credit',
            'source' => 'new user discount',
            'description' => 'Wallet created with new user discount',
        ]);

        // Create wallet transaction
        WalletTransaction::create([
            'user_id' => $user->id,
            'amount' => 20,
            'type' => 'credit',
            'source' => 'new user discount',
            'description' => 'Initial credit from new user discount',
        ]);
        return $user;
    }
}
