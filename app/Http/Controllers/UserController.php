<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $qrCode = QrCode::size(100)->generate($user->unique_id);

        return view('invoice', compact('user', 'qrCode'));
    }
    //--scan
    public function scan(Request $request)
    {
        $uniqueId = $request->input('unique_id');
        $user = User::where('unique_id', $uniqueId)->first();
        if ($user) {
            if ($user->status == 'unchecked') {
                $user->status = 'checked';
                $user->save();;
                return 'User checked successfully.';
            } else {
                return 'User already checked.';
            }
        }

        return 'User not found.';
    }
    //--invoicepdf

    public function invoicepdf($id)
    {
        $user = User::findOrFail($id);
        $qrCode = QrCode::format('png')->size(100)->generate($user->unique_id);

        $image = Image::make($qrCode);

        // Save QR code image to public folder
        $qrCodePath = public_path('qr_code.png');
        $image->save($qrCodePath);

        $pdf = Pdf::loadView('invoice', compact('user', 'qrCodeImage'));

        return $pdf->download('invoice_' . $user->unique_id . '.pdf');
    }
}
