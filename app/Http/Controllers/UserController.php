<?php

namespace App\Http\Controllers;

use App\Influencer;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->q;
        $isAdmin = $request->isAdmin;
        $users = User::where(function ($q) use ($keyword) {
            $q->orWhere('first_name', 'LIKE', "%$keyword%")
                ->orWhere('last_name', 'LIKE', "%$keyword%")
                ->orWhere('tel', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('line_user_id', 'LIKE', "%$keyword%");
        })->where(function ($q) use ($isAdmin) {
            if ($isAdmin) {
                $q->where('role', 'admin');
            }
        })->latest()->paginate(10);
        $count = User::where(function ($q) use ($isAdmin) {
            if ($isAdmin) {
                $q->where('role', 'admin');
            }
        })->count();

        return [
            "users" => $users,
            "count" => $count
        ];
    }

    public function store(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->update([
                'role' => 'admin'
            ]);
        } else {
            $req = $request->all();
            $req['role'] = 'admin';
            $req['password'] = bcrypt($req['password']);
            $user = User::create($req);
        }

        return 'ok';
    }

    public function del(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        $user->role = 'old_admin';
        $user->save();
        return 'remove admin success';
    }
    public function checkRegistered(Request $request)
    {
        $find2 = false;
        $find = User::where('line_user_id', $request->line_user_id)->first();
        $isRegistered = $find ? true : false;
        if ($find) {
            $find2 = Influencer::where('user_id', $find->id)->first();
        }

        return response()->json([
            'message' => '',
            'result' => [
                'isRegistered' =>  $isRegistered,
                'isRegisteredF' =>  $find2 ? true : false

            ],
        ]);
    }

    public function user($userID, Request $request)
    {
        $find = User::where('line_user_id', $userID)->first();

        return response()->json([
            'message' => 'load user success',
            'result' => [
                'user' => $find ?  $find : null
            ],
        ]);
    }

    public function register(Request $request)
    {


        $messages = [
            'first_name.required' => 'กรุณากรอก ชื่อจริง',
            'last_name.required' => 'กรุณากรอก นามสกุล',
            'email.required' => 'กรุณากรอก อีเมล',
            'tel.required' => 'กรุณากรอก เบอร์โทรศัพท์',
            'email.unique' => 'อีเมลนี้ถูกใช้งานแล้ว',
            'tel.unique' => 'เบอร์โทรศัพท์นี้ถูกใช้งานแล้ว',
        ];
        $validatedData = $this->validate(
            $request,
            [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'tel' => 'required|max:12|unique:users',
            ],
            $messages
        );


        $req = $request->all();
        $req['password'] = bcrypt(time());

        $user = User::create($req);

        if (!$user) {
            return 'failed';
        }

        return response()->json([
            'message' => 'Register Success',
        ]);
    }

    public function update(Request $request)
    {

        $user = User::where('line_user_id', $request->line_user_id)->first();

        if ($request->email && $request->tel) {
            $messages = [
                'email.unique' => 'อีเมลนี้ถูกใช้งานแล้ว',
                'tel.unique' => 'เบอร์โทรศัพท์นี้ถูกใช้งานแล้ว',
            ];
            $validatedData = $this->validate(
                $request,
                [
                    'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                    'tel' => 'required|max:12|unique:users,tel,' . $user->id,
                ],
                $messages
            );
        }



        $req = $request->all();
        $req['password'] = bcrypt(time());

        $update =  $user->update($req);

        if (!$update) {
            return 'failed';
        }

        return response()->json([
            'message' => 'Register Success',
        ]);
    }
}