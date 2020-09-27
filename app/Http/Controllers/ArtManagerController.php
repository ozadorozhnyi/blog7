<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('art-manager', [
            'page' => __FUNCTION__
        ]);
    }
}
