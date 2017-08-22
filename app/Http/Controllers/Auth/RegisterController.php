<?php

namespace App\Http\Controllers\Auth;

use App\SocialProvider; //Llamamos al modelo
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Socialite; //Llamamos la api
use Session;
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
    public function creandosession(Request $request)
    {

      session(['sip' => $request->sip]);
      session(['mac' => $request->mac]);
      session(['client_mac' => $request->client_mac]);
      session(['uip' => $request->uip]);
      session(['ssid' => $request->ssid]);
      session(['vlan' => $request->vlan]);
      session(['res' => $request->res]);
      session(['auth' => $request->auth]);
      return 'OK';
    }
    /**
    * Redirect the user to the Facebook authentication page.
    *
    * @return Response
    */
    public function redirectToProvider($provider)
    {
        //return Socialite::driver('facebook')->redirect();
       return Socialite::driver($provider)->redirect();
    }

     /**
      * Obtain the user information from Facebook.
      *
      * @return Response
      */
     public function handleProviderCallback($provider)
     {
       // echo $form_sip  = session('sip');
       // echo '<br>';
       // echo $form_mac  = session('mac');
       // echo '<br>';
       // echo $form_client_mac = session('client_mac');
       // echo '<br>';
       // echo $form_uip  = session('uip');
       // echo '<br>';
       // echo $form_ssid  = session('ssid');
       // echo '<br>';
       // echo $form_vlan  = session('vlan');
       // echo '<br>';
       // echo $form_res  = session('res');
       // echo '<br>';
       // echo $form_auth  = session('auth');
       // echo '<br>';
         // try
         // {
         //     $socialUser = Socialite::driver($provider)->user();
         // }
         // catch(\Exception $e)
         // {
         //     return redirect('/');
         // }
         // //check if we have logged provider
         // $socialProvider = SocialProvider::where('provider_id',$socialUser->getId())->first();
         // if(!$socialProvider)
         // {
         //     //create a new user and provider
         //     $user = User::firstOrCreate(
         //         ['email' => $socialUser->getEmail()],
         //         ['name' => $socialUser->getName()]
         //     );
         
         //     $user->socialProviders()->create(
         //         ['user_id' => $user->id,
         //         'provider_id' => $socialUser->getId(),
         //          'provider' => $provider]
         //     );
         
         // }
         // else
         //      $user = $socialProvider->user;
         //      auth()->login($user);
         //      return redirect('/');
        return view('layouts.partials.submit');
     }
}
