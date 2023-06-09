<?php

namespace App\Http\Controllers;

use App\Events\RoomCreated;
use App\Events\SendMessage;
use App\Http\Repositories\RoomRepository;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * @var RoomRepository
     */
    private $roomRepository;

    /**
     * ChatController constructor.
     * @param RoomRepository $roomRepository
     */
    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function roomCreate(Request $request): object
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $room = $this->roomRepository->create($request->input('name'));
        $roomData = $this->roomRepository->joinUser($room, auth()->id());
        event(new RoomCreated($roomData));

        return redirect()->route('dashboard');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function join(int $id): object
    {
        $room = $this->roomRepository->getById($id);
        $this->roomRepository->joinUser($room, auth()->id());

        return redirect()->route('dashboard');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMessages(Request $request)
    {
        $request->validate([
            'roomId' => 'required||exists:rooms,id'
        ]);

        $room = $this->roomRepository->getById($request->input('roomId'));
        $room->load('messages');
        $view = view('chat.messages', compact('room'))->render();

        return response()->json($view);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'roomId' => 'required|exists:rooms,id',
            'text' => 'required'
        ]);

        $message = $this->roomRepository->insertMessage($request->input('roomId'), $request->input('text'));
        event(new SendMessage($message->toArray()));

        return response()->json($message);
    }
}
