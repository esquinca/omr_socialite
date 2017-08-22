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
use DB;
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
            'email' => 'required|string|email|max:255|unique:users_h10omr',
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
        if($provider == 'facebook') {
          //return Socialite::driver($provider)->redirect();
          return Socialite::driver($provider)
                ->fields(['id', 'name','age_range' ,'link', 'email', 'picture', 'gender', 'birthday','location'])
                ->scopes(['email', 'user_birthday','user_location'])
                ->redirect();
        }
        if($provider == 'google') {
          return Socialite::driver($provider)->redirect();
        }
        if($provider == 'twitter') {
          return Socialite::driver($provider)->redirect();
        }

    }

     /**
      * Obtain the user information from Facebook.
      *
      * @return Response
      */
     public function handleProviderCallback($provider)
     {
       if($provider == 'facebook') {
            try
            {
                $socialUser = Socialite::driver($provider)
                ->fields(['id', 'name', 'age_range', 'link', 'email', 'picture', 'gender', 'birthday', 'location'])
                ->user();
                //dd($socialUser);
            }
            catch(\Exception $e)
            {
                return redirect('/504');
            }

              $socialProvider = SocialProvider::where('provider_id',$socialUser->getId())->first();
              if(!$socialProvider)
              {
                  //create a new user and provider
                  $user = User::firstOrCreate(
                      ['email' => $socialUser->getEmail()],
                      ['name' => $socialUser->getName()]
                  );

                  if (empty($socialUser->getId())) {
                    $socialID = "";
                  }else{
                    $socialID = $socialUser->getId();
                  }

                  if (empty($socialUser->getAvatar())) {
                    $socialAvatar = "";
                  }else{
                    $socialAvatar = $socialUser->getAvatar();
                  }

                  if (empty($socialUser->avatar_original)) {
                    $socialAvatarOrig = "";
                  }else{
                    $socialAvatarOrig = $socialUser->avatar_original;
                  }

                  if (empty($socialUser->user['age_range']["min"])) {
                    $socialEdad = "";
                  }else{
                    $socialEdad = $socialUser->user['age_range']["min"];
                  }

                  if (empty($socialUser->user['gender'])) {
                    $socialGenero = "";
                  }else{
                    $socialGenero = $socialUser->user['gender'];
                  }

                  if (empty($socialUser->user['location']['name'])) {
                    $socialLoc = "";
                  }else{
                    $socialLoc = $socialUser->user['location']['name'];
                  }

                  if (empty($socialLink = $socialUser->user['link'])) {
                    $socialLink = "";
                  }else{
                    $socialLink = $socialUser->user['link'];
                  }

                  $user->socialProviders()->create(
                      ['user_id' => $user->id,
                       'provider_id' => $socialID,
                       'provider' => $provider,
                       'picturemin' => $socialAvatar,
                       'picturemax' => $socialAvatarOrig,
                       'age_range' => $socialEdad,
                       'gender'  => $socialGenero,
                       'location'  => $socialLoc,
                       'link'  => $socialLink
                     ]
                  );

              }
              else
                 $user = $socialProvider->user;
                 auth()->login($user);
                 return view('submitx');
       }
       if ($provider == 'google') {
         try
         {
             $socialUser = Socialite::driver($provider)->user();
         }
         catch(\Exception $e)
         {
             return redirect('/504');
         }

         $socialProvider = SocialProvider::where('provider_id',$socialUser->getId())->first();
         if(!$socialProvider)
         {
           //create a new user and provider
            $user = User::firstOrCreate(
                ['email' => $socialUser->email],
                ['name' => $socialUser->name]
            );

            $user->socialProviders()->create(
                ['user_id' => $user->id,
                'provider_id' => $socialUser->id,
                'provider' => $provider,
                'picturemin' => $socialUser->avatar,
                'picturemax' => $socialUser->avatar_original,
                'link'  => $socialUser->user['url']]
            );

         }
         else
              $user = $socialProvider->user;
              auth()->login($user);
              return view('submitx');
         //dd($socialUser);
       }

       if ($provider == 'twitter') {
         try
         {
             $socialUser = Socialite::driver($provider)->user();
             //dd($socialUser);
         }
         catch(\Exception $e)
         {
             return redirect('/');
         }
         if(!$socialProvider)
         {
             //create a new user and provider
             $user = User::firstOrCreate(
                 ['email' => $socialUser->getEmail()],
                 ['name' => $socialUser->getName()]
             );

             $user->socialProviders()->create(
                 ['user_id' => $user->id,
                 'provider_id' => $socialUser->getId(),
                  'provider' => $provider]
             );

         }
         else
              $user = $socialProvider->user;
              auth()->login($user);
              //return redirect('/');
             return view('submitx');
       }


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
        //return view('layouts.partials.submit');
     }
     public function submit(Request $request)
     {
      $email = $request->email_addess;
      $sip = $request->sip;
      $mac = $request->mac;
      $client_mac = $request->client_mac;
      $uip = $request->uip;
      $ssid = $request->ssid;
      $vlan = $request->vlan;

      $res = DB::table('email_h10omr')->insert(['email' = > $email]);

      echo "OK";
     }
}
