<?php

namespace App\Http\Controllers;

use App\Http\Repositories\RoomRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $roomRepository;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function index()
    {
        $rooms = $this->roomRepository->getAll();

        return view('dashboard', compact('rooms'));
    }
}
