<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    //login by googleAccount:
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try {
                $user = Socialite::driver('google')->user();
                $userQuery = User::query()->where('email',$user->email)->first();
                if($userQuery)
                    auth()->login($userQuery);
                else{
                    $newUser = User::query()->create([
                       'role_id' => 2,
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'password' => bcrypt('normal-user'),
                        'avatar' => $user->getAvatar(),
                        'google_id' => $user->getId(),
                        ]);
                    auth()->login($newUser);
                    return redirect('/');
                }
        }catch (\Exception  $e){
            dd($e->getMessage());
        }
    }

    public function create()
    {
        return view('client.register.login.create');
    }

    public function store(LoginRequest $request)
    {
        $user = User::query()->where('email', $request->get('email'))->firstOrFail();
        if (!Hash::check($request->get('password'), $user->password)) {
            return back()->withErrors('نام کاربری یا کلمه عبور مطابقت ندارد!!');
        }
        auth()->login($user);
        return redirect(route('client.index'));
    }
}
