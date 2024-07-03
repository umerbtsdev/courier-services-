<?php

namespace App\Http\Controllers\Auth;

use App\Model\CityManagment\City;
use App\Model\Countries\Countries;
use App\Model\CustomerManagment\Customer;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
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
    protected $redirectTo = '/login';

    public function showRegistrationForm()
    {
        $cities = City::all();
        $countries = Countries::all();
        return view('auth.register', compact('cities','countries'));
    }
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        try{
            $users = new User();
            $users->name = $request->first_name." ".$request->last_name;
            $users->email = $request->email;
            $users->password  = bcrypt($request->password);
            $users->save();
            $user_id = $users->id;

            $customer = new Customer();
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->email = $request->email;
            $customer->country_id = $request->country_id;
            $customer->contact_no = $request->contact_no;
            $customer->alernate_no = $request->alernate_no;
            $customer->country_id = $request->country_id;
            $customer->city_id = $request->city_id;
            $customer->address = $request->address;
            $customer->cnic = $request->cnic;
            $customer->bank_name = $request->bank_name;
            $customer->branch_name = $request->branch_name;
            $customer->account_no = $request->account_no;
            $customer->account_title = $request->account_title;
            $customer->brith_date = $request->brith_date;
            $customer->anniversary_date = $request->anniversary_date;
            $customer->user_id = $user_id;
            $customer->save();

        }catch(\Exception $e){

        }

        return redirect('login');
       // event(new Registered($user = $this->create($request->all())));

        //$this->guard()->login($user);

       // return $this->registered($request, $user)
        //    ?: redirect($this->redirectPath())->with('message', 'Your in Approval process');
    }

}
