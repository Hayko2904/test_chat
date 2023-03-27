<?php


namespace App\Http\Repositories;


use App\Models\Message;
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

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return Room::find($id);
    }

    /**
     * @param int $roomId
     * @param string $text
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function insertMessage(int $roomId, string $text)
    {
        return Message::query()
            ->create([
                'room_id' => $roomId,
                'user_id' => auth()->id(),
                'message' => $text
            ]);
    }
}
