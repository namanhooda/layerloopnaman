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
use Illuminate\Validation\ValidationException;



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
        // ✅ Require at least one: email OR phone
        if (empty($input['email']) && empty($input['phone'])) {
            throw ValidationException::withMessages([
                'email' => 'Email or mobile number is required.',
                'phone' => 'Email or mobile number is required.',
            ]);
        }

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],

            // Email is optional but must be valid & unique if present
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique(User::class, 'email'),
            ],

            // Phone is optional but must be valid & unique if present
            'phone' => [
                'nullable',
                'digits_between:8,15',
                Rule::unique(User::class, 'phone'),
            ],

            // ✅ Only one password field (NO confirmation)
            'password' => ['required', 'string', 'min:8'],
        ])->validate();

        $user = User::create([
            'name'     => $input['name'],
            'email'    => $input['email'] ?? null,
            'phone'    => $input['phone'] ?? null,
            'password' => Hash::make($input['password']),
        ]);

        // ✅ Assign default role
        if ($role = Role::find(2)) {
            $user->assignRole($role);
        }

        // ✅ Create wallet
        Wallet::create([
            'user_id'     => $user->id,
            'amount'      => 20,
            'type'        => 'credit',
            'source'      => 'new user discount',
            'description' => 'Wallet created with new user discount',
        ]);

        // ✅ Create wallet transaction
        WalletTransaction::create([
            'user_id'     => $user->id,
            'amount'      => 20,
            'type'        => 'credit',
            'source'      => 'new user discount',
            'description' => 'Initial credit from new user discount',
        ]);

        return $user;
    }
}
