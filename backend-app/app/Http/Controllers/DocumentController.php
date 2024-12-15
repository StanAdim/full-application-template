<?php

namespace App\Http\Controllers;

use App\Http\Resources\DocumentResource;
use App\Models\Categories\Profile;
use App\Models\Document;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $destinationPath;
    public function __construct(){
        $this->destinationPath = '/documents';
    }
    public function docUpload(Request $request): \Illuminate\Http\JsonResponse {
        // Validate the request
        $request->validate([
            'document' => 'required|extensions:pdf', // less 2MB
            'type_id' => 'required', //
            'name' => 'required', //
            'profile_id' => 'required', //
        ]);
        DB::beginTransaction();
        try {
            $profile_id = Profile::where('uid', $request->profile_id)->first()->id;
            if (!($request->document instanceof \Illuminate\Http\UploadedFile)) {
                return response()->json(['message' => "Attachment not found"], 400);
            }
            $file = $request->file('document');
            $filename =  time() . '_' .str_replace(' ', '',$file->getClientOriginalName());
            $filename = $file->storeAs('documents', $filename, 'local');
            $user_id = Auth::id();
            $document = new Document();
            $document->document_type_id = $request->type_id;
            $document->user_id = $user_id;
            $document->profile_id = $profile_id;
            $document->file_name = preg_replace('/\s+/', '-',$request->name.' '.$file->getClientOriginalName()) ;
            $document->path = $filename;
            $document->save();
            DB::commit();
            return response()->json(['message' => 'File Uploaded successfully'], 200);
        } catch (Exception $e) {
            Db::rollBack();
            Log::error($e);
            return response()->json(['message' => "Failed to upload"], 400);
        }
    }
    public function index(Request $request): \Illuminate\Http\JsonResponse {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default items per page is 10

        // Build the query for fetching items
        $user_id = Auth::id();
        $user = \App\Models\User::find($user_id);

        if ($user->hasRole('admin')) {
            $query = Document::orderBy('id', 'desc'); // Remove ->get() to keep it as a query builder
        } else {
            $query = Document::where('user_id', $user_id)->orderBy('id', 'desc');
        }

        // Apply search if there is a search term
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%");
            });
        }
        // Paginate the results
        $items = $query->paginate($perPage);
        if ($items->isNotEmpty()) {
            return response()->json([
                'message' => "Documents",
                'data' => DocumentResource::collection($items),
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
            'message' => "No Document found",
            'code' => 300,
        ]);    }
    //Get Document public
    public function getDocumentByName($name){
        $data = Document::where('name', $name);
        $exists = $data -> exists();
        if($exists){
            $file_name  =  $data->first()->path;
            if (!Storage::disk('local')->exists($file_name)) {
                abort(404);
            }
            $pdfPath = storage_path('app/'. $file_name);
            return response()->file($pdfPath);
        }
        return response()->json(['message' => 'File not found'], 500);
    }
    //Update
    public function updateStatus($id) {
        $dataTgt = Document::findOrFail($id);
        $dataTgt->status = !$dataTgt->status;
        $dataTgt->save();
        return response()->json(['message' => 'Status updated successfully'], 200);
    }
    // Delete
    public function destroy($id){
        $supportRequest = Document::findOrFail($id);
        Storage::disk('local')->delete($supportRequest->path);
        // Delete the record from the database
        $supportRequest->delete();
        return response()->json(['message' => 'Event Doc deleted successfully'], 200);
    }
    public function previewDocument(Request $request)
    {
        $file_name = $request->name;
        if ($file_name == null) {
            abort(404);
        }

        if (!Storage::disk('local')->exists($file_name)) {
            abort(404);
        }
        $pdfPath = storage_path('app/'. $file_name);
        return response()->file($pdfPath);
    }
}
