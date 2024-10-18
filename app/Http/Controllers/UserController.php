<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $users = User::take(10)->get();
        return view('users', compact('users'));
    }
    //--invoice
    public function invoice($id)
    {
        $user = User::findOrFail($id);
        $qrCode = QrCode::size(300)->generate($user->unique_id);
        return view('invoice', compact('user', 'qrCode'));
    }
}
