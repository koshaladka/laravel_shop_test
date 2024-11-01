<?php

namespace App\Services\User;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Carbon\Carbon;

class UserIndexService
{
    public function execute(): UserCollection
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return new UserCollection($users);
    }

}
