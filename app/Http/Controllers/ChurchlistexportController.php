<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\User;
use App\Models\Staff;
use App\Models\church;
use App\Models\Common;
use App\Models\Annualreport;
use App\Models\DistrictChurch;
use Response;
use File;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\dashboardController;
use App\Helpers\ARHelper;
use Carbon\Carbon;
use DB;


class ChurchlistexportController extends Controller {

   public function churchexportXlxs(Request $request) {

      $arr = $request->id;
      $staff = $request->staff;

      if($staff == "Y"){

         $churchlist = DB::table('church as ch');
         $churchlist->LEFTJOIN('mncommon as mnc','mnc.Mainkey','=','ch.mainkey');
         $churchlist->LEFTJOIN('district_churches as chs','chs.ChurchMainkey','=','ch.mainkey');
         $churchlist->LEFTJOIN('staff as stf','stf.EntityMainkey','=','mnc.mainkey');
         $churchlist->LEFTJOIN('staffrole as sr','sr.StaffID','=','stf.StaffID');
         $churchlist->LEFTJOIN('staffroletype as srt','srt.RoleTypeID','=','sr.RoleTypeID');
         $churchlist->LEFTJOIN('annual_report as ar', function($join)
         {
            $year = Carbon::now()->year-1;
            $join->on('ar.Mainkey', '=', 'ch.Mainkey');
            $join->on('ar.YearReported',DB::raw($year));
         });
         $churchlist->where('sr.RoleTypeID','=',12);
         $churchlist->whereIn('ch.id',$arr);
         $churchlist->select('ch.Mainkey','chs.DistrictName','mnc.MailingName','mnc.ChurchCode','mnc.USAEmail','ar.ReportStatus','ar.Validate','stf.id','stf.StaffMainkey','stf.StaffMainkey','stf.Email','stf.Title','stf.FirstName','stf.MiddleName','stf.LastName','sr.RoleTypeID');


         $list = DB::table('church as ch');
         $list->LEFTJOIN('mncommon as mnc','mnc.Mainkey','=','ch.Mainkey');
         $list->LEFTJOIN('district_churches as chs','chs.ChurchMainkey','=','ch.mainkey');
         $list->LEFTJOIN('staff as stf','stf.EntityMainkey','=','mnc.Mainkey');
         $list->LEFTJOIN('vpastorroles as vp','stf.StaffMainkey','=','vp.Mainkey');
         $list->LEFTJOIN('annual_report as ar', function($join)
         {
            $year = Carbon::now()->year-1;
            $join->on('ar.Mainkey', '=', 'ch.Mainkey');
            $join->on('ar.YearReported',DB::raw($year));
         });
         $list->where('vp.RoleTypeID','=',12);
         $list->whereIn('ch.id',$arr);
         $list->select('ch.Mainkey','chs.DistrictName','mnc.MailingName','mnc.ChurchCode','mnc.USAEmail','ar.ReportStatus','ar.Validate','stf.id','stf.StaffMainkey','stf.StaffMainkey','stf.Email','stf.Title','stf.FirstName','stf.MiddleName','stf.LastName','vp.RoleName');

         $churches = $churchlist->unionAll($list)->get();
         // dd($churches);
         $this->commonstaffchurchlistExport($churches);

      }else{
         $churchlist = DB::table('church as ch');
         $churchlist->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','ch.mainkey');
         $churchlist->LEFTJOIN('district_churches as chs','chs.ChurchMainkey','=','ch.mainkey');
   
         $churchlist->LEFTJOIN('annual_report as ar', function($join)
            {
               $year = Carbon::now()->year-1;
               $join->on('ar.Mainkey', '=', 'ch.Mainkey');
               $join->on('ar.YearReported',DB::raw($year));
            });
   
         $churchlist->whereIn('ch.id',$arr);
         $churchlist->select('ch.Mainkey','chs.DistrictName','mnc.MailingName','mnc.ChurchCode','mnc.USAEmail','ar.ReportStatus','ar.Validate');
         $churches = $churchlist->orderBy('mnc.MailingName','ASC')->get();

         $this->commonchurchlistExport($churches);

      }

   }


   public function ExportallDistrictchurchlist(Request $request) {

      $arr = $request->id;
      $staff = $request->staff;

      if($staff == "Y"){

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
         $churchlist->whereIn('ch.id',$arr);
         $churchlist->select('ch.ChurchMainkey','ch.DistrictName','mnc.MailingName','mnc.ChurchCode','mnc.USAEmail','ar.ReportStatus','ar.Validate','stf.id','stf.StaffMainkey','stf.StaffMainkey','stf.Email','stf.Title','stf.FirstName','stf.MiddleName','stf.LastName','sr.RoleTypeID');

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
         $list->whereIn('ch.id',$arr);
         $list->select('ch.ChurchMainkey','ch.DistrictName','mnc.MailingName','mnc.ChurchCode','mnc.USAEmail','ar.ReportStatus','ar.Validate','stf.id','stf.StaffMainkey','stf.StaffMainkey','stf.Email','stf.Title','stf.FirstName','stf.MiddleName','stf.LastName','vpr.RoleName');

         $churches = $churchlist->unionAll($list)->get();
         $this->commondistrictstaffchurchlistExport($churches);

      }else{

         $churchlist = DB::table('district_churches as ch');
         $churchlist->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','ch.ChurchMainkey');
         $churchlist->LEFTJOIN('annual_report as ar', function($join)
            {
               $year = Carbon::now()->year-1;
               $join->on('ar.Mainkey', '=', 'ch.ChurchMainkey');
               $join->on('ar.YearReported',DB::raw($year));
            });
         $churchlist->whereIn('ch.id',$arr);
         $churchlist->select('ch.ChurchMainkey','ch.DistrictName','mnc.MailingName','mnc.ChurchCode','mnc.USAEmail','ar.ReportStatus','ar.Validate');
         $churches = $churchlist->orderBy('mnc.MailingName','ASC')->get();

         $this->commondistrictchurchlistExport($churches);

      }
      
   }


   public function commondistrictstaffchurchlistExport($data) {

      $fileName = 'Churchreportlist.csv';

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
      $filename =  public_path("files/Churchreportlist.csv");
      $handle = fopen($filename, 'w');

      //adding the first row
      fputcsv($handle, [
         "Church Name",
         "District Name",
         "Staff Name",
         "Mainkey",
         "Churchcode",
         "Church Mail To",
         "ReportStatus",
         "Validate",
         "Staff Mainkey",
         "Staff Email",
         "Url"
      ]);


      foreach($data as $value){

         $sendData = [
            'id' => $value->id,
            'findUser' => ""
         ];

         $controller = $this->getotpgenerateexport($sendData);

         if($value->Email != ""){
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/login/".$controller;
         }else{
            $actual_link = "Staff email does not exsist";
         }

         
         $staffname = $value->Title.' '.$value->FirstName.''.$value->LastName.' '.$value->MiddleName;
      
         fputcsv($handle, [
            $value->MailingName,
            $value->DistrictName,
            $staffname,
            $value->ChurchMainkey,
            $value->ChurchCode,
            $value->USAEmail,
            $value->ReportStatus ?? 'Not Started',
            $value->Validate ?? 'N',
            $value->StaffMainkey,
            $value->Email,
            $actual_link
         ]);  
         
      }

      fclose($handle);
      return Response::download($filename, "Churchreportlist.csv", $headers);

   }

   public function commonstaffchurchlistExport($data) {

      $fileName = 'Churchreportlist.csv';

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
      $filename =  public_path("files/Churchreportlist.csv");
      $handle = fopen($filename, 'w');

      //adding the first row
      fputcsv($handle, [
         "Church Name",
         "District Name",
         "Staff Name",
         "Mainkey",
         "Churchcode",
         "Church Mail To",
         "ReportStatus",
         "Validate",
         "Staff Mainkey",
         "Staff Email",
         "Url"
      ]);


      foreach($data as $value){

         $sendData = [
            'id' => $value->id,
            'findUser' => ""
         ];

         $controller = $this->getotpgenerateexport($sendData);

         if($value->Email != ""){
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/login/".$controller;
         }else{
            $actual_link = "Staff email does not exsist";
         }

         
         $staffname = $value->Title.' '.$value->FirstName.''.$value->LastName.' '.$value->MiddleName;
      
         fputcsv($handle, [
            $value->MailingName,
            $value->DistrictName,
            $staffname,
            $value->Mainkey,
            $value->ChurchCode,
            $value->USAEmail,
            $value->ReportStatus ?? 'Not Started',
            $value->Validate ?? 'N',
            $value->StaffMainkey,
            $value->Email,
            $actual_link
         ]);  
         
      }

      fclose($handle);
      return Response::download($filename, "Churchreportlist.csv", $headers);

   }

   

   public function commonchurchlistExport($data) {

      $fileName = 'Churchreportlist.csv';
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
      $filename =  public_path("files/Churchreportlist.csv");
      $handle = fopen($filename, 'w');
      //adding the first row
      fputcsv($handle, [
         "Church Name",
         "District Name",
         "Mainkey",
         "Churchcode",
         "Church Mail To",
         "ReportStatus",
         "Validate",
      ]);
      foreach($data as $value){
      
         fputcsv($handle, [
            $value->MailingName,
            $value->DistrictName,
            $value->Mainkey,
            $value->ChurchCode,
            $value->USAEmail,
            $value->ReportStatus ?? 'Not Started',
            $value->Validate ?? 'N',
         ]);
      }
      fclose($handle);
      return Response::download($filename, "Churchreportlist.csv", $headers);

   }

   
   public function commondistrictchurchlistExport($data) {

      $fileName = 'Churchreportlist.csv';
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
      $filename =  public_path("files/Churchreportlist.csv");
      $handle = fopen($filename, 'w');
      //adding the first row
      fputcsv($handle, [
         "Church Name",
         "District Name",
         "Mainkey",
         "Churchcode",
         "Church Mail To",
         "ReportStatus",
         "Validate",
      ]);
      foreach($data as $value){
      
         fputcsv($handle, [
            $value->MailingName,
            $value->DistrictName,
            $value->ChurchMainkey,
            $value->ChurchCode,
            $value->USAEmail,
            $value->ReportStatus ?? 'Not Started',
            $value->Validate ?? 'N',
         ]);
      }
      fclose($handle);
      return Response::download($filename, "Churchreportlist.csv", $headers);

   }

   public function getotpgenerateexport($sendData)
    {   
        $id = $sendData['id'];
        $findUser = $sendData['findUser'];

        $bytes = random_bytes(25);
        $str = bin2hex($bytes);
        
        if($findUser == "Exsisting"){
            
            $ConsrtucturlData = [
                'otp' => $str
            ];

        }else{

            $staff_data = Staff::find($id);
            if($staff_data != null){
               $district = DistrictChurch::where('ChurchMainkey',$staff_data->EntityMainkey)->first();
            }else{
               $district = "";
            }
            

            $ConsrtucturlData = [
                'Email' =>  $staff_data->Email ?? '',
                'EntityMainkey' =>  $staff_data->EntityMainkey ?? '',
                'FirstName' =>  $staff_data->FirstName ?? '',
                'LastName' =>  $staff_data->LastName ?? '',
                'StaffID' =>  $staff_data->StaffID ?? '',
                'district' =>  $district->DistrictMainkey ?? '',
                'churchdistrict' =>  $district->ChurchMainkey ?? '',
                'otp' => $str ?? ''
            ];
        }
        
        $encodedata = base64_encode(http_build_query($ConsrtucturlData));
        
        return $encodedata;
    }

}