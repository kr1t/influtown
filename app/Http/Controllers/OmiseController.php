<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OmiseCharge;

use Carbon\Carbon;
use App\Payment;
use App\User;
use App\Influencer;
use Helpers\LineBot;

class OmiseController extends Controller
{
    public function billDetail(Request $request)
    {
        $paymentCount = 'IF' . str_pad(Payment::count() + 1, 6, '0', STR_PAD_LEFT);

        return [
            "id" => $paymentCount,
            "today_t" => Carbon::now()->format('d/m/Y H:m'),
            "expiry_t" => Carbon::now()->addDays(30)->format('d/m/Y H:m'),
            "today" => Carbon::now()->format('Y-m-d H:i:s'),
            "expiry" => Carbon::now()->addDays(30)->format('Y-m-d H:i:s')
        ];
    }
    public function payment(Request $request)
    {

        define('OMISE_PUBLIC_KEY', 'pkey_test_5mlsbndpjaph300tsz3');
        define('OMISE_SECRET_KEY', 'skey_test_5mlsbndpk0g0cq6k28i');

        $user = User::whereLineUserId($request->userId)->first();
        $bot = new LineBot(env('LINE_MESSAGING_TOKEN'));
        $bot->setUser($request->userId);
        $req = $request->all();

        $req['user_id'] = $user->id;
        $charge = OmiseCharge::create([
            "amount" => $request->amount,
            "currency" => "thb",
            "card" => $request->token
        ]);

        $pay = Payment::create($req);
        $d = Influencer::whereUserId($user->id)->update([
            "expiry" => $req['expiry']
        ]);

        $bot->addText("ทำการชำระบิล {$req['bId']} สำเร็จ\nบัญชีของคุณจะหมดอายุ: {$req['expiry_t']}")->push();
        return $d;
    }
}