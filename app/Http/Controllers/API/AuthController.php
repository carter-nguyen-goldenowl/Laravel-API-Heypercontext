<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserInterface $userInterface)
    {
        $this->userRepository = $userInterface;
    }
    public function register(RegisterRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $data['link_avt'] = 'https://res.cloudinary.com/carternguyen/image/upload/v1653914818/hypercontext/default_avatar_b1zbtn.png';
        $user = $this->userRepository->store($data);

        return response()->json([
            'status' => 200,
            'email' => $user->email,
            'message' => 'Registered Successfully',
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->userRepository->checkEmail($request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        } else {
            $token = $user->createToken($user->email . 'token-name')->plainTextToken;
            return response()->json([
                'status' => 200,
                'username' => $user->name,
                'user_id' => $user->id,
                'token' => $token,
                'link_avt' => $user->link_avt,
                'message' => 'Logged In Successfully',
            ]);
        }
    }

    public function logout()
    {
        request()->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'logged out'
        ]);
    }
}
