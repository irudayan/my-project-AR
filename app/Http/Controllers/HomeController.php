<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Support\Str;
use Hash;
use Carbon\Carbon;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use App\Models\church;
use App\Models\Common;
use App\Models\Annualreport;
use App\Models\Staff;
use App\Models\DistrictChurch;
use App\Helpers\ARHelper;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function changePassword(Request $request,HasherContract $hasher)
    {  

        $this->hasher = $hasher;
        $email = Auth::user()->email ?? '';
        $tokens =Str::random(60);
        $user = User::where ('email', $email)->first();
        if ( !$user ) return redirect()->back()->withErrors(['error' => '404']); 
        DB::table('password_resets')->insert([
        'email' => $email,
        'token' => $this->hasher->make($tokens), //change 60 to any length you want
        'created_at' => Carbon::now() 
        ]);

        $tokenData = DB::table('password_resets')
        ->where('email', $email)->first();

        $token = $tokenData->token;
         
       return view('auth.passwords.userreset',compact('email'));
    }

    public function resetpassword(Request $request)
    { 
        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->password),
            'otp_status' => 1 
        ]);
        $usertype = Auth::user()->usertype;
        $mainkey =Auth::user()->churchdistrict;
        $encmainkey = base64_encode(($mainkey + 122354125410));
        $lastyear = date("Y")-1;

        if($usertype == 'Admin')
        {
            return  redirect('/AnnualReport/Dashboard')->with('successs', 'Password Updated');
        }
        elseif($usertype == 'District'){

            return  redirect('/AnnualReport/Dashboard')->with('successs', 'Password Updated');    
        }
        else{
            return  redirect("/AnnualReport/ChurchReport/".$encmainkey."/".$lastyear)->with('successs', 'Password Updated');    
        }
    }


    public function verifyLogin(){

        $segments = url()->current();
        $url = explode("/",$segments);
        $segurl = $url[4];
        $urlData = base64_decode($segurl);
        parse_str($urlData, $params);

      $user = User::where('email',$params['email'])->first();
      $usertype = $user->usertype;
      $userid = $user->id;
      $get_district = User::where('id',$userid)->first();


        if($usertype == 'District'){
            Auth::login($user);
            $churchlist = DB::table('district_churches')
                ->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','district_churches.ChurchMainkey')
                ->leftJoin('annual_report as ar', function($join)
                    {
                        $year = Carbon::now()->year;
                        $join->on('ar.Mainkey', '=', 'district_churches.ChurchMainkey');
                        $join->on('ar.YearReported',DB::raw($year - 1));
                    })

                ->select('district_churches.id','mnc.MailingName','ar.ReportStatus','mnc.Mainkey','mnc.ChurchCode','ar.validate','mnc.USAEmail')->where('district_churches.DistrictMainkey', '=', $get_district->district)

                ->orderBy('district_churches.ChurchName')
                ->get();
                
                $year = Carbon::now()->year;

                $districtSubmitReport =  DB::table('district_churches')
                ->LEFTJOIN('annual_report as ar','ar.Mainkey','=','district_churches.ChurchMainkey')
                ->where('district_churches.DistrictMainkey', '=', $get_district->district)
                ->where('ar.ReportStatus', '=', 'Completed')
                ->where('ar.YearReported', '=', $year-1)
                ->count();

                $districtProgressReport =  DB::table('district_churches')
                ->LEFTJOIN('annual_report as ar','ar.Mainkey','=','district_churches.ChurchMainkey')
                ->where('district_churches.DistrictMainkey', '=', $get_district->district)
                ->where('ar.ReportStatus', '=', 'In Progress')
                ->where('ar.YearReported', '=', $year-1)
                ->count();
                
    
                $districtChurchcount = count($churchlist);
    
                $districtPendingReport = $districtChurchcount-$districtSubmitReport-$districtProgressReport;
    
                $districtSubmitReportPercent = round(($districtSubmitReport * 100) / $districtChurchcount, 2);
                $districtPendingReportPercent = round(($districtPendingReport * 100) / $districtChurchcount, 2);
                $districtProgressReportPercent = round(($districtProgressReport * 100) / $districtChurchcount, 2);

                return view('backend.includes.churchlist',compact('churchlist','districtChurchcount','districtSubmitReport','districtPendingReport','districtPendingReportPercent','districtSubmitReportPercent','districtProgressReportPercent','districtProgressReport'));    
    

        }if($usertype == 'Admin'){
            Auth::login($user);
            $data =  DB::table('church')
                ->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','church.mainkey')
                ->LEFTJOIN('annual_report as ar', function($join)
                            {
                                $year = Carbon::now()->year;
                                $join->on('ar.Mainkey', '=', 'church.mainkey');
                                $join->on('ar.YearReported',DB::raw($year - 1));
                            })
                ->select('church.id','church.Mainkey','mnc.MailingName','mnc.ChurchCode','mnc.USAEmail','ar.ReportStatus','ar.validate')
                ->orderBy('mnc.MailingName', 'ASC')
                ->get();

            $year = Carbon::now()->year;

            $SubmitReport =  DB::table('church')
                ->LEFTJOIN('annual_report as ar','ar.Mainkey','=','church.Mainkey')
                ->where('ar.ReportStatus', '=', 'Completed')
                ->where('ar.YearReported', '=', $year-1)
                ->count();

            $ProgressReport =  DB::table('church')
                ->LEFTJOIN('annual_report as ar','ar.Mainkey','=','church.Mainkey')
                ->where('ar.ReportStatus', '=', 'In Progress')
                ->where('ar.YearReported', '=', $year-1)
                ->count();

            $Churchcount = count($data);
            $notstarted= $SubmitReport+$ProgressReport;
            $PendingReport =$Churchcount-$notstarted;

            $SubmitReportPercent = round(($SubmitReport * 100) / $Churchcount, 2);
            $PendingReportPercent = round(($PendingReport * 100) / $Churchcount, 2);
            $ProgressReportPercent = round(($ProgressReport * 100) / $Churchcount, 2);


            return view('adminbackend.includes.dashboard',compact('data','Churchcount','SubmitReport','PendingReport','SubmitReportPercent','PendingReportPercent','ProgressReportPercent','ProgressReport'));

        }if($usertype == 'NationalOffice'){
            Auth::login($user);
            $churchlist = DB::table('church')
            ->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','church.mainkey')
            ->LEFTJOIN('annual_report as ar', function($join)
                        {
                            $year = Carbon::now()->year;
                            $join->on('ar.Mainkey', '=', 'church.mainkey');
                            $join->on('ar.YearReported',DB::raw($year - 1));
                        })
            ->select('church.id','church.Mainkey','mnc.MailingName','mnc.ChurchCode','mnc.USAEmail','ar.ReportStatus','ar.validate')
            ->orderBy('mnc.MailingName', 'ASC')
            ->get();

            $year = Carbon::now()->year;

            $districtSubmitReport =   DB::table('church')
            ->LEFTJOIN('annual_report as ar','ar.Mainkey','=','church.Mainkey')
            ->where('ar.ReportStatus', '=', 'Completed')
            ->where('ar.YearReported', '=', $year-1)
            ->count();
            $districtProgressReport =   DB::table('church')
            ->LEFTJOIN('annual_report as ar','ar.Mainkey','=','church.Mainkey')
            ->where('ar.ReportStatus', '=', 'In Progress')
            ->where('ar.YearReported', '=', $year-1)
            ->count();


            $districtChurchcount = count($churchlist);

            $districtPendingReport = $districtChurchcount-$districtSubmitReport;

            $districtSubmitReportPercent = round(($districtSubmitReport * 100) / $districtChurchcount, 2);
            $districtPendingReportPercent = round(($districtPendingReport * 100) / $districtChurchcount, 2);
            $districtProgressReportPercent = round(($districtProgressReport * 100) / $districtChurchcount, 2);

                        
            return view('backend.includes.churchlist',compact('churchlist','districtChurchcount',
            'districtSubmitReport','districtPendingReport','districtPendingReportPercent',
            'districtSubmitReportPercent','districtProgressReportPercent','districtProgressReport'));

        }

        if($usertype == 'Pastor' || $usertype == 'Users'){

            //  Auth::login($user);
            // $val = Auth::user()->churchdistrict ?? '';
            // $year = Carbon::now()->year-1;

            // return redirect()->route('churchreportdynamic',[base64_encode(($val + 122354125410)),$year]);


            $churchlist = DB::table('users')
            ->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','users.churchdistrict')
            ->leftJoin('annual_report as ar', function($join)
                {
                    $year = Carbon::now()->year;
                    $join->on('ar.Mainkey', '=', 'users.churchdistrict');
                    $join->on('ar.YearReported',DB::raw($year - 1));
                })
            ->select('mnc.MailingName','ar.ReportStatus','users.id','mnc.Mainkey','mnc.ChurchCode','ar.validate','mnc.USAEmail')->where('users.churchdistrict', '=', $get_district->churchdistrict)
            ->where('users.id', '=', $get_district->id)
            ->get();
            Auth::login($user);

            return view('backend.includes.churchlist',compact('churchlist'));

        }

    }
    

}
