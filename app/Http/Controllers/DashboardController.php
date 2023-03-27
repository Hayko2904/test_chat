<?php

namespace App\Http\Controllers;

use App\Http\Repositories\RoomRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @var RoomRepository
     */
    private $roomRepository;

    /**
     * DashboardController constructor.
     * @param RoomRepository $roomRepository
     */
    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $rooms = $this->roomRepository->getAll();

        return view('dashboard', compact('rooms'));
    }
}
