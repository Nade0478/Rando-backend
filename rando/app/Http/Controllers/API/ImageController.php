<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Hello from ImageController']);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/uploads', $filename);
        $url = Storage::url($path);

        $image = Image::create([
            'filename' => $filename,
            'path' => $path,
            'url' => $url,
        ]);

        return response()->json([
            'message' => 'Image uploaded successfully',
            'filename' => $filename,
            'url' => $url,
            'id' => $image->id,
        ]);
    }
}
