<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\church;
use App\Models\Common;
use App\Models\Ethnicity;
use App\Models\Mainsection;
use App\Models\Subsection;
use App\Models\Pagesection;
use App\Models\Ethnicitydropdown;
use App\Models\Languagedropdown;
use App\Models\Annualreport;
use App\Models\User;
use App\Models\ReportSectionStatus;
use App\Helpers\ARHelper;
use App\Models\District;
use App\Models\Questions;
use DB;
use Carbon\Carbon;


class ReportController extends Controller
{

    public function Common($id,$year)
    {
        $segments = url()->current();
        $url = explode("/",$segments);
        $usertype = Auth::user()->usertype;
        $currentuser = Auth::user()->id;

        $val = ARHelper::decryptUrl($id);
        $churchdata = Common::where('Mainkey',$val)->first();
        $annualreportdata = Annualreport::where('Mainkey',$val)->where('YearReported',$year)->first();
        $lastyear = DB::table('annual_report')->where('Mainkey',$val)
            ->where('YearReported', '<=', $year)
            ->orderBy('YearReported', 'desc')
            ->skip(1)->take(1)->first();
        $ethnicitydropdown = Ethnicitydropdown::all();
        $reportingyear = Annualreport::where('Mainkey',$val)->orderBy('YearReported', 'Desc')->get();
        $mainsection = Mainsection::orderBy('Position', 'ASC')->get();

        $subSection = Subsection::where('SubSectionCode',$url[6])->first();
        $pageSection = Pagesection::where('SubsectionName',$subSection->Name)->get();

        $staff = DB::table('staff')
        ->leftJoin('staffrole', 'staff.StaffID', '=', 'staffrole.StaffID')
        ->leftJoin('staffroletype', 'staffrole.RoleTypeID', '=', 'staffroletype.RoleTypeID')
        //->leftJoin('vpastorroles', 'staff.EntityMainkey', '=', 'vpastorroles.EntityMainkey')
        ->select('staff.id','staff.StaffID','staff.StaffMainkey','staff.EntityMainkey','staff.Title','staff.FirstName','staff.MiddleName','staff.LastName','staff.Suffix','staff.Email','staff.Phone','staff.PositionTitle','staff.roles','staff.usertype','staff.district','staff.churchdistrict', 'staffrole.StaffID as staffroleid','staff.FullName','staff.Phone_Extension')
        ->groupBy('staff.LastName','staff.StaffID','staff.StaffMainkey','staff.EntityMainkey','staff.Title','staff.FirstName','staff.MiddleName','staff.Suffix','staff.Email','staff.Phone','staff.PositionTitle','staff.roles','staff.usertype','staff.district','staff.churchdistrict', 'staffrole.StaffID','staff.id','staff.FullName','staff.Phone_Extension')
        ->where('staff.EntityMainkey','=', $val)
        ->orderBy('staffrole.RoleTypeID')
        ->get();

        $registerstaffs = DB::table('users')
        ->select('*')
        ->where('churchdistrict', '=', $val)
        ->get();

        if($usertype == 'Users'){
            $staffsroles = DB::table('staffroledropdown')
            ->select('*')
            ->where('role_name', '!=', 'Annual Report')
            ->orderBy('role_name', 'asc')
            ->get();

        }else{
            $staffsroles = DB::table('staffroledropdown')
                ->select('*')
                ->orderBy('role_name', 'asc')
                ->get();
        }

        $district = District::all();

        return view('YearReport.admin.common',compact('pageSection','churchdata','annualreportdata','lastyear','ethnicitydropdown','reportingyear','mainsection','url','staff','registerstaffs','district','staffsroles'));

    }

    public function Review($id,$year)
    {
        $val = ARHelper::decryptUrl($id);
        $churchdata = Common::where('Mainkey',$val)->first();
        $reportingyear = Annualreport::where('Mainkey',$val)->orderBy('YearReported', 'Desc')->get();
        $val = ARHelper::decryptUrl($id);
        $churchdata = Common::where('Mainkey',$val)->first();
        $annualreportdata = Annualreport::where('Mainkey',$val)->where('YearReported',$year)->first();
        $lastyear = DB::table('annual_report')->where('Mainkey',$val)
            ->where('YearReported', '<=', $year)
            ->orderBy('YearReported', 'desc')
            ->skip(1)->take(1)->first();
        $mainsection = Mainsection::all();

        return view('YearReport.admin.review',compact('churchdata','reportingyear','mainsection','annualreportdata'));
    }

    public function StoreAnnualreport(Request $request)
    {

        $input = $request->all();
        $sectionname = $request->sectionName;
        $mainkey = $request->Mainkey;
        $Year = $request->YearReported;
        $id = $request->id;

        $reportsectionstatuscheck = $this->reportsectionstatuscheck($sectionname,$mainkey,$Year,$id);

        $Subsection = Subsection::orderBy('Position','ASC')->get();

        foreach($Subsection as $value){

            $select = ARHelper::rmvsplcharcter($value['Name']);
            $sectionstatus = ReportSectionStatus::where($select,0)->where('Mainkey',$mainkey)->where('YearReport',$Year)->first();
      
            if($sectionstatus != null){

                $position = $value["Position"];

                $routename = Subsection::where('Position',$position)->first();
                if($routename != ""){
                    $route = "/AnnualReport/ChurchReport/".ARHelper::rmvsplcharcter($routename->MainsectionName)."/".ARHelper::rmvsplcharcter($routename->Name)."/".ARHelper::encryptUrl($mainkey)."/".$Year;
                }else{
                    $route = "/AnnualReport/ChurchReport/Review/Review/".ARHelper::encryptUrl($mainkey)."/".$Year;
                }
                break;

            }else{

                $position = $value["Position"];
                $routename = Subsection::where('Position','>',$position)->first();
                if($routename != ""){
                    $route = "/AnnualReport/ChurchReport/".ARHelper::rmvsplcharcter($routename->MainsectionName)."/".ARHelper::rmvsplcharcter($routename->Name)."/".ARHelper::encryptUrl($mainkey)."/".$Year;
                }else{
                    $route = "/AnnualReport/ChurchReport/Review/Review/".ARHelper::encryptUrl($mainkey)."/".$Year;
                }
            }
        }


        if($id == ""){

            $request->merge([
                'ReportStatus' => "In Progress"
            ]);

            $request->merge([
                'UpdateBy' => Auth::user()->username
            ]);

            $input = $request->except('sectionName','percent','_token','multidropdown');
            $data = new Annualreport($input);
            $data->save();

            $submitdata = Annualreport::where('Mainkey',$mainkey)->where('YearReported',$Year)->first();

            return response()->json(['msg'=> "Report Submitted Successfully!",'data'=>$submitdata,'route'=>$route]);

        }else{

            $percent = ARHelper::getcompletepercent($mainkey,$Year);
            if($percent == 100){
                $request->merge([
                    'ReportStatus' => "Completed"
                ]);
            }else{
                $request->merge([
                    'ReportStatus' => "In Progress"
                ]);
            }

            $request->merge([
                'UpdateBy' => Auth::user()->username
            ]);

            $input = $request->except('sectionName','percent','_token','multidropdown','Ethnicityrange');

            $data = Annualreport::where('id',$id)->first();
            $data->update($input);

            $submitdata = Annualreport::where('Mainkey',$mainkey)->where('YearReported',$Year)->first();
           
            return response()->json(['msg'=> "Report Updated Successfully!",'data'=>$submitdata,'route'=>$route]);

        }
        return response()->json(['msg'=> "Report Updated Successfully!",'data'=>'','route'=>$route]);

    }

    public function reportAutoSave(Request $request)
    {
        $input = $request->all();
        $Mainkey = $input['Mainkey'];
        $Year = $input['year'];
        $id = $input['id'] ?? '';

        $dataName = $input['dataname'];
        $val = $input['val'];

        $data = Annualreport::where('YearReported',$Year)->where('Mainkey',$Mainkey)->first();

        if($data == null){
            $Annualreportdata = new Annualreport([$dataName => $val,'YearReported'=>$Year,'Mainkey'=> $Mainkey,'UpdateBy' => Auth::user()->username]);
            $Annualreportdata->save();
            $submitdata = Annualreport::where('Mainkey',$Mainkey)->where('YearReported',$Year)->first();
            return response()->json(['data'=>$submitdata]);
        }else{
            $Annualreportdata = Annualreport::where('YearReported',$Year)->where('Mainkey',$Mainkey)->first();
            $Annualreportdata->update([$dataName => $val,'UpdateBy' => Auth::user()->username]);
            $submitdata = Annualreport::where('Mainkey',$Mainkey)->where('YearReported',$Year)->first();
            return response()->json(['data'=>$submitdata]);
        }
    }

    public function reportsectionstatuscheck($sectionname,$mainkey,$Year,$id)
    {
        $Subsection = Subsection::select('Name')->where('SubSectionCode',$sectionname)->first();

        $Questions = Questions::where('Subsection',$Subsection->Name)
            ->where('ParentQuestion',null)
            ->where('Questype','!=','Formula')
            ->where('Questype','!=','Percent')
            ->where('Questype','!=','Checkbox')
            ->where('Questype','!=','Multi Dropdown')
            ->get();

        $questioncount = count($Questions);

        $verify = [];

        foreach($Questions as $value){
            $annualreport = Annualreport::select($value->Questioncode)->where('Mainkey',$mainkey)->where('YearReported',$Year)->first();
            if($annualreport != ""){
                $data = $value->Questioncode;
                if($annualreport->$data != ""){
                    $verify[] = 1;
                }
            }
        }

        $verifycount = count($verify);

        if($questioncount == $verifycount){
            if($id == ""){

                $reportsectionstatus = new ReportSectionStatus;
                $reportsectionstatus->Mainkey = $mainkey;
                $reportsectionstatus->YearReport = $Year;
                $reportsectionstatus->$sectionname = 1;
                $reportsectionstatus->save();

            }else{

                $reportsectionstatus = ReportSectionStatus::where('Mainkey',$mainkey)->where('YearReport',$Year)->first();

                if($reportsectionstatus == null){
                    $reportsectionstatus = new ReportSectionStatus;
                    $reportsectionstatus->Mainkey = $mainkey;
                    $reportsectionstatus->YearReport = $Year;
                    $reportsectionstatus->$sectionname = 1;
                    $reportsectionstatus->save();
                }else{
                    $reportsectionstatus->update([$sectionname => 1]);
                }
            }
        }else{
            if($id == ""){

                $reportsectionstatus = new ReportSectionStatus;
                $reportsectionstatus->Mainkey = $mainkey;
                $reportsectionstatus->YearReport = $Year;
                $reportsectionstatus->save();

            }else{

                $reportsectionstatus = ReportSectionStatus::where('Mainkey',$mainkey)->where('YearReport',$Year)->first();

                if($reportsectionstatus == null){
                    $reportsectionstatus = new ReportSectionStatus;
                    $reportsectionstatus->Mainkey = $mainkey;
                    $reportsectionstatus->YearReport = $Year;
                    $reportsectionstatus->save();
                }
            }
        }

    }

    public function storereviewsubmit(Request $request)
    {
        $input = $request->all();
        $mainkey = ARHelper::decryptUrl($input['mainkey']);
        $year = $input['year'];

        $Subsection = Subsection::all();

        $reportsection = ReportSectionStatus::where('Mainkey',$mainkey)
            ->where('YearReport',$input['year'])
            ->first();

        if($reportsection == null){
            $reportsectionstatus = new ReportSectionStatus;
            $reportsectionstatus->Mainkey = $mainkey;
            $reportsectionstatus->YearReport = $year;
            $reportsectionstatus->save();
        }

        $data = [];
        $sections = [];

        foreach($Subsection as $value){

            $sections[] = $value->SubSectionCode;
            $sectioncode = $value->SubSectionCode;

            $Questions = Questions::where('Subsection',$value->Name)
            ->where('ParentQuestion',null)
            ->where('Questype','!=','Formula')
            ->where('Questype','!=','Checkbox')
            ->where('Questype','!=','Percent')
            ->where('Questype','!=','Multi Dropdown')
            ->get();

            $questioncount = count($Questions);

            $verify = [];

            foreach($Questions as $ques){

                $annualreport = Annualreport::select($ques->Questioncode)->where('Mainkey',$mainkey)->where('YearReported',$year)->first();

                if($annualreport != ""){
                    $data = $ques->Questioncode;
                    if($annualreport->$data != null){
                        $verify[] = $annualreport->$data;
                    }
                }
            }

            $verifycount = count($verify);
            if($verifycount == $questioncount){
                $reportsectionnew = ReportSectionStatus::where('Mainkey',$mainkey)
                    ->where('YearReport',$year)
                    ->first();
                $reportsectionnew->update([$sectioncode => 1]);
            }

        }

        $sectioncount = count($sections);
        $sada = ReportSectionStatus::select($sections)->where('Mainkey',$mainkey)->where('YearReport',$year)->first();
        $totalVal = [];
        foreach($sections as $sect){
            $totalVal[$sect] = $sada->$sect;
        }

        $reviewsubmit = array_sum($totalVal);

        if($reviewsubmit == $sectioncount){

            $annualreport = Annualreport::where('Mainkey',$mainkey)->where('YearReported',$year)->first();
            $annualreport->update(['ReportStatus' => "Completed" , "Submitted" => 'Y',"SubmittedDate" => Carbon::now()]);

            $input = $request->all();
            $mainkey = ARHelper::decryptUrl($input['mainkey']);
            $inputupdate = [
                'Review' => 1
            ];
            $reportsectionstatus = ReportSectionStatus::where('Mainkey',$mainkey)->where('YearReport',$year)->first();
            $reportsectionstatus->update($inputupdate);
            return response()->json(['Success'=>"Report Submited Successfully"]);
        }else{
            return response()->json(['data'=> $totalVal]);
        }

    }
    
    public function MoveNextsection(Request $request)
    {

        $subsection= $request->subsection;
        $Year = $request->year;
        $mainkey = $request->Mainkey;
        $Subsections = Subsection::orderBy('Position','ASC')->get();


        foreach($Subsections as $value){

            $select = ARHelper::rmvsplcharcter($value['Name']);

            $sectionstatus = ReportSectionStatus::where($select,0)->where('Mainkey',$mainkey)->where('YearReport',$Year)->first();
       
            if($sectionstatus != null){

                $position = $value["Position"];
                $routename = Subsection::where('Position',$position)->first();
                if($routename != ""){
                    $route = "/AnnualReport/ChurchReport/".ARHelper::rmvsplcharcter($routename->MainsectionName)."/".ARHelper::rmvsplcharcter($routename->Name)."/".ARHelper::encryptUrl($mainkey)."/".$Year;
                }else{
                    $route = "/AnnualReport/ChurchReport/Review/Review/".ARHelper::encryptUrl($mainkey)."/".$Year;
                }
                break;
                
            }else{
                $routename = Subsection::where('SubSectionCode',$subsection)->orderBy('Position','desc')->first();
                $position =$routename["Position"];
                $routename = Subsection::where('Position','>',$position)->first();
               
                if($routename != ""){
                    $route = "/AnnualReport/ChurchReport/".ARHelper::rmvsplcharcter($routename->MainsectionName)."/".ARHelper::rmvsplcharcter($routename->Name)."/".ARHelper::encryptUrl($mainkey)."/".$Year;
                }else{
                    $route = "/AnnualReport/ChurchReport/Review/Review/".ARHelper::encryptUrl($mainkey)."/".$Year;
                }
            }

            return response()->json(['route'=>$route]);

        }
   
    }

}
