<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function registered(Request $request, User $user)
    {
        if ($user instanceof MustVerifyEmail) {
            $user->sendEmailVerificationNotification();

            return response()->json(['status' => trans('verification.sent')]);
        }

        return response()->json($user);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $messages = [
            'first_name.required' => 'กรุณากรอก ชื่อจริง',
            'first_name.max' => 'กรุณากรอก ชื่อจริง 255',
            'last_name.required' => 'กรุณากรอก นามสกุล',
            'email.unique' => 'กรุณากรอก อีเมลอื่นๆ'

        ];
        return Validator::make(
            $data,
            [
                'first_name' => 'required|max:20',
                'last_name' => 'required|max:255',
                'tel' => 'required|max:13|min:9',
                'zipcode' => 'required|max:255',
                'address' => 'required|max:255',
                'city' => 'required|max:255',
                'province' => 'required|max:255',
                'line_user_id' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
            ],
            $messages
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'zipcode' => $data['zipcode'],
            'address' => $data['address'],
            'tel' => $data['tel'],

            'city' => $data['city'],
            'province' => $data['province'],
            'line_user_id' => $data['line_user_id'],
            'email' => $data['email'],
            'password' => bcrypt('123456'),
        ]);
    }
}
