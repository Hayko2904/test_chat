<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * AuthController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return object
     */
    public function loginPage(): object
    {
        event(new SendMessage());
        Auth::logout();

        return view('login');
    }

    /**
     * @return object
     */
    public function registrationPage(): object
    {
        Auth::logout();

        return view('registration');
    }

    /**
     * @return object
     */
    public function logout(): object
    {
        Auth::logout();

        return view('login');
    }

    /**
     * @param RegistrationRequest $registrationRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function registration(RegistrationRequest $registrationRequest): object
    {
        $data = $registrationRequest->all();
        $data['password'] = bcrypt($data['password']);
        $this->userRepository->create($data);

        if (Auth::attempt($registrationRequest->only('email', 'password'))) {
            return redirect('dashboard');
        }

        return back();
    }

    /**
     * @param LoginRequest $loginRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(LoginRequest $loginRequest): object
    {
        if (Auth::attempt($loginRequest->only('email', 'password'))) {
            return redirect('dashboard');
        }

        return back();
    }
}
