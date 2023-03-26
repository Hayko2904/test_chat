<?php


namespace App\Http\Repositories;


use App\Models\User;

class UserRepository
{
    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $data): object
    {
        return User::query()->create($data);
    }
}
