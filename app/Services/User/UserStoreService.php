<?php

namespace App\Services\User;


use App\Models\User;

class UserStoreService
{
    public function execute($request): array
    {
        $user = User::create([
            'email' => $request['email'],
            'city' =>  $request['city'],
        ]);

        return [
            'user_id' => $user->id,
        ];
    }

}
