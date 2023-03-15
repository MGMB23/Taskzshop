<?php

namespace App\Http\Controllers;

use App\Models\Archiveuser;
use Illuminate\Http\Request;

class ArchiveuserController extends Controller
{
    public function archiveusers()
    {
        $users = Archiveuser::all();
        return view('archive.users',compact('users'));
    }
}
