<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\church;
use App\Models\Common;
use App\Models\Annualreport;
use App\Models\Staff;
use App\Models\Mainsection;
use App\Models\Subsection;
use App\Models\Questions;
use App\Models\User;
use App\Models\DistrictChurch;
use App\Helpers\ARHelper;
use Carbon\Carbon;
use PDF;
use DB;
use Yajra\DataTables\DataTables;

class dashboardController extends Controller
{
    public function index()
    {
       
        $usertype = Auth::user()->usertype;
        $userid = Auth::user()->id;
        $get_district = User::where('id',$userid)->first();

        if($usertype == 'District'){

            $churchlist = DB::table('district_churches')
            ->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','district_churches.ChurchMainkey')
            ->leftJoin('annual_report as ar', function($join)
                {
                    $year = Carbon::now()->year;
                    $join->on('ar.Mainkey', '=', 'district_churches.ChurchMainkey');
                    $join->on('ar.YearReported',DB::raw($year - 1));
                })

            ->select('district_churches.id','mnc.MailingName','ar.ReportStatus','mnc.Mainkey','mnc.ChurchCode','ar.validate','mnc.USAEmail')
            ->where('district_churches.DistrictMainkey', '=', $get_district->district)
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

            $districtPendingReport = $districtChurchcount-$districtSubmitReport;

            $districtSubmitReportPercent = round(($districtSubmitReport * 100) / $districtChurchcount, 2);
            $districtPendingReportPercent = round(($districtPendingReport * 100) / $districtChurchcount, 2);
            $districtProgressReportPercent = round(($districtProgressReport * 100) / $districtChurchcount, 2);


            return view('backend.includes.churchlist',compact('churchlist','districtChurchcount','districtSubmitReport','districtPendingReport','districtPendingReportPercent','districtSubmitReportPercent','districtProgressReportPercent','districtProgressReport'));

        }if($usertype == 'Admin'){

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


            return view('adminbackend.includes.dashboard',compact('data','Churchcount',
            'SubmitReport','PendingReport','SubmitReportPercent','PendingReportPercent',
            'ProgressReportPercent','ProgressReport'));

        }
        if($usertype == 'NationalOffice'){
           
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

            $churchlist = DB::table('users')
            ->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','users.churchdistrict')
             ->leftJoin('annual_report as ar', function($join)
                {
                    $year = Carbon::now()->year;
                    $join->on('ar.Mainkey', '=', 'users.churchdistrict');
                    $join->on('ar.YearReported',DB::raw($year - 1));
                })

            ->select('mnc.MailingName','ar.ReportStatus','users.id','mnc.Mainkey','mnc.ChurchCode','ar.validate','mnc.USAEmail')
            ->where('users.churchdistrict', '=', $get_district->churchdistrict)
            ->where('users.id', '=', $get_district->id)
            ->get();
            //dd($churchlist);
            return view('backend.includes.churchlist',compact('churchlist'));


        //     $mainkey =Auth::user()->churchdistrict;
        //     $encmainkey = base64_encode(($mainkey + 122354125410));
        //     $lastyear = date("Y")-1;
        //    return  redirect("/AnnualReport/ChurchReport/".$encmainkey."/".$lastyear)->with('successs', 'Password Updated');



        }

    }

    public function churchlist()
    {
        $churchlist = DB::table('church')
            ->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','church.mainkey')
            ->leftJoin('annual_report as ar', function($join)
                         {
                            $year = Carbon::now()->year;
                             $join->on('ar.Mainkey', '=', 'church.mainkey');
                             $join->on('ar.YearReported',DB::raw($year - 1));
                         })
            ->select('church.id','church.Mainkey','mnc.MailingName','mnc.ChurchCode','mnc.USAEmail','ar.ReportStatus','ar.validate')
            ->orderBy('mnc.MailingName', 'ASC')
            ->get();

        return view('backend.includes.churchlist',compact('churchlist'));
    }

    public function churchreport($id,$year)
    {
        $val = ARHelper::decryptUrl($id);
        $annualreportdata = Annualreport::where('Mainkey',$val)->where('YearReported',$year)->first();
        $commondata = Common::where('Mainkey',$val)->first();
        $churchdata = church::where('Mainkey',$val)->first();
        $staff = Staff::where('EntityMainkey',$val)->get();
        $reportingyear = Annualreport::where('Mainkey',$val)->get();

        return view('backend.includes.churchreport',compact('churchdata','annualreportdata','commondata','reportingyear'));
    }

    public function churchreportdynamic($id,$year)
    {
 
        $val = ARHelper::decryptUrl($id);
        
        $annualreportdata = Annualreport::where('Mainkey',$val)->where('YearReported',$year)->first();
        $commondata = Common::where('Mainkey',$val)->first();
        $churchdata = church::where('Mainkey',$val)->first();
        $staff = Staff::where('EntityMainkey',$val)->get();
        $reportingyear = Annualreport::where('Mainkey',$val)->orderBy('YearReported', 'Desc')->get();
        $mainsection = Mainsection::orderBy('Position', 'ASC')->get();
        $subsection = Subsection::orderBy('Position', 'ASC')->get();

        return view('backend.includes.churchreportdynamic',compact('churchdata','annualreportdata','commondata','reportingyear','mainsection','subsection'));
    }

    public function GetChildChurchReport(Request $request)
    {
        $input = $request->all();

        $annualreportdata = Annualreport::where('Mainkey',$input['mainkey'])->where('YearReported',$input['year'])->first();

        $code = $input['code'];

        $annCode= $annualreportdata->$code ?? '';

        if($annCode == "Y"){
            $ParentQuesAns = "Yes";
        }else if ($annCode == "N"){
            $ParentQuesAns = "No";
        }else{
            $ParentQuesAns = $annCode;
        }

        $Question = Questions::where('ParentQuestion',$input['id'])->where('ParentQuestionAns',$ParentQuesAns)->first();

        if($Question != null){
            return response()->json(['dataQues'=> $Question]);
        }else{
            return response()->json(['dataQues'=> '']);
        }

    }

    public function verifyLogin()
    {
        $segments = url()->current();
        $url = explode("/",$segments);
        $segurl = $url[4];
        $urlData = base64_decode($segurl);
        parse_str($urlData, $params);
        $paramscount = count($params);

        $useremail = $params['Email'] ?? '';
        $fname = $params['FirstName'] ?? '';
        $lname = $params['LastName'] ?? '';
        $fullname = $fname.''.$lname;
        $staffid = $params['StaffID'] ?? '';
        $stafforgid = $params['id'] ?? '';
        
        if($paramscount > 1){

            if($useremail != ''){
                $username = $useremail;
            }else{
                $username = $fullname;
            }

            $countid = User::where('StaffOrgID',$stafforgid)->get();

            $userdata = User::select('id','username','email')
                    // ->where('username',$username)
                    ->where('email',$useremail)
                    ->first();

            if($useremail != ""){
                if($userdata == null){
                    User::create([
                        'username' => $username,
                        'email' => strtolower($useremail) ?? '',
                        'password' => Hash::make($useremail),
                        'district'=> $params['district'] ?? '',
                        'churchdistrict'=> $params['churchdistrict'] ?? '',
                        'otp'=> $params['otp'] ?? '',
                        'StaffID'=> $params['StaffID'] ?? '',
                        'StaffOrgID'=> $stafforgid,
                    ]);
                }else{
                    User::whereId($userdata->id)->update([
                        'otp' => $params['otp'] ?? ''
                    ]);
                }
            }

        }

        $getlink = User::select('otp')->where('otp',$params['otp'])->first();
        $userlink = $getlink->otp ?? '';

        if ($userlink == $params['otp']) {
            $getusertype = User::select('usertype')->where('otp',$params['otp'])->first();
            $usertype = $getusertype->usertype;
            $getuserid = User::select('id')->where('otp',$params['otp'])->first();
            $userid = $getuserid->id;
            $get_district = User::where('id',$userid)->first();
            $user = User::where('otp',$params['otp'])->first();

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

            }
            if($usertype == 'NationalOffice'){
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

                // Auth::login($user);
                //  $val = Auth::user()->churchdistrict ?? '';
                //  $year = Carbon::now()->year-1;

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

            //     $mainkey =Auth::user()->churchdistrict;Auth::user()->usertype;

            //     $encmainkey = base64_encode(($mainkey + 122354125410));
            //     $lastyear = date("Y")-1;
            //    return  redirect("/AnnualReport/ChurchReport/".$encmainkey."/".$lastyear)->with('successs', 'Password Updated');


            }
        }else{
            return view('errors.verifyerror'); 
        }
        // else{
        //     dd('Not logged in');
        // }

    }

    public function getotpgenerate(Request $request)
    {
        $id = $request->id;
        $findUser = $request->findUser;
        $bytes = random_bytes(25);
        $str = bin2hex($bytes);

        if($findUser == "Exsisting"){

            $user  = User::where('id', $id)->update(['otp_status'=>0]);
            $ConsrtucturlData = [
                'otp' => $str
            ];

        }else{

            $staff_data = Staff::find($id);
            $district = DistrictChurch::where('ChurchMainkey',$staff_data->EntityMainkey)->first();
            $staff =  DB::table('staffrole')
                ->select('StaffID','RoleTypeID')
                ->where('StaffID','=',$staff_data->StaffID)
                ->orderBy('RoleTypeID', 'DESC')
                ->get();

            $roles = [];

            foreach($staff as $s){
                $roles[] =  ARHelper::getstaffrole($s->RoleTypeID);
            }

            $ConsrtucturlData = [
                'Email' =>  $staff_data->Email,
                'EntityMainkey' =>  $staff_data->EntityMainkey,
                'FirstName' =>  $staff_data->FirstName,
                'LastName' =>  $staff_data->LastName,
                'StaffID' =>  $staff_data->StaffID,
                'district' =>  $district->DistrictMainkey ?? '',
                'churchdistrict' =>  $district->ChurchMainkey ?? '',
                'otp' => $str,
                'id' => $staff_data->id
            ];

        }


        $encodedata = base64_encode(http_build_query($ConsrtucturlData));

        return response()->json(['urldata'=>$encodedata,'otp'=>$str]);
    }

    public function pdfgenerate($id,$year)
    {
        $val = ARHelper::decryptUrl($id);
        $annualreportdata = Annualreport::where('Mainkey',$val)->where('YearReported',$year)->first();
        $commondata = Common::where('Mainkey',$val)->first();
        $churchdata = church::where('Mainkey',$val)->first();
        $staff = Staff::where('EntityMainkey',$val)->get();
        $reportingyear = Annualreport::where('Mainkey',$val)->orderBy('YearReported', 'Desc')->get();
        $mainsection = Mainsection::orderBy('Position', 'ASC')->get();
        $subsection = Subsection::orderBy('Position', 'ASC')->get();

        $pdf = PDF::loadView('frontend.email.churchreport',compact('churchdata','annualreportdata','commondata','reportingyear','mainsection','subsection'));
        return $pdf->stream();
        // dd($pdf);
        // return view('frontend.email.churchreport',compact('churchdata','annualreportdata','commondata','reportingyear','mainsection','subsection'));
    }

    public function encryptdata(Request $request)
    {
        $ConsrtucturlData = [
            'otp' => $request->val
        ];
        $encodedata = base64_encode(http_build_query($ConsrtucturlData));

        return response()->json(['urldata'=>$encodedata]);
    }

    public function churchedit(Request $request)
    {
       $churchmainkey = $request->all();
       $getmainkey = $churchmainkey['mainkey'];

       $churchdata =  DB::table('church')
                ->leftJoin('mncommon as mnc', function($join)
                {
                    $join->on('mnc.mainkey','=','church.mainkey');
                })
                ->select('church.Mainkey','mnc.MailingName','mnc.USAEmail')
                ->where('church.Mainkey',$getmainkey)
                ->first();

            return response()->json(['editchurchdata'=>$churchdata]);

    }

      public function churchlistfilter(Request $request)
    {
        $usertype = Auth::user()->usertype;
        $userid = Auth::user()->id;
        $get_district = User::where('id',$userid)->first();

        if ($request->ajax()) {
 
            if($usertype == 'District'){
                $data = DB::table('district_churches')
                ->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','district_churches.ChurchMainkey')
                ->leftJoin('annual_report as ar', function($join)
                    {
                        $year = Carbon::now()->year;
                        $join->on('ar.Mainkey', '=', 'district_churches.ChurchMainkey');
                        $join->on('ar.YearReported',DB::raw($year - 1));
                    })
                ->select('district_churches.id','mnc.MailingName','ar.ReportStatus','mnc.Mainkey','mnc.ChurchCode','ar.validate','mnc.USAEmail')
                ->where('district_churches.DistrictMainkey', '=', $get_district->district)
                ->orderBy('district_churches.ChurchName')
                ->get();
            }
            if($usertype == 'NationalOffice'){
              
                $data =DB::table('church')
                ->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','church.mainkey')
                ->LEFTJOIN('annual_report as ar', function($join)
                            {
                                $year = Carbon::now()->year;
                                $join->on('ar.Mainkey', '=', 'church.mainkey');
                                $join->on('ar.YearReported',DB::raw($year - 1));
                            })
                ->select('church.id','church.Mainkey','church.Active','mnc.MailingName','mnc.ChurchCode','mnc.USAEmail','ar.ReportStatus','ar.validate')
                ->orderBy('mnc.MailingName', 'ASC')
                ->get();
            }
            if($usertype == 'Pastor' || $usertype == 'Users'){
                $data = DB::table('users')
                ->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','users.churchdistrict')
                ->leftJoin('annual_report as ar', function($join)
                    {
                        $year = Carbon::now()->year;
                        $join->on('ar.Mainkey', '=', 'users.churchdistrict');
                        $join->on('ar.YearReported',DB::raw($year - 1));
                    })

                ->select('mnc.MailingName','ar.ReportStatus','users.id','mnc.Mainkey','mnc.ChurchCode','ar.validate','mnc.USAEmail')
                ->where('users.churchdistrict', '=', $get_district->churchdistrict)
                ->where('users.id', '=', $get_district->id)
                ->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '';
                    $btn = $btn.'<a href="javascript:void(0)" class="mainsectionedit" id="mainsectionedit'.$row->id.'" data-id="'.$row->id.'"data-val="'.$row->Mainkey.'" data-original-title="view" ><i class="fa fa-edit"></i></a>';
                    return $btn;
                })

                ->addColumn('actioncheck', function($row){

                    $check = '';
                     $check =$check.'<a href="javascript:void(0)" data-original-title="view" style="padding: 0px 0px 0px 19px;" ><input class="form-check-input" type="checkbox"  name="export" id="export" value="'.$row->id.'" data-val="'.$row->Mainkey.'" ></a>';
                    return $check;
                })

                ->addColumn('status', function($row){
                    $status = '';
                    if($row->ReportStatus == null){
                        $status = $status.'<span data-original-title="view" >Not Started</span>';
                    }else{
                        $status = $status.'<span data-original-title="view" >'.$row->ReportStatus.'</span>';
                    }
                    return $status;
                })

                ->addColumn('validate', function($row){
                    $usertype = Auth::user()->usertype;

                    $validate = '';
                    $complete = $row->ReportStatus;

                    if($complete != 'Completed'){
                    $status='disabled';
                    }else{
                        $status='';
                    }

                    $validatestatus = $row->validate;

                    if($validatestatus =='Y'){
                    $validstatus='checked';
                    }else{
                        $validstatus='';
                    }
                    if($usertype != 'NationalOffice' ){
                        $validate =$validate.'<span style="padding: 0px 0px 0px 19px;"><input class="form-check-input validate" name="validate" type="checkbox" id="validate'.$row->Mainkey  .'"  onchange="validatecheckbox('.$row->Mainkey.',this)" data-id="'.$row->Mainkey.'" value="Y" '.$status.$validstatus.'></span>';

                    }else{
                        $validate =$validate.'<span style="padding: 0px 0px 0px 19px;"><input class="form-check-input validate" name="validate" type="checkbox" id="validate'.$row->Mainkey  .'" disabled onchange="validatecheckbox('.$row->Mainkey.',this)" data-id="'.$row->Mainkey.'" value="Y" '.$status.$validstatus.'></span>';

                    }
                    return $validate;
                })
                ->addColumn('mailingname', function($row){
                    $now = Carbon::now();
                    $reportYear = $now->year-1;
                    $url = base64_encode ($row->Mainkey + 122354125410);
                    $mailingname = '';
                    $mailingname =$mailingname.'<a href = /AnnualReport/ChurchReport/'.$url.'/'.$reportYear.' target=_blank>'.$row->MailingName.'</a>';
                    return $mailingname;
                })

                ->addColumn('ChurchCode', function($row){

                    $code= substr($row->ChurchCode,0,2)."-".substr($row->ChurchCode,2,2)."-".substr($row->ChurchCode,4,4);
                    $ChurchCode = '';
                    $ChurchCode =$ChurchCode.'<span data-original-title="view" >'.$code.'</span>';
                    return $ChurchCode;
                })

                ->rawColumns(['action','actioncheck','status','validate','mailingname','ChurchCode'])
                ->make(true);
        }
    }

    public function dashboardchurchlistfilter(Request $request)
    {
        $userid = Auth::user()->id;
        $get_district = User::where('id',$userid)->first();

        if ($request->ajax()) {
            $data =  DB::table('church')
            ->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','church.mainkey')
            ->LEFTJOIN('annual_report as ar', function($join)
                        {
                            $year = Carbon::now()->year;
                            $join->on('ar.Mainkey', '=', 'church.mainkey');
                            $join->on('ar.YearReported',DB::raw($year - 1));
                        })
            ->select('church.id','church.Mainkey','church.Active','mnc.MailingName','mnc.ChurchCode','mnc.USAEmail','ar.ReportStatus','ar.validate')
            ->orderBy('mnc.MailingName', 'ASC')
            ->get();


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('ChurchStaff', function($row){
                    $btn = '';
                    $btn = $btn.'<a href="javascript:void(0)" class="viewstaff" id="viewstaff'.$row->id.'" data-id="'.$row->id.'"data-val="'.$row->Mainkey.'" data-original-title="view" title="view staffs" ><i class="fa-solid fa-users"></i></a>';
                    return $btn;

                    })
                ->addColumn('action', function($row){
                    $btn = '';
                    $btn = $btn.'<a href="javascript:void(0)" class="mainsectionedit" id="mainsectionedit'.$row->id.'" data-id="'.$row->id.'"data-val="'.$row->Mainkey.'" data-original-title="view" ><i class="fa fa-edit"></i></a>';
                    return $btn;
                })
                ->addColumn('actioncheck', function($row){
                    $check = '';
                     $check =$check.'<a href="javascript:void(0)" data-original-title="view" ><input class="form-check-input" type="checkbox" onchange="exportcheck(this)" name="export" id="export" value="'.$row->id.'" ></a>';
                    return $check;
                })
                ->addColumn('status', function($row){
                    $status = '';
                    if($row->ReportStatus == null){
                        $status = $status.'<span data-original-title="view" >Not Started</span>';
                    }else{
                        $status = $status.'<span data-original-title="view" >'.$row->ReportStatus.'</span>';
                    }
                    return $status;
                })

                ->addColumn('validate', function($row){

                    $validate = '';
                    $complete = $row->ReportStatus;

                    if($complete != 'Completed'){
                    $status='disabled';
                    }else{
                        $status='';
                    }

                    $validatestatus = $row->validate;
                    if($validatestatus =='Y'){
                    $validstatus='checked';
                    }else{
                        $validstatus='';
                    }

                    $validate =$validate.'<span style="padding: 0px 0px 0px 19px;"><input class="form-check-input validate" name="validate" type="checkbox" id="validate'.$row->Mainkey.'" onchange="validatecheckbox('.$row->Mainkey.',this)" data-id="'.$row->Mainkey.'" value="Y" '.$status.$validstatus.'></span>';
                    return $validate;
                })
                ->addColumn('Active', function($row){

                    $Active = '';
                    $Activestatus = $row->Active;
              

                    if($Activestatus ==null){
                    $validactivestatus='checked';
                    }elseif($Activestatus =='Active'){
                        $validactivestatus='checked';
                    }else{
                        $validactivestatus=""; 
                    }

                    $Active =$Active.'<span style="padding: 0px 0px 0px 19px;"><input class="form-check-input Activecheckbox" name="Active" type="checkbox" id="Activecheckbox'.$row->Mainkey.'" onchange="Activechurch('.$row->Mainkey.',this)" data-id="'.$row->Mainkey.'" value="Active" '.$validactivestatus.'></span>';
                    return $Active;
                })
                ->addColumn('mailingname', function($row){
                    $now = Carbon::now();
                    $reportYear = $now->year-1;
                    $url = base64_encode ($row->Mainkey + 122354125410);
                    $mailingname = '';
                    $mailingname =$mailingname.'<a href = /AnnualReport/ChurchReport/'.$url.'/'.$reportYear.' target=_blank>'.$row->MailingName.'</a>';
                    return $mailingname;
                })

                ->addColumn('ChurchCode', function($row){

                    $code= substr($row->ChurchCode,0,2)."-".substr($row->ChurchCode,2,2)."-".substr($row->ChurchCode,4,4);
                    $ChurchCode = '';
                    $ChurchCode =$ChurchCode.'<span data-original-title="view" >'.$code.'</span>';
                    return $ChurchCode;
                })
                ->rawColumns(['action','actioncheck','status','validate','mailingname','ChurchCode','ChurchStaff','Active'])
                ->make(true);
        }
    }


    public function churchlistedit(Request $request)
    {
        $getmainkey = $request->MainKey;

       $data =  DB::table('district_churches')
                ->leftJoin('mncommon as mnc', function($join)
                {
                    $join->on('mnc.mainkey','=','district_churches.ChurchMainkey');
                })
                ->select('district_churches.ChurchMainkey','mnc.MailingName','mnc.USAEmail')
                ->where('district_churches.ChurchMainkey',$getmainkey)
                ->first();


        return response()->json(['data'=> $data]);
    }

    public function viewdashboardstaff(Request $request){

        $entityMainkey = $request->EntityMainKey;

        $churchlist = DB::table('district_churches as ch');
         $churchlist->LEFTJOIN('mncommon as mnc','mnc.Mainkey','=','ch.ChurchMainkey');
         $churchlist->LEFTJOIN('staff as stf','stf.EntityMainkey','=','mnc.mainkey');
         $churchlist->LEFTJOIN('staffrole as sr','sr.StaffID','=','stf.StaffID');
         $churchlist->LEFTJOIN('staffroletype as srt','srt.RoleTypeID','=','sr.RoleTypeID');
         $churchlist->LEFTJOIN('annual_report as ar', function($join)
         {
            $year = Carbon::now()->year-1;
            $join->on('ar.Mainkey', '=', 'ch.ChurchMainkey');
            $join->on('ar.YearReported',DB::raw($year));
         });
         $churchlist->where('sr.RoleTypeID','=',12);
         $churchlist->where('stf.EntityMainkey',$entityMainkey);
         $churchlist->select('stf.id','stf.StaffMainkey','stf.StaffMainkey','stf.Email','stf.Title','stf.FirstName','stf.MiddleName','stf.LastName');


         $list = DB::table('district_churches as ch');
         $list->LEFTJOIN('mncommon as mnc','mnc.Mainkey','=','ch.ChurchMainkey');
         $list->LEFTJOIN('staff as stf','stf.EntityMainkey','=','mnc.Mainkey');
         $list->LEFTJOIN('vpastorroles as vpr','stf.StaffMainkey','=','vpr.Mainkey');
         $list->LEFTJOIN('staffroletype as srt','vpr.RoleTypeID','=','srt.RoleTypeID');
         $list->LEFTJOIN('annual_report as ar', function($join)
         {
            $year = Carbon::now()->year-1;
            $join->on('ar.Mainkey', '=', 'ch.ChurchMainkey');
            $join->on('ar.YearReported',DB::raw($year));
         });
         $list->where('vpr.RoleTypeID','=',12);
         $list->where('stf.EntityMainkey',$entityMainkey);
         $list->select('stf.id','stf.StaffMainkey','stf.StaffMainkey','stf.Email','stf.Title','stf.FirstName','stf.MiddleName','stf.LastName');

         $churches = $churchlist->unionAll($list)->get();

        return response()->json(['data'=> $churches]);
    }


}
