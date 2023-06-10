<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo()
    {

        $auth= auth()->user();
        $username = $auth->usertype;
        $mainkey =$auth->churchdistrict;
        $encmainkey = base64_encode(($mainkey + 122354125410));
        $lastyear = date("Y")-1;
        if($username == 'Admin')
        {
            return "/AnnualReport/Dashboard";
        }
        elseif($username == 'District'){

            return "/AnnualReport/Dashboard";
            
        }
        else{
            return "/AnnualReport/ChurchReport/".$encmainkey."/".$lastyear;
        }
       
    }
}
