<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
  public function register(Request $request)
  {
    try {
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

      return response()->json(['message' => 'User Created'], JsonResponse::HTTP_CREATED);
      
    } catch (ValidationException $err) {
      return response()->json(['error' => $err->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    } catch (Exception $err) {
      return response()->json(['error' => $err->errors()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function login(Request $request) {
      $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
      ]);

      if (Auth::attempt($validated)) {
        $token = $request->user()->createToken(time());
        return response()->json(['message' => 'Login Success', 'token' => $token->plainTextToken], JsonResponse::HTTP_OK);
      }

      return response()->json(['error' => 'Wrong Credentials'], JsonResponse::HTTP_BAD_REQUEST);
  }

  public function logout(Request $request) {
    Auth::logout();
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Logout Success'], JsonResponse::HTTP_OK);
  }
}
