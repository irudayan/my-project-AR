<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\User;
use App\Models\District;
use App\Models\DistrictChurch;
use App\Models\Questions;
use Response;
use File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;
use DB;





class ExportdataController extends Controller {

   public function churchexportalldataXlxs(Request $request) 
   {
      $input =$request->all(); 
      $startyear = $input['startyear'] ?? '';
      $Endyear = $input['endyear'] ?? '';
      $district =$input['District'] ?? '';
      $Questioncode =$input['questions'] ?? '';
      $districtname = $input['Authdistrict'] ?? '';
      $Getdisname = District::where('Mainkey',$districtname)->first();
      $Reportname =$input['Reportname'] ;

      if($district == ''){
         $Getchurchmainkey = DB::table('district_churches')->select('ChurchMainkey')->where('DistrictMainkey',$districtname)->get();
      }else{
      
            if ($district[0] != 'All'  ) {
            $Getchurchmainkey = DB::table('district_churches')->select('ChurchMainkey')->whereIn('DistrictMainkey',$district)->get();
            }else{
               $districtall = DB::table('districts')->select('Mainkey')->get();
            $alldistrict=[];
            foreach ($districtall as $key => $value) {
               $alldistrict[] =$value->Mainkey;
            }
            $Getchurchmainkey = DB::table('district_churches')->select('ChurchMainkey')->whereIn('DistrictMainkey',$alldistrict)->get(); 
            }
      }

      $churchmainkey =[];

      foreach ($Getchurchmainkey as $key => $value) {
         $churchmainkey[] =$value->ChurchMainkey;
      }

      $getQuestioncodes = [
         "Church Name",
         "District Name",
         "Mainkey",
         "Church Code",
         "Church Mail To",
         "Report Status",
         "Validate",
         "Year"  
      ];

      $getQuestioncodesxls = [
         "MailingName",
         "DistrictName",
         "ChurchMainkey",
         "ChurchCode",
         "USAEmail",
         "ReportStatus",
         "Validate",
         "YearReported"
      ];

      if($Questioncode != ''){
         foreach ($Questioncode as $key => $value) {
         
            $getQuestioncodes[] = $value  ?? '';
            $getQuestioncodesxls[] = $value ?? '';

         }
      }

      $churchlistdata = DB::table('church as ch');
      $churchlistdata->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','ch.mainkey');
      $churchlistdata->LEFTJOIN('district_churches as chs','chs.ChurchMainkey','=','ch.mainkey');
      $churchlistdata->LEFTJOIN('annual_report as ar', 'ar.Mainkey', '=', 'ch.Mainkey');  
       $churchlistdata->whereBetween('ar.YearReported',[$startyear, $Endyear]); 
      $churchlistdata->whereIn('ch.mainkey',$churchmainkey);
      $churchlistdata->whereBetween('YearReported', [$startyear,$Endyear]);
      // $churchlistdata->orderBy('ar.YearReported','ASC');
      $churchlistdata->select('chs.ChurchMainkey',
      'chs.DistrictName',
      'mnc.MailingName',
      'mnc.ChurchCode',
      'mnc.USAEmail',
      DB::raw('(CASE 
      WHEN ar.ReportStatus IS  not NULL THEN ar.ReportStatus
      ELSE "Not Started" 
      END) AS ReportStatus'),
      DB::raw('(CASE 
      WHEN ar.Validate IS not NULL  THEN  ar.Validate
      ELSE "N" 
      END) AS Validate'),
      'ar.YearReported',
      'ar.PreviousYearMembers',
      'ar.MembersRemoved',
      'ar.MembersAdded',
      'ar.MembersTotal',
      'ar.AdherentsTotal',
      'ar.InclusiveTotal',
      'ar.Conversions0to11',
      'ar.MorningAttendance',
      'ar.Conversions12to18',
      'ar.Conversions19to30',
      'ar.ConversionsOver30',
      'ar.ConversionsTotal',
      'ar.BaptismsTotal',
      'ar.IncomeLocal',
      'ar.FamilySupportLocal',
      'ar.FamilySupportGCM',
      'ar.STMCMAForeign',
      'ar.STMCMADomestic',
      'ar.STMCMAContributions',
      'ar.STMEvent',
      'ar.Language',
      'ar.AllianceWorkersSupported',
      'ar.DigitalService',
      'ar.SmallGroupAttendance',
      'ar.YouthGroupAttendance',
      'ar.ChildrenAttendance',
      'ar.LeadersDeveloped',
      'ar.LeadersDeployed',
      'ar.PlantIntent',
      'ar.ChurchPlant',
      'ar.GroupPrayer',
      'ar.DiscipleshipPlan',
      'ar.LeadershipPlan',
      'ar.EvangelismPlan',
      'ar.OutreachPlan',
      'ar.CAProgram',
      'ar.CAProgramConsultation',
      'ar.CAProgramPEAK',
      'ar.CAProgramATMN',
      'ar.CAProgramFreshStart',
      'ar.CAProgramDynamicInfluence',
      'ar.ChurchDebt',
      'ar.BulletinCount',
      // 'ar.partnerships',
      // 'ar.Ethnicity',
      DB::raw('(CASE 
      WHEN ar.OnlAtt IS  not NULL THEN ar.OnlAtt
      ELSE "0" 
      END) AS OnlAtt'),
      'ar.ChurchMultiplyFocusEvent',
      'ar.ChurchPlantEventContent',
      'ar.LocalChurchActs',
      'ar.JerusalemLocal',
      'ar.JudeaRegional',
      'ar.SamariaCultural',
      'ar.EndsOfTheEarth',
      'ar.ChurchPlantMultisite',
      'ar.AMEngagePresenter',
      'ar.YoungAdultAttendance',
      'ar.YouthServeChurchEvent',
      'ar.YouthServeChurchEventNo',
      'ar.YouthServeWeekRelMin',
      'ar.YouthServeWeekRelMinNo',
      'ar.StudentLeadTeam',
      'ar.YouthSerLeadTeamNo',
      'ar.PeopleCMAForeign19to30',
      'ar.PeopleCMAForeignAges12to18',
      'ar.INTLCMATripAmount',
      'ar.PeopleCMADOM19to30',
      'ar.PEOPLECMADOMAGE12TO18',
      'ar.YoungAdultMinistry',
      'ar.VocationalMinistry1218',
      'ar.VocationalMinistry1930',
      'ar.VocationalMinistry31over',
      'ar.Called2ServeUse',
      'ar.LeadersAccreditateLicense',
      'ar.comment',
      'ar.Participants',
      'ar.LeadershipParticipants',
      'ar.EvangelismParticipants',
      'ar.CommunityParticipants',
      'ar.PeopleNONCMADOM1218',
      'ar.PeopleNonCMADom1920',
      'ar.STMNonCMADomestic',
      'ar.STMNonCMADomesticTrips',
      'ar.PeopleNONCMAFOREIGN1218',
      'ar.PeopleNONCMAFOREIGN1930',
      'ar.STMNonCMAForeign',
      'ar.AMTNONCMAINTL',
      'ar.Comment'
      );
      $churches = $churchlistdata->orderBy('chs.ChurchMainkey','ASC')->get();
      $churchcount =count($churches);
      if ($churchcount == 0) {
         return response()->json('sorry');
      }else{
      $this->commondatachurchlistExport($churches,$getQuestioncodes,$getQuestioncodesxls,$Reportname);
      }
      
   }
      
 
   public function commondatachurchlistExport($data,$getQuestioncodes,$getQuestioncodesxls,$Reportname) {

      $fileName = $Reportname.".csv" ?? '' ;

      $headers = array(
         "Content-type"        => "text/csv",
         "Content-Disposition" => "attachment; filename=$fileName",
         "Pragma"              => "no-cache",
         "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
         "Expires"             => "0"     
      );

      if (!File::exists(public_path()."/files")) {
         File::makeDirectory(public_path() . "/files");
      }

      //creating the download file
      $filename =  public_path("files/".$Reportname.".csv");
      $handle = fopen($filename, 'w');

      $partnerships  = in_array("partnerships",$getQuestioncodes);
      $ethnicity  = in_array("Ethnicity",$getQuestioncodes);
      $CAProgram  = in_array("CAProgram",$getQuestioncodes);
      $LocalChurchActs  = in_array("LocalChurchActs",$getQuestioncodes);

      //adding the first row
      
      fputcsv($handle, $getQuestioncodes);

      foreach($data as $value){


         $exportdata = [];

         if($partnerships == true){

            $parData = DB::table('partnerships')->where('Mainkey',$value->ChurchMainkey)->get();
            $imparArr = [];
            foreach($parData as $par){
               $imparArr[] = $par->FieldName;
            }
            $impparData = implode(", ",$imparArr);
         }

         if($ethnicity == true){

            $etData = DB::table('ethnicity')
            ->where('Mainkey',$value->ChurchMainkey)
            ->where('Year',$value->YearReported)
            ->get();

            $imetnArr = [];
            foreach($etData as $etn){
               $imetnArr[] = $etn->Name.':'.$etn->Percent;
            }
            $imetnData = implode(", ",$imetnArr);
         }

         if($CAProgram == true){
            $CAProgramdata = $this->multicheckConcat('CAProgram',$value); 
         }

         if($LocalChurchActs == true){
            $LocalChurchActsdata = $this->multicheckConcat('LocalChurchActs',$value);
         }

         foreach($getQuestioncodesxls as $val){

            switch ($val) {
               case 'partnerships':
                  $data = $impparData;
               break;
               case 'Ethnicity':
                  $data = $imetnData;
               break;
               case 'CAProgram':
                  $data = $CAProgramdata;
               break;
               case 'LocalChurchActs':
                  $data = $LocalChurchActsdata;
               break;
               default:
                  $data = $value->$val;
               break;
            }

            if($data == ""){
               $valueexport = "";
            }else{
               $valueexport = $data;
            }

            $exportdata[] = $valueexport;
         }
   
         $value = $exportdata[3];
      
         $datavalue =  substr($value,0,2).'-'.substr($value,2,2).'-'.substr($value,4,4);
         $exportdata[3] = $datavalue;

         fputcsv($handle,$exportdata);  
         
      }
      fclose($handle);
      return Response::download($filename,$Reportname.".csv" , $headers);

   }

   function multicheckConcat($data,$value){

      $questcodescheckbox = Questions::where('Questype','Checkbox')->where('Questioncode',$data)->first(); 
      $checkcodes = explode(", ",$questcodescheckbox->QuesCheckbox); 
      $CkCheckData = [];
      foreach ($checkcodes as $ckCodes) {
         $ckQuCode = explode(":",$ckCodes);
         $ckQuesCode = $ckQuCode[0];
         $test = $ckQuCode[1];
         
         $checkvalue = $value->$test;

         if($checkvalue == "Y"){
            $CkCheckData[] = $ckQuesCode.":".$value->$test;
         }
      }
      $CkreturnData = implode(',',$CkCheckData);
      return $CkreturnData;
      
   }

} 