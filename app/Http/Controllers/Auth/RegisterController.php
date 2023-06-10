<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\District;
use App\Models\DistrictChurch;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Mail\annual;
use App\Mail\admin;
use Illuminate\Support\Facades\Mail;

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
    protected $redirectTo = '/AnnualReport/Dashboard';

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

     protected function checkusername(Request $request)
  {  $data= $request->all();
        $user = User::all()->where('username',$data['username'])->first();
      if ($user) {
            return "false";
      } else {
          return "true";
      }
  }

    protected function checkemail(Request $request)
  {  $data= $request->all();
        $user = User::all()->where('email',$data['email'])->first();
      if ($user) {
            return "false";
      } else {
          return "true";
      }
  }

    protected function validator(array $data)  
    {
        return Validator::make($data, [
             'username' => [''],
            'email' => [''],
            'password' => [''],
            'district' => [''],
            'districtchurch' => [''],
        ]);
    }
      /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    public function districtchurch(Request $request)
    {
        $data = $request->district;
        $districtchurch = DistrictChurch::where('DistrictMainkey',$data)->orderBy('ChurchName', 'asc')->get();
        return response()->json($districtchurch);
    }

    protected function create(array $data)
    {
 
        $alldata =['district'=> $data['district'],'districtchurch'=> $data['districtchurch']];

        if($data['checkboxvalue'] == 'districtstaff' ){
          
            // $get_admin = User::where('usertype','Admin')->get();

            // $userContent = [
            //     'toName' => $data['username'],
            //     'toemail'   => $data['email'],
            //     'churchdistrict'=> $data['districtchurch'],
            //     ];
            //     foreach ($get_admin as $adminemail) {
            //         $adminemails = $adminemail['email'];
            //         $bodyContent = [
            //             'toName' => $adminemail['username'],
            //             'toemail'   => $adminemail['email'],
            //             'churchdistrict'=> $adminemail['districtchurch'],
            //             ];
            //         {  
            //             try {
            //                 Mail::to($adminemails)->send(new annual($bodyContent,$userContent));
            //                 }
            //                 catch (Exception $e) {
            //             }
            //         } 
            //     }
             
             return User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'district'=> $alldata['district'],
                //'churchdistrict'=> $alldata['districtchurch'],
                'usertype'=> $data['districtcheck'],
            ]);

        }elseif($data['checkboxvalue'] == 'NationalOffice' ){

            return User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'district'=> $alldata['district'],
                //'churchdistrict'=> $alldata['districtchurch'],
                'usertype'=> $data['district'],
            ]);
        }
        else{

        // $getdistrictemail = User::where('usertype','district')->where('district',$alldata['district'])->get();
            
        //         $userContent = [
        //             'toName' => $data['username'],
        //             'toemail'   => $data['email'],
        //             'churchdistrict'=> $data['districtchurch'],
        //             ];
                    
        //     foreach ($getdistrictemail as $districtemail) {
        //         $dsemail = $districtemail['email'];
        //         $bodyContent = [
        //             'toName' => $districtemail['username'],
        //             'toemail'   => $districtemail['email'],
        //             'churchdistrict'=> $districtemail['districtchurch'],
        //             ];
        //         {  
        //             try {
        //                 Mail::to($dsemail)->send(new annual($bodyContent,$userContent));
        //                 }
        //                 catch (Exception $e) {
        //             }
        //         } 
        //     }

        // $get_admin = User::where('usertype','Admin')->get();

        //         foreach ($get_admin as $adminemail) {
        //             $adminemails = $adminemail['email'];
        //             $bodyContent = [
        //                 'toName' => $adminemail['username'],
        //                 'toemail'   => $adminemail['email'],
        //                 'churchdistrict'=> $adminemail['districtchurch'],
        //                 ];
        //             {  
        //                 try {
        //                     Mail::to($adminemails)->send(new annual($bodyContent,$userContent));
        //                     }
        //                     catch (Exception $e) {
        //                 }
        //             } 
        //         }


            
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'district'=> $alldata['district'],
            'churchdistrict'=> $alldata['districtchurch'],
            'roles' => 'Annual Report',
        ]);
    }

    }



}