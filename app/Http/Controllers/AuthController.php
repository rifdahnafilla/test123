<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        //menangkap inputan
        $input = [
            'name'=> $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password)
        ];

        //menginstert data ke tabel user 
        $user = User::create($input);
        $data =[
            'message' => 'User is created successfully'
        ];

        //mengirim respone json
        return response()->json($data, 200);
    }

    public function login(Request $request)
  {
  $input = [
      'email' => $request->email,
      'password' => $request->password
    ];
$user = User::where('email', $input['email'])->first();
$isLoginSuccessfully = ($input['email'] == $user->email
      &&
      Hash::check($input['password'], $user->password));
    if ($isLoginSuccessfully) {
 $token = $user->createToken('auth_token');
      $data = [
        'message' => 'Login successfully',
        'token' => $token->plainTextToken
      ];
return response()->json($data, 200);
    } else {
      $data = [
        'message' => 'Username or Password is Wrong'
      ];
      return response()->json($data, 401);
    }
  }
}
