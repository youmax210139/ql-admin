<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function show($file)
    {
        if (!Storage::disk('local')->exists($file)) {
            abort(404);
        }

        $local_path = config('filesystems.disks.local.root') . DIRECTORY_SEPARATOR . $file;

        return response()->file($local_path);
    }
}
