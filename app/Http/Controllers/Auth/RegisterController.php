<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helpers;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/';

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
            'username' => ['required', 'string', 'min:5', 'max:25', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:25', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $IDGenerator  = Helpers::IDGenerator(new User,'user_id', 3, "ADM-", 'A');
        $result = array('status' => 1, 'message' => 'success');

        $user = new User();
        $user->username = $data['username'];
        $user->user_id = $IDGenerator;
        $user->password = Hash::make($data['password']);
        $user->save();
        

        return $result;

        // return User::create([
        //     'username' => $data['username'],
        //     'user_id' =>  rand(100,1000),
        //     'password' => Hash::make($data['password']),
        // ]);
    }
}
