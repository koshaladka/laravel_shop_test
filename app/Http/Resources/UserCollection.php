<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($user) {
            return [
                'email' => $user->email,
                'city' => $user->city,
                'date' => Carbon::parse($user->created_at)->format('Y-m-d H:i:s'),
            ];
        })->toArray();
    }
}
