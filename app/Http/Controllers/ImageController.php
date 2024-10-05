<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageController extends Controller

{
    public function showFiles()
    {
        // Load files from the images directory
        $fileNames = $this->getFileNames();
        
        return view('file.list', compact('fileNames'));
    }

    public function processFiles(Request $request)
    {
        // Handle file upload
        if ($request->hasFile('file')) {
            $uploadedFiles = $request->file('file');
            $this->uploadFiles($uploadedFiles); // Process file upload
        }

        $selectedFiles = $request->input('selected_files');

        if (!$selectedFiles) {
            return redirect()->back()->with('error', 'No files selected.');
        }

        // Create thumbnails for selected files
        $processedFiles = $this->createThumbnails($selectedFiles);

        // Pass processed files to the view
        return view('file.list', [
            'fileNames' => $this->getFileNames(), // Preserve original files list
            'processedFiles' => $processedFiles,
        ]);
    }

    private function uploadFiles($files)
    {
        foreach ($files as $file) {
            // Define the path where the file will be stored
            $destinationPath = public_path('images');
            $fileName = $file->getClientOriginalName();

            // Move file to the 'images' directory
            $file->move($destinationPath, $fileName);
        }
    }

    private function createThumbnails(array $filenames)
    {
        $thumbnailDirectory = public_path('thumbnails');

        if (!File::exists($thumbnailDirectory)) {
            File::makeDirectory($thumbnailDirectory, 0755, true);
        }

        $processedFiles = [];

        foreach ($filenames as $filename) {
            $sourcePath = public_path('images/' . $filename);
            $destinationPath = $thumbnailDirectory . '/' . $filename;

            $img = Image::make($sourcePath);
            $img->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($destinationPath);

            $processedFiles[] = $filename;
        }

        return $processedFiles;
    }

    private function getFileNames()
    {
        $files = File::files(public_path('images'));
        $fileNames = [];

        foreach ($files as $file) {
            if (in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                $fileNames[] = $file->getFilename();
            }
        }

        return $fileNames;
    }
}


/*{
    public function showFiles()
    {
        // Load files from the images directory
        $files = File::files(public_path('images'));
        $fileNames = [];

        foreach ($files as $file) {
            if (in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                $fileNames[] = $file->getFilename();
            }
        }

        return view('file.list', compact('fileNames'));
    }

    public function processFiles(Request $request)
    {
        $selectedFiles = $request->input('selected_files');

        if (!$selectedFiles) {
            return redirect()->back()->with('error', 'No files selected.');
        }

        // Create thumbnails for selected files
        $processedFiles = $this->createThumbnails($selectedFiles);

        // Pass processed files to the view
        return view('file.list', [
            'fileNames' => $this->getFileNames(), // Preserve original files list
            'processedFiles' => $processedFiles,
        ]);
    }

    private function createThumbnails(array $filenames)
    {
        $thumbnailDirectory = public_path('thumbnails');

        if (!File::exists($thumbnailDirectory)) {
            File::makeDirectory($thumbnailDirectory, 0755, true);
        }

        $processedFiles = [];

        foreach ($filenames as $filename) {
            $sourcePath = public_path('images/' . $filename);
            $destinationPath = $thumbnailDirectory . '/' . $filename;

            $img = Image::make($sourcePath);
            $img->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($destinationPath);

            $processedFiles[] = $filename;
        }

        return $processedFiles;
    }

    private function getFileNames()
    {
        $files = File::files(public_path('images'));
        $fileNames = [];

        foreach ($files as $file) {
            if (in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                $fileNames[] = $file->getFilename();
            }
        }

        return $fileNames;
    }
}*/
