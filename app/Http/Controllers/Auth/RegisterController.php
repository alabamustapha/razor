<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\Welcome;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [

            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'aff_fname' => 'required|string|max:255',
            'aff_lname' => 'required|string|max:255',
            'aff_company' => 'required|string|max:255',
            'aff_adresse' => 'required|string|max:255',
            'aff_city' => 'required|string|max:255',
            'aff_zip' => 'required|string|max:255',
            'aff_tel' => 'required|string|max:255',
            'aff_orias' => 'required|string|max:255',
            'aff_message' => 'required|string|max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'aff_link' => $data['aff_link'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'aff_fname' => $data['aff_fname'],
            'aff_lname' => $data['aff_lname'],
            'aff_civility' => $data['aff_civility'],
            'aff_company' => $data['aff_company'],
            'aff_adresse' => $data['aff_adresse'],
            'aff_city' => $data['aff_city'],
            'aff_zip' => $data['aff_zip'],
            'aff_tel' => $data['aff_tel'],
            'aff_orias' => $data['aff_orias'],
            'aff_message' => $data['aff_message'],
            'aff_status_approved' => $data['aff_status_approved'],
        ]);



        \Mail::to($user)->send(New Welcome($user));

        return $user;

    }



}
