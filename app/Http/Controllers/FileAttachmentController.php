<?php

namespace App\Http\Controllers;

use App\Models\FileAttachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FileAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileAttachment  $fileAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(FileAttachment $fileAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileAttachment  $fileAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(FileAttachment $fileAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FileAttachment  $fileAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FileAttachment $fileAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileAttachment  $fileAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileAttachment $fileAttachment)
    {
        //
    }

    public function uploadFiles(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpeg,png,jpg,gif,pdf,mp4,mov,pdf',
        ]);

        $file = $request->file('file');
        $fileName = $this->generateFileName($file);
        $path = 'File Attachments/Newsfeed-files';
        $fileAttachment = FileAttachment::create([
            'file_path' => $path,
            'file_type' => $file->extension(),
            'file_name' => $fileName,
            'data' => null,
        ]);
        Storage::disk('public')->putFileAs($path, $file, $fileName);

        return response()->json([
            'file_attachment_id' => $fileAttachment->id,
            'success' => $fileName,
        ]);
    }

    public function generateFileName($file)
    {
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        if(FileAttachment::where('file_name', $fileName)->exists()){
            return $this->generateFileName($file);
        }else{
            return $fileName;
        }
    }
}
