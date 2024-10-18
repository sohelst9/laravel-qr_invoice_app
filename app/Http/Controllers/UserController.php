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
    public function invoice(Request $request)
    {
        $uniqueId = $request->input('unique_id');
        $user = User::where('unique_id', $uniqueId)->first();
        if ($user) {
            if (!$user->checked) {
                $user->checked = true;
                $user->save();
                return response()->json(['message' => 'User checked successfully.']);
            } else {
                return response()->json(['message' => 'User already checked.'], 400);
            }
        }

        return response()->json(['message' => 'User not found.'], 404);
    }
    //--scan
    public function scan($id) {}
}
