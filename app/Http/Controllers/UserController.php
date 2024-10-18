<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //--index
    public function index()
    {
        return view('welcome');
    }
    //--users
    public function users()
    {
        return view('users');
    }
    //--invoice
    public function invoice()
    {
        return view('invoice');
    }
}
