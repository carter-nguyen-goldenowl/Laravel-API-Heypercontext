<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'min:6|required_with:confirm_password|same:confirm_password',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'validator_errors' => $validator->getMessageBag(),
            ]);
        } else {
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            $data['link_avt'] = 'https://res.cloudinary.com/carternguyen/image/upload/v1653914818/hypercontext/default_avatar_b1zbtn.png';
            $this->userRepository->store($data);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Registered Successfully',
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|max:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validator_errors' => $validator->getMessageBag(),
            ]);
        } else {
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
                    'token' => $token,
                    'link_avt' => $user->link_avt,
                    'message' => 'Logged In Successfully',
                ]);
            }
        }
    }

    public function logout(Request $request)
    {
        // auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'logged out'
        ]);
    }

    public function getUser()
    {
        return $this->userRepository->getUser();
    }
}
