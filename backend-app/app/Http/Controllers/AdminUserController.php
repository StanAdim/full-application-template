<?php

namespace App\Http\Controllers;

use App\Http\Resources\SystemUserResource;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    //
    public function userList(Request $request){
        // Fetch the search term from the request (optional)
        $search = $request->input('search');
        $perPage = $request->input('per_page', 12); // Default items per page is 12
        // Build the query for fetching users
        $query = User::query()->orderBy('created_at', 'desc');
        // Apply search if there is a search term
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('firstName', 'like', "%{$search}%")
                ->orWhere('lastName', 'like', "%{$search}%")
                ->orWhere('middleName', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
                // Add other fields for search if needed
            });
        }
        // Paginate the results
        $users = $query->paginate($perPage);
        if ($users->isNotEmpty()) {
            return response()->json([
                'message' => "Application Users",
                'data' => SystemUserResource::collection($users),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                    'next_page_url' => $users->nextPageUrl(),
                    'prev_page_url' => $users->previousPageUrl(),
                ],
                'code' => 200,
            ]);
        }

        return response()->json([
            'message' => "No users found",
            'code' => 300,
        ]);
    }
}
