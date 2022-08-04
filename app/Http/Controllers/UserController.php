<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'password_repeat' => 'required|same:password'
        ]);


        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $password_repeat = $request->input('password_repeat');

        User::insert([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_repeat' => $password_repeat
        ]);

        $response = [
            'message'  => 'the user has been registered',
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_repeat' => $password_repeat
        ];

        return response()->json($response, 200);

    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        Session::put('credentials', $credentials);

        return response()->json([
            'message' => 'you are logged in',
            'credentials' => Session::get('credentials')
        ], 200);
    }

    public function updateUser(Request $request, $id){
        $user = User::find($id);
        if(is_null($user)){
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user->update($request->all());
        return response($user, 200);
    }

    public function getUsers(){
        return response()->json(User::all(), 200);
    }

    public function getUserById($id){
        $user = User::find($id);
        if(is_null($user)){
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json($user::find($id), 200);
    }

    public function deleteUser(Request $request, $id){
        $user = User::find($id);
        if(is_null($user)){
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User successfully deleted'], 200);
    }
}
