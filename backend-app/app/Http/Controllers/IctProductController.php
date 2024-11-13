<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResourceController;
use App\Models\IctProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IctProductController extends Controller
{
    public function index(Request $request){
        $accessPermissions = ["can_view_all_products"];
        $user = $request->user();
        if ($this->hasUserAccess($accessPermissions)) { // checking if logged in users has any permission in the passed array
           $products = ProductResourceController::collection(IctProduct::all());
            return response()->json([
                'message' => 'All Products',
                'data' => $products
            ],200);
        } else {
            return response()->json([
                'message' => 'User products',
                'data' => ProductResourceController::collection($user->products)
            ],200);
        }
    }
    public function guestViewProducts (){
        $products = ProductResourceController::collection(IctProduct::all());
            return response()->json([
                'message' => 'All products',
                'data' => $products
            ],200);
    }
    public function getProduct($uuid)
    {
        $accessPermissions = ["can_view_product"];
        if ($this->hasUserAccess($accessPermissions)) {
        $product = IctProduct::where('id',$uuid)->first();
        if ($product) {
            return response()->json([
                 'message' => 'ICT Product',
                 'data' => $product
             ],200);

        } else {
            return response()->json([
                'message' => 'No such Product',
            ],404);
        }
    }
   }

    // public function get_categories(){
    //     $category = projectcategoryResource::collection(ProjectCategory::all());
    //     return response()->json([
    //         'message' => 'Project Categories',
    //         'data' => $category
    //     ],200);
    //    }

    public function productStore(Request $request)
     {
        $accessPermissions = ["can_create_product"];
       if ($this->hasUserAccess($accessPermissions)) {
       $validatedData = $request->validate([
                     'user_id' => ['required'],
                     'name' => ['required','min:3', 'max:255'],
                     'brief' => ['required', 'max:255'],
                     'category' => ['required']
         ]);

        $product = IctProduct::create($validatedData);
        $product->save();

        return response()->json([
            'data' => $product,
            'message' => 'product Detailed Stored',
        ], 200);
    }
    else {
        return response()->json([
            'message' => 'No Access',
        ],200);
    }
   }


    public function verifyProduct(Request $request, IctProduct $product)
    {
        $accessPermissions = ["can_verify_product"];
        if ($this->hasUserAccess($accessPermissions)) {
            $product->update([
                "verify" => !$product->verify ? true : false
            ]);
            return response()->json([
                'data' => $product,
                'message' => 'Product Verified',
                ], 200);
        }
        else {
            return response()->json([
                'message' => 'No Access',
            ],200);
        }
    }

    public function productUpdate($UUID , Request $request){
        $accessPermissions = ["can_edit_project"];
        if ($this->hasUserAccess($accessPermissions)) {
        $proje = IctProduct::where('id', $UUID)->first();
                $validator = Validator::make($request->all(),
                [
                    'name' => ['max:255'],
                    'category' => [ 'max:255'],
                    'brief' => [ 'min:10'],
                ]);

                $validator->validate();
                if($validator->valid()){
                    $save = $proje->update($validator->validated());
                }
                return response()->json([
                    'data' => $save,
                    'message' => 'Product Updated!',
                ], 200);
        }
           else {
            return response()->json([
                'message' => 'No Access',
            ],200);
           }
      }

        public function productDelete($UUID){
            $accessPermissions = ["can_delete_product"];
            // $user = $request->user();
            if ($this->hasUserAccess($accessPermissions)) {

                $product = IctProduct::findOrFail($UUID);

             $product->delete();

             return response()->json([
                'message' => 'Product Deleted!',
            ], 200);
        }
        else {
            return response()->json([
                'message' => 'No Access',
            ],200);
           }
        }

        public function productExport() 
        {
        $accessPermissions = ["can_view_all_products"];
        // $user = $request->user();
        if ($this->hasUserAccess($accessPermissions)) {
            // return Excel::download(new ProjectExport, 'Projects.xlsx');
        }
        else {
            return response()->json([
                'message' => 'No Access',
            ],200);
           }
        }
   
}
