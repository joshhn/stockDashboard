<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
  public function register(Request $request)
  {
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
      ]);

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
      ]);

      Auth::login($user);
      $token = $request->user()->createToken(time());

      return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'token' => $token->plainTextToken
      ], JsonResponse::HTTP_CREATED);
    }

  public function login(Request $request) {
      $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
      ]);

      if (Auth::attempt($validated)) {
        $token = $request->user()->createToken(time());
        return response()->json([
          'id' => Auth::user()->id,
          'name' => Auth::user()->name,
          'email' => Auth::user()->email,
          'token' => $token->plainTextToken
        ], JsonResponse::HTTP_OK);
      }

      return response()->json(['error' => 'Wrong Credentials'], JsonResponse::HTTP_BAD_REQUEST);
  }

  public function logout(Request $request) {
    $user = $request->user();

    Auth::logout();

    if ($user) {
        $user->currentAccessToken()->delete();
    }

    return response()->json(['message' => 'Logout Success'], JsonResponse::HTTP_OK);
  }
}
