<?php

namespace App\Http\Controllers;

use App\Models\Archivetask;
use Illuminate\Http\Request;

class ArchivetaskController extends Controller
{
    public function archivetasks()
    {
        $tasks = Archivetask::all();
        return view('archive.tasks',compact('tasks'));
    }
}
