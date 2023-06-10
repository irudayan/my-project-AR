<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\User;
use App\Models\District;
use App\Models\DistrictChurch;
use Response;
use File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;



class ExportController extends Controller {

   public function exportXlxs(Request $request) {

      $id = $request->all();
      $data = $id['arr'];

      $fileName = 'AnnualReportUserlist.csv';
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
      $filename =  public_path("files/AnnualReportUserlist.csv");
      $handle = fopen($filename, 'w');
      //adding the first row
      fputcsv($handle, [
         "Users Name",
         "District",
         "Church",
         "Role",
         "Email",
         "Status",
         "comments",
         "Userlink",
         "OTP",
         "AnnualReport Status",
         "Approved Status",
      ]);
      foreach($data as $value){
            $currentdate = Carbon::now()->toDateString();
            $arrdata = User::where('id',$value)->first();
            $arrdata->update(['otp_status' => 0]);
            $Dmainkey = $arrdata->district;
            $Cmainkey = $arrdata->churchdistrict;
            $DistrictNamedata = DistrictChurch::select('DistrictName')->where('DistrictMainkey',$Dmainkey)->first();
            if($DistrictNamedata != null){
               $DistrictName = $DistrictNamedata->DistrictName;
            }else{
               $DistrictName = "";
            }
            $ChurchNamedata = DistrictChurch::select('ChurchName')->where('ChurchMainkey',$Cmainkey)->first();
            if($ChurchNamedata != null){
               $ChurchName = $ChurchNamedata->ChurchName;
            }else{
               $ChurchName = "";
            }
            $year = date("Y")-1;
            $percentage = ARHelper::getcompletepercent($Cmainkey,$year);

            if($percentage == 100){
               $status = "Complete";
            }else{
               if($percentage == 0){
                  $status = "yet to start";
               }else{
                  $status = "In progress";
               }
            }
            $get_url = url('/');

            if($arrdata->otp != ""){
               $ConsrtucturlData = ['otp' => $arrdata->otp];
            }else{
               $generateotp = $this->getotpgenerateexport($arrdata);
               $ConsrtucturlData = ['otp' => $generateotp];
            }
            
            $encodedata = base64_encode(http_build_query($ConsrtucturlData));
            
         fputcsv($handle, [
            $arrdata->username,
            $DistrictName,
            $ChurchName,
            $arrdata->usertype,
            $arrdata->email,
            $arrdata->status,
            $arrdata->comments,
            $get_url."/login/".$encodedata,
            $arrdata->otp,
            $status,
            $arrdata->approvestatus,
         ]);
      }
      fclose($handle);
      return Response::download($filename, "AnnualReportUserlist.csv", $headers);
   }

   public function getotpgenerateexport($sendData)
   {   
      $id = $sendData->id;
      $bytes = random_bytes(25);
      $str = bin2hex($bytes);

      $arrdata = User::where('id',$id)->first();
      $arrdata->update(['otp'=>$str]);

      return $str;
   }

}
