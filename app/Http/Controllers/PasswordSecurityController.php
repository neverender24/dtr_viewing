<?php

namespace App\Http\Controllers;

use App\PasswordSecurity;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Hash;

class PasswordSecurityController extends Controller
{
    public function show2faForm()
    {

        if (auth()->guest()) {
            return;
        }

        $user = auth()->user();

        $google2FaUrl = '';

        if (!empty($user->passwordSecurity)) {
            $google2Fa = new Google2FA();
            $google2Fa->setAllowInsecureCallToGoogleApis(true);
            $google2FaUrl = $google2Fa->getQRCodeGoogleUrl(
                'ITCDD',
                $user->email,
                $user->passwordSecurity->google2fa_secret
            );
        }
        
        $data= array(
            'user'  => $user,
            'google2FaUrl' => $google2FaUrl
        );

        return view('auth.google2fa')->with('data', $data);
    }

    public function generate2faSecretCode(Request $request)
    {
        $user = auth()->user();
        $google2Fa = new Google2FA();

        PasswordSecurity::create([
            'user_id' => $user->id,
            'google2fa_enable' => 0,
            'google2fa_secret' => $google2Fa->generateSecretKey()
        ]);

        return redirect('/2fa')->with('Success your secret key has been generated. Please verify to enable');
    }

    public function enable2fa(Request $request)
    {
        $user = auth()->user();
        $google2Fa = new Google2FA();
        $secret = $request->input('verifyCode');

        $valid = $google2Fa->verifyKey($user->passwordSecurity->google2fa_secret, $secret);

        if ($valid) {
            $user->passwordSecurity->google2fa_enable = 1;
            $user->passwordSecurity->save();
            return redirect('/2fa')->with('success', '2FA is enabled');
        } else {
            return redirect('/2fa')->with('error', 'Invalid code, try again');
        }
    }

    public function disable2fa(Request $request)
    {
        $user = auth()->user();
        if (!(Hash::check($request->get('currentPassword'), $user->password))) {
            return redirect('/2fa')->with('error', 'Password does not match');
        }

        $user->passwordSecurity->google2fa_enable = 0;
        $user->passwordSecurity->save();

        return redirect('/2fa')->with('success', '2FA is disabled');
    }
}
