<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WebNotificationController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }
    public function index()
    {
        return view('home');
    }

    public function storeToken(Request $request)
    {
        $user = auth()->user();
        $user->device_key = $request->token;
        $user->save();
        return response()->json(['Token successfully stored.']);
    }

    public function sendWebNotification(Request $request)
    {
        try {
            $firebaseToken = User::whereNotNull('device_key')->pluck('device_key')->all();

            $SERVER_API_KEY = 'AAAANwotQyw:APA91bEYE-SYzqujDPdXvDqODpWZz6G2tY1r2ksaMqd6Vj6t4lq5wZmvkkwqOyBNb7tjfteSzCmn-ao9s1fbNS5RfSicNzPbZGpmmUuswIzcWYHe4SjGnwP535k_XXC-Dvrp8ZRNe13J';

            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "title" => $request->title,
                    "body" => $request->body,
                ]
            ];
            $dataString = json_encode($data);

            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            $response = curl_exec($ch);
            return 'success';
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
