<?php

namespace App\Http\Controllers;

use App\Models\Categories\AcceleratorProfile;
use App\Models\Categories\HubProfile;
use App\Models\Categories\Profile;
use App\Models\Categories\StartupProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller{
    /**
     * Create a profile for a user.
     */
    //  User registartiona with His profile
    public function registerUserWithProfile(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'string|max:255',
        'last_name' => 'required|string|max:255',
        'user_phone' => 'required|string|max:255',
        'user_email' => 'required|email|max:255|unique:users,email',
        'phone_number' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'required|string|min:8',
        'profile_type' => 'required|string|in:startup,hub,accelerator,grassroot_programme',
        // Include additional fields based on profile type
        'phone_number' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'region_location' => 'string|max:255',
        'date_establishment' => 'required|string|max:255',
        // Starups
        'startup_name' => 'required_if:profile_type,startup|string|max:255',
        'industry' => 'required_if:profile_type,startup|string|max:255',
        'description' => 'required_if:profile_type,startup|string|max:500',
        'website' => '',
        'funding_stage' => 'required_if:profile_type,startup|string|max:255',
        'team_size' => 'required_if:profile_type,startup|string|max:255',
        'founders' => 'required_if:profile_type,startup|array', // Validate founders as an array
        // Hubs
        'hub_name' => 'required_if:profile_type,hub|string|max:255',
        'brief' => 'required_if:profile_type,hub|string|max:500',
        'membership_option' => 'required_if:profile_type,hub|string|max:255',
        // 'partnerships' => 'required_if:profile_type,hub|string|max:255',
        'number_female' => 'required_if:profile_type,hub|integer',
        'total_members' => 'required_if:profile_type,hub|integer',
        'available_programs' => 'required_if:profile_type,hub|array', // Validate founders as an array


        // Accelerator
        'accelerator_name' => 'required_if:profile_type,accelerator|string|max:255',
        'focus_area' => 'required_if:profile_type,accelerator|string|max:255',
    ]);

    DB::beginTransaction();

    try {
        // Create the user
        $user = User::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'phone_number' => $validated['user_phone'],
            'rank' => 'profiled',
            'email' => $validated['user_email'],
            'password' => bcrypt($validated['password']),
        ]);
        // $user->assignRole(['user', '']);
        $user->assignRole(['user']);
        // Create the specific profile type
        switch ($validated['profile_type']){
            case 'startup':
                $profileCategory = StartupProfile::create([
                    'startup_name' => $validated['startup_name'],
                    'industry' => $validated['industry'],
                    'description' => $validated['description'],
                    'funding_stage' => $validated['funding_stage'],
                    'team_size' => $validated['team_size'],
                    'founders' => $validated['founders'],
                    'website' => $validated['website'],
                ]);
                break;

            case 'hub':
                $profileCategory = HubProfile::create([
                    'hub_name' => $validated['hub_name'],
                    'total_members' => $validated['total_members'],
                    'number_female' => $validated['number_female'],
                    // 'partnerships' => $validated['partnerships'],
                    'membership_option' => $validated['membership_option'], // free or paid
                    'available_programs' => $validated['available_programs'],
                    'brief' => $request->input('brief', ''),
                ]);
                break;

            case 'accelerator':
                $profileCategory = AcceleratorProfile::create([
                    'accelerator_name' => $validated['accelerator_name'],
                    'focus_area' => $validated['focus_area'],
                    'description' => $request->input('description', ''),
                ]);
                break;
        }
        Log::info(['User: '=> $user->id]);
        // Create the profile and associate it with the user and the profileCategory model
        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->phone_number = $validated['phone_number'];
        $profile->email = $validated['email'];
        $profile->region = $validated['region_location'];
        $profile->date_establishment = $validated['date_establishment'];
        $profile->profileable()->associate($profileCategory);
        $profile->save();
        DB::commit();
        return response()->json([
            'message' => 'Registration Success.',
            // 'user' => $user,
            // 'profile' => $profile,
            // 'profileable' => $profileCategory,
        ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Registration failed.', 'error' => $e->getMessage()], 500);
     }
    }
    /**
     * Retrieve a user's profile.
     */
    public function show(User $user)
    {
        $user->load('profile.profileable');
        if (!$user->profile) {
            return response()->json(['message' => 'No profile found for this user.'], 404);
        }
        return response()->json([
            'user' => $user,
            'profile' => $user->profile,
            'profileable' => $user->profile->profileable,
        ]);
    }

    /**
     * Update a user's profile.
     */
    public function update(Request $request, User $user){
        $profile = $user->profile;
        if (!$profile) {
            return response()->json(['error' => 'No profile to update.'], 404);
        }
        $profileable = $profile->profileable;
        // Determine the type and update accordingly
        if ($profileable instanceof StartupProfile) {
            $request->validate([
                'startup_name' => 'sometimes|required|string|max:255',
                'industry' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $profileable->update($request->only(['startup_name', 'industry', 'description']));
        } elseif ($profileable instanceof HubProfile) {
            $request->validate([
                'hub_name' => 'sometimes|required|string|max:255',
                'location' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $profileable->update($request->only(['hub_name', 'location', 'description']));
        } elseif ($profileable instanceof AcceleratorProfile) {
            $request->validate([
                'accelerator_name' => 'sometimes|required|string|max:255',
                'focus_area' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $profileable->update($request->only(['accelerator_name', 'focus_area', 'description']));
        }
        return response()->json(['message' => 'Profile updated successfully.', 'profile' => $profile->load('profileable')]);
    }
    public function destroy(User $user){
        $profile = $user->profile;
        if (!$profile) { return response()->json(['error' => 'No profile to delete.'], 404);} 
        $profile->delete();
        return response()->json(['message' => 'Profile deleted successfully.']);
    }
    public function create(Request $request, User $user){
        // Validate common profile data
        $request->validate([
            'type' => 'required|in:startup,hub,accelerator',
            // Add other common validations if any
        ]);
        $type = strtolower($request->input('type'));
        // Depending on the type, validate and create the specific profile
        switch ($type) {
            case 'startup':
                $request->validate([
                    'startup_name' => 'required|string|max:255',
                    'industry' => 'required|string|max:255',
                    'description' => 'nullable|string',
                ]);

                $profileable = StartupProfile::create($request->only(['startup_name', 'industry', 'description']));
                break;

            case 'hub':
                $request->validate([
                    'hub_name' => 'required|string|max:255',
                    'location' => 'required|string|max:255',
                    'description' => 'nullable|string',
                ]);

                $profileable = HubProfile::create($request->only(['hub_name', 'location', 'description']));
                break;

            case 'accelerator':
                $request->validate([
                    'accelerator_name' => 'required|string|max:255',
                    'focus_area' => 'required|string|max:255',
                    'description' => 'nullable|string',
                ]);

                $profileable = AcceleratorProfile::create($request->only(['accelerator_name', 'focus_area', 'description']));
                break;

            default:
                return response()->json(['error' => 'Invalid profile type.'], 400);
        }

        // Create the base profile and associate it
        $profile = new Profile();
        $profile->user()->associate($user);
        $profile->profileable()->associate($profileable);
        $profile->save();

        return response()->json([
            'message' => 'Profile created successfully.',
            'profile' => $profile->load('profileable'),
        ], 201);
    }
}
