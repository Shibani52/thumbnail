<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function list()
    {
        // Your logic to fetch files or render a view
        return view('file.list');
    }
}
