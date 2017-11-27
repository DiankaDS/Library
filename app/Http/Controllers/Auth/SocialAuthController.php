<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($social)
    {

        $userSocial = Socialite::driver($social)->user();

//        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
//        auth()->login($user);

        return $userSocial;


//        $user = Socialite::driver($provider)->user();
//
//        $authUser = $this->findOrCreateUser($user, $provider);
//        Auth::login($authUser, true);

//        return $request;
    }



//    public function findOrCreateUser($user, $provider)
//    {
//        $authUser = User::where('provider_id', $user->id)->first();
//        if ($authUser) {
//            return $authUser;
//        }
//        return User::create([
//            'name'     => $user->name,
//            'email'    => $user->email,
//            'provider' => $provider,
//            'provider_id' => $user->id
//        ]);
//    }
}
