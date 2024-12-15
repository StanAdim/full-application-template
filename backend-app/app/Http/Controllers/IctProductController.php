<?php

namespace App\Http\Controllers;

use App\Http\Resources\ICTProductResource;
use App\Models\IctProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IctProductController extends Controller
{
    // List all ICT Products
    public function index(Request $request){
        // Fetch the search term from the request (optional)
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default items per page is 10
    
        // Build the query for fetching items
        $user_id = Auth::id();
        $user = User::find($user_id);
    
        if ($user->hasRole('admin')) {
            $query = IctProduct::orderBy('id', 'desc'); // Remove ->get() to keep it as a query builder
        } else {
            $query = IctProduct::where('user_id', $user_id)->orderBy('id', 'desc');
        }

        // Apply search if there is a search term
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
    
        // Paginate the results
        $items = $query->paginate($perPage);
    
        if ($items->isNotEmpty()) {
            return response()->json([
                'message' => "Registered projects",
                'data' => ICTProductResource::collection($items),
                'pagination' => [
                    'current_page' => $items->currentPage(),
                    'last_page' => $items->lastPage(),
                    'per_page' => $items->perPage(),
                    'total' => $items->total(),
                    'next_page_url' => $items->nextPageUrl(),
                    'prev_page_url' => $items->previousPageUrl(),
                ],
                'code' => 200,
            ]);
        }
    
        return response()->json([
            'message' => "No project found",
            'data' => [],
            'code' => 300,
        ]);
    }

    // Store a new ICT Product
    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|array',
            'is_launched' => 'required|boolean',
            'launched_date' => 'nullable|date|before_or_equal:today',
            'description' => 'required|string|max:1000',
            // 'technicalSpecs' => 'nullable|string|max:1000',
            // 'targetAudience' => 'nullable|string|max:1000',
            // 'intellectualProp' => 'nullable|string|max:1000',
            // 'supportingMedia' => 'nullable|array',
            // 'supportingMedia.*' => 'nullable|url',
            'users_impression' => 'nullable|integer',
            'compliance_details' => 'nullable|string|max:1000',
         ]);
         $user= Auth::user();
        $profile_id = $user->profile->id;
        $validatedData = $validatedData + ['user_id' => $user->id,'profile_id' => $profile_id];
        $product = IctProduct::create($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Registration success!',
            'data' => $product,
        ], 201);
    }

    public function count(){
        $user_id = Auth::id();
        $user = User::find($user_id);
        if ($user->hasRole('admin')) {
            $Items = IctProduct::all();
        }else{
            $Items = IctProduct::where('user_id', $user_id)->get();
        }
        if ($Items) {
            return response()->json([
                'message' => 'Products count',
                'count' => $Items->count()
            ],200);
        } 
   }
    // Show a single ICT Product
    public function show($uid){
        $product = IctProduct::where('uid',$uid)->first();
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found!',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    // Update an existing ICT Product
    public function update(Request $request)
    {
        $product = IctProduct::where($request->input('uid'))->first();

        $validator = Validator::make($request->all(),[
           'name' => 'max:255',
            'category' => 'array',
            'is_launched' => 'boolean',
            'launched_date' => 'nullable|date|before_or_equal:today',
            'description' => 'string|max:1000',
            // 'technicalSpecs' => 'nullable|string|max:1000',
            // 'targetAudience' => 'nullable|string|max:1000',
            // 'intellectualProp' => 'nullable|string|max:1000',
            // 'supportingMedia' => 'nullable|array',
            // 'supportingMedia.*' => 'nullable|url',
            'users_impression' => 'nullable|integer',
            'compliance_details' => 'nullable|string|max:1000',
        ]);
        $validator->validate();
        if($validator->valid()){
            $save = $product->update($validator->validated());
        }
        return response()->json([
            'data' => $save,
            'message' => 'Product Updated!',
        ], 200);
    }

    // Delete an ICT Product
    public function destroy($uid){
        $product = IctProduct::where( 'uid', $uid)->first();
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found!',
            ], 404);
        }
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully!',
        ]);
    }
}
