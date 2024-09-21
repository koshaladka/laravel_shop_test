<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * @param $request
     * @return array
     * @throws ValidationException
     */
    public function execute($request): array
    {
        $user = User::query()->where('email', $request['email'])->first();

        if (empty($user) || ! Hash::check($request['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect'],
            ]);
        }

        return [
            'token' => $user->createToken('Auth Token')->plainTextToken,
            'token_type' => 'Bearer',
        ];
    }

}
