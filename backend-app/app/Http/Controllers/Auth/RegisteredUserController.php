<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'rank' => '[`profiled`]',
            // 'institution_id' =>  $institution->id,
            'password' => bcrypt($request->password),
            'password_changed_at' => Carbon::now(),
        ]);
        event(new Registered($user));
        Auth::login($user);
        return response()->noContent();
    }

    public function updateUser(Request $request){
        // Validate the request data
        $validatedData = $request->validate([
            'first_name' => 'min:3|max:255',
            'middle_name' => 'min:3|max:255',
            'last_name' => 'min:3|max:255',
            'phone_number' => 'min:3|max:255',
            'uid' => 'required|string|max:255',
        ]);
            // Find the user by ID
        $user = User::where('uid', $validatedData['uid'])->first();

        // Update the user's fields
        $user->first_name = $validatedData['first_name'];
        $user->middle_name = $validatedData['middle_name'];
        $user->last_name = $validatedData['last_name'];
        $user->phone_number = $validatedData['phone_number'];
        // Save the changes
        $user->save();
        // Return a response
        return response()->json([
            'message' => 'User updated successfully!',
        ]);
    }

    public function changePassword(Request $request){
        // Validate the request data
        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'uid' => 'required|string|max:255',
        ]);

        // Get the currently authenticated user
        $user = User::where('uid', $validatedData['uid'])->first();

        // Check if the current password matches
        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return response()->json([
                'message' => 'The current password is incorrect.',
            ], 422);
        }
        // Update the password
        $user->password = bcrypt($validatedData['new_password']);
        $user->save();

        // Return a success response
        return response()->json([
            'message' => 'Password changed successfully!',
        ]);
    }


}
