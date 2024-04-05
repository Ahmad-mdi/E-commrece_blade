<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('client.profile.myProfile.edit');
    }

    public function update(Request $request)
    {
            $request->validate([
               'name' => 'required|string|min:5|max:30'
            ]);
            auth()->user()->update([
               'name' => $request->get('name'),
            ]);
            return back();
    }

    public function changPassword_edit()
    {
        return view('client.profile.myProfile.changPassword.edit');
    }

    public function changPassword_update(Request $request)
    {
        $request->validate([
           'old_password' => 'required',
           'password' => 'required|confirmed|min:6|max:25',
        ]);
        $user = auth()->user();
        if (!Hash::check($request->get('old_password'),$user->password)) {
            return back()->withErrors('رمز فعلی مطابقت ندارد!');
        }
        $user->update([
           'password' => bcrypt($request->get('password')),
        ]);
        return redirect(route('client.myProfile.edit'))->with('successPassword','رمز عبور جدید با موفقیت ثبت شد');
    }
}
