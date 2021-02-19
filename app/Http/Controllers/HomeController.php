<?php

namespace App\Http\Controllers;

use App\Facades\NoteService;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {

        return view('home');
    }

}
