<?php


namespace App\Http\Repositories;


use App\Models\Room;

class RoomRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): object
    {
        return Room::with('users')->get();
    }

    /**
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create(string $name): object
    {
        return Room::query()->create([
            'name' => $name
        ]);
    }

    /**
     * @param object $room
     * @param array $ids
     * @return mixed
     */
    public function joinUser(object $room, int $id)
    {
        $room->users()->attach($id);

        return Room::query()->with('users')->find($room->id);
    }
}
