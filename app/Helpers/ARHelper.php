<?php
/**
 * PHP version 7 and Laravel version 5.6.22
 *
 * @package         Helper
 * @Purpose         TO Manage Helper Functions
 * @File            ARHelper.php
 * @Author          MCG Developers
 * @Modified By     Jerome & Elango
 * @Created Date    01-10-2022
 */
namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;
use Image;
use Mail;
use DB;
use URL;
use App\Models\CoinsGrade;
use App\Models\Messages;
use App\Models\Coins;
use App\Models\Stamps;
use App\Models\Artifacts;
use App\Models\PhotoGallery;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Album;
use App\Models\Cms;
use App\Models\PhotoTagging;
use App\Models\Events;
use App\Models\Keywords;
use App\Models\User;
use App\Models\Logs;
use App\Models\FeedbackOnPhotos;
use App\Models\UserRequestFiles;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Annualreport;
use App\Models\church;
use App\Models\Common;
use App\Models\DistrictChurch;
use App\Models\Ethnicity;
use App\Models\Staff;
use App\Models\Mainsection;
use App\Models\Subsection;
use App\Models\Pagesection;
use App\Models\Questions;
use App\Models\Partnerships;
use App\Models\Activedate;



class ARHelper
{

// resource documents
    public static function isUSER(){
        $user_type = Auth::user()->user_type; 
        // return $user_type=='ds' ? $user_type : "";
        if ($user_type == 'ds') {
           return $user_type='ds';
        }elseif ($user_type == 'admin') {
           return $user_type='admin';
        }else{
           return $user_type='';
        }
   
       }



    // To encrypt id in url
    public static function encryptUrl($id) {
        if($id){
            $id = base64_encode(($id + 122354125410));
            return $id;
        }
    }

    // To decrypt id in url
    public static function decryptUrl($id) {
        if(is_numeric(base64_decode($id))){
            $id = explode(",", base64_decode($id))[0] - 122354125410;
            return $id;
        }
        abort(404);
    }

    // To get name of the mainkey
    public static function getMainkeyName($mainkey) {
        if($mainkey){
            $data = Staff::where('StaffMainkey','=',$mainkey)->first();
            $title = $data->Title ?? '';
            $FirstName = $data->FirstName ?? '';
            $LastName = $data->LastName ?? '';
            $val = $title." ".$FirstName." ".$LastName;
            return $val;
        }
    }

    public static function findsection($value) {
        if($value){
            $data = Subsection::where('MainsectionName','=',$value)->first();
            $string = str_replace(' ','',$data->Name ?? '');
            $string1 = preg_replace('/[^A-Za-z0-9\-ığşçöüÖÇŞİıĞ]/', '', $string);
            $title = preg_replace('/[^A-Za-z0-9 !@#$%^&*().]/u','', strip_tags($string1));
            return $title;
        }
    }

    //Get staff name
    public static function getstaffrole($value) {
        if($value){
        $staffroles = DB::table('staffroletype')
            ->where('RoleTypeID','=', $value)
            ->first();
            return $staffroles->RoleName;
        }
    }

    //Get vPastor Role
    public static function getvpastorrole($value) {
        if($value){
            $vstaffroles = DB::table('vpastorroles')
                ->select('RoleName')
                ->where('Mainkey','=',$value)
                ->get();
            return $vstaffroles->RoleName;
        }
    }

    //Get District
    public static function getdistrict($value) {
        if($value){

            $title = DistrictChurch::select('DistrictName')->where('DistrictMainkey', $value)->first();
            return $title->DistrictName ?? '';
        }
    }

    public static function getreportid($value) {
        if($value){
            $title = Annualreport::select('id')->where('Mainkey', $value)->first();
            return $title->id ?? '';
        }
    }

    public static function getreportvalidate($value) {
        if($value){
            $title = Annualreport::select('id','validate')->where('Mainkey', $value)->first();
            return $title->validate ?? '';
        }
    }

    public static function churchreportedit() {
        
        $Mainsection= Mainsection::orderBy('Position','Asc')->first();
        $Subsection = Subsection::where('MainsectionName',$Mainsection->MainSectionCode)->orderBy('Position','Asc')->first();
        $url = "AnnualReport/ChurchReport/".$Mainsection->MainSectionCode."/".$Subsection->SubSectionCode;
        return $url ?? '';
    }

    

    //Get current year
    public static function getcurrentyear($value) {
        if($value){
            $title = Annualreport::select('YearReported')->where('Mainkey', $value)->first();
            //dd($title->YearReported);
            $year = $title->YearReported ?? '';
            return $year;
        }
    }

    public static function reviewlink($value) {
        if($value){
            $data = Subsection::where('MainsectionName','=',$value)->first();
            $link = $data->Name ?? '';
            $string = str_replace(' ', '', $link);
            $string1 = preg_replace('/[^A-Za-z0-9\-ığşçöüÖÇŞİıĞ]/', '', $string);
            $title = preg_replace('/[^A-Za-z0-9 !@#$%^&*().]/u','', strip_tags($string1));
            return $title;
        }
    }
    //Get Church
    public static function getchurch($value) {
        if($value){

            $title = DistrictChurch::select('ChurchName')->where('ChurchMainkey', $value)->first();
            return $title->ChurchName ??'';
        }
    }


    public static function subsection($value) {
        if($value){
            $subsection = Subsection::orderBy('Position', 'ASC')->where('MainsectionName','=',$value)->get();
           // $title = $data->Name ?? '';
            return $subsection;
        }
    }

    public static function subsectioncode($value) {
        if($value){
            $Mainsection = Mainsection::where('MainSectionCode','=',$value)->first();
            $Mainsectionname = $Mainsection->Name ?? '';
            $subsection = Subsection::orderBy('Position', 'ASC')->where('MainsectionName','=',$Mainsectionname)->get();
            // dd($subsection);
            return $subsection;
        }
    }


    public static function SectionQuestions($value) {
        if($value){
            $Questions = Questions::where('Pagesection',$value)
            ->where('ParentQuestion','=',null)
            ->orderBy('Position', 'ASC')
            ->get();
            return $Questions;
        }
    }

    public static function getpercent($Questioncode,$year,$Mainkey) {
        if($Questioncode){
            $code = strtolower($Questioncode);
            $percent = DB::table($code)->where('Mainkey',$Mainkey)
            ->where('Year',$year)
            ->get();
            return $percent;
        }
    }

    public static function mainsectionstatus($mainkey,$year,$sectionCode) {
        if($mainkey){
            $mainsectionsdata = DB::table('mainsections')->where('MainSectionCode',$sectionCode)->orderBy('Position','DESC')->first();

            $data = DB::table('subsections')->where('MainsectionName',$mainsectionsdata->Name)->orderBy('Position','DESC')->first();
            
            if($data != null){
                $subsectioncode = ARHelper::rmvsplcharcter($data->Name);
            }else{
                $subsectioncode ="";
            }
            
            $data1 = DB::table('reportsectionstatus')->where('Mainkey',$mainkey)
            ->where('YearReport',$year)
            ->first();

            if(isset($data1)){
                if(!empty($subsectioncode)){
                    $val = $data1->$subsectioncode;
                }else{
                $val = 0;
                }
            }else{
                $val = 0;
            }

            return $val;
        }
    }

    public static function reviewsectionstatus($mainkey,$year,$sectionCode) {
        if($mainkey){

            $data1 = DB::table('reportsectionstatus')->where('Mainkey',$mainkey)
            ->where('YearReport',$year)
            ->first();

            if(isset($data1)){
                if(!empty($sectionCode)){
                    $val = $data1->$sectionCode;
                }else{
                $val = 0;
                }
            }else{
                $val = 0;
            }

            return $val;
        }
    }


    public static function subsectionstatus($mainkey,$year,$sectionCode) {
        if($mainkey){
            $data = DB::table('reportsectionstatus')->where('Mainkey',$mainkey)
            ->where('YearReport',$year)
            ->first();
            if(!empty($data)){
                $val = $data->$sectionCode;
            }else{
                $val = 0;
            }

            return $val;
        }
    }

    public static function datasuballstatus($mainkey,$year,$sectionCode) {
        if($mainkey){
            $data = DB::table('mainsections')->where('MainSectionCode',$sectionCode)->first();
            $subdata = DB::table('subsections')->where('MainsectionName',$data->Name)->get();

            $in=[];
            foreach($subdata as $value){
                    $in[] = $value->SubSectionCode;
            }

            $totalcount = count($in);

            $sum = [];
            foreach($in as $value){
                $sum[] = DB::table('reportsectionstatus')->where('Mainkey',$mainkey)
                ->where('YearReport',$year)
                ->sum($value);
            }

            $inColumn = array_sum($sum);

            $val = [
                'inColumn' =>  $inColumn,
                'totalcount' => $totalcount
            ];

            return $val;
        }
    }

    public static function getcompletepercent($mainkey,$year) {
        if($mainkey){
            $column = Schema::getColumnListing('reportsectionstatus');

            $all_columns = Schema::getColumnListing('reportsectionstatus');
            $exclude_columns = ['id', 'Mainkey', 'YearReport', 'created_at','updated_at','Review'];
            $get_columns = array_diff($all_columns, $exclude_columns);

            $sum = [];
            foreach($get_columns as $value){
                $sum[] = DB::table('reportsectionstatus')->where('Mainkey',$mainkey)
                ->where('YearReport',$year)
                ->sum($value);
            }
            $inColumn = array_sum($sum);

            $count = (count(Schema::getColumnListing('reportsectionstatus')))-6;

            $percentval = ($inColumn*100)/$count;

            $percent = round($percentval, 2);

            return $percent;
        }
    }

    public static function getMultiDropdown($code,$Mainkey) {
        if($Mainkey){
            $MultiDropdown = DB::table($code)
            ->where('Mainkey',$Mainkey)
            ->get();
            return $MultiDropdown;
        }
    }

    public static function childquestion($id) {
        if($id){
            $Questions = Questions::where('ParentQuestion',$id)->get();
            return $Questions;
        }else{
            return '';
        }
    }

    public static function Sectionsummaryquestions($value,$year,$mainkey) {

        if($value){
            $Questions = DB::table('questions as qs')
                ->leftjoin('questions as cqs','cqs.ParentQuestion','=','qs.id')
                ->select('qs.id','qs.QuestionLabel','qs.Questioncode','qs.Questype','qs.QuesCheckbox','cqs.QuestionLabel as childQuestionLabel','cqs.Questioncode as childQuestioncode')
                ->where('qs.Subsection',$value)
                ->where('qs.ParentQuestion','=',null)
                ->orderBy('qs.Position','asc')
                ->get();

            $report = [];

            foreach($Questions as $Questionval){
                
                if($Questionval->Questioncode != ""){
                   $QuestioncodeAns = ARHelper::churchReportDatas($mainkey,$year,$Questionval->Questioncode);
                }else{
                    $QuestioncodeAns = "";
                }

                if($Questionval->childQuestioncode != ""){
                    $ChildQuestioncodeAns = ARHelper::churchReportDatas($mainkey,$year,$Questionval->childQuestioncode);
                 }else{
                     $ChildQuestioncodeAns = "";
                 }

                $report[] = [
                    'id' => $Questionval->id,
                    'QuestionLabel' => $Questionval->QuestionLabel,
                    'Questioncode' => $Questionval->Questioncode,
                    'Questype' => $Questionval->Questype,
                    'QuesCheckbox' => $Questionval->QuesCheckbox,
                    'childQuestionLabel' => $Questionval->childQuestionLabel,
                    'childQuestioncode' => $Questionval->childQuestioncode,
                    'QuestioncodeAns' => $QuestioncodeAns,
                    'ChildQuestioncodeAns' => $ChildQuestioncodeAns
                ];
            }

            return $report;
        }

    }

    public static function churchReportDatas($mainkey,$year,$column) {
        if($column != ""){
            $report = Annualreport::select($column)->where('Mainkey',$mainkey)->where('YearReported',$year)->first();
            $reportval = isset($report[''.$column.'']);
            if($reportval != false){
                return $report[''.$column.''];
            }
            else{
                return '';
            }
        }else{
            return '';
        }


    }

    public static function churchReportData($mainkey,$year,$column) {

        if($column != ""){
            $report = Annualreport::select($column)->where('Mainkey',$mainkey)->where('YearReported',$year)->first();
            $reportval = isset($report[''.$column.'']);
            if($reportval != false){
                return $report[''.$column.''];
            }
            else{
                return '';
            }
        }

    }

    public static function restrictionActiveDates($usertype) {

        if($usertype != 'Admin'){
            $year = Carbon::now()->year;

            if($usertype != "District"){
                $trueValue = DB::table('activedate')->where('Year',$year)->where('Rolestype','Pastor')->first();
            }else{
                $trueValue = DB::table('activedate')->where('Year',$year)->where('Rolestype',$usertype)->first();
            }
            
            $date = Carbon::now();
            if($trueValue != null){
                if($trueValue->ActiveDate <= $date && $trueValue->EndDate >= $date){
                    $status = 1;  
                }else{
                    $status = 0;
                }
            }else{
                $status = 0;
            }

            return $status;
        }else{
            $status = 1;
            return $status;
        }

    }

    public static function GetChildChurchReport($datas)
    {
       
        $input = $datas;

        $annualreportdata = Annualreport::where('Mainkey',$input['mainkey'])->where('YearReported',$input['year'])->first();

        $code = $input['code'];

        $annCode = $annualreportdata->$code ?? '';

        if($annCode == "Y"){
            $ParentQuesAns = "Yes";
        }else if ($annCode == "N"){
            $ParentQuesAns = "No";
        }else{
            $ParentQuesAns = $annCode;
        }

        if(!empty($ParentQuesAns)){
            dd($ParentQuesAns);
        }

        $Question = Questions::where('ParentQuestion',$input['id'])->where('ParentQuestionAns',$ParentQuesAns)->first();

        if($Question != null){
            dd($Question);
            // return $Question;
        }else{
            // return '';
        }
    }

    public static function sectioncomplete($sectioncode,$mainkey,$year) {

        if($sectioncode){

            $Questions = Questions::where('Mainsection',$sectioncode)
                ->where('ParentQuestion',null)
                ->where('Questype','!=','Formula')
                ->where('Questype','!=','Percent')
                ->where('Questype','!=','Checkbox')
                ->where('Questype','!=','Multi Dropdown')
                ->get();
            
            $countQues = count($Questions);

            $verify = [];
            foreach($Questions as $ques){

                $annualreport = Annualreport::select($ques->Questioncode)->where('Mainkey',$mainkey)->where('YearReported',$year)->first();
                
                if($annualreport != ""){
                    $data = $ques->Questioncode;
                    if($annualreport->$data != ''){
                        $verify[] = $annualreport->$data;
                    }
                }
            }

            $verifycount = count($verify);

            if($verifycount == $countQues){
                return $in = 1;
            }else{
                return $in = 0;
            }
            
        }
    }

    // To set first 19 chars
    public static function charRestrictions($id) {
        if($id){
                $charStr = strlen($id);
            if($charStr > 19){
                $charStr = substr($id, 0, 19);
                $setChar = $charStr.'...';
            } else {
                $setChar = $id;
            }
            return $setChar;
        }
    }

    // To set first 140 chars
    public static function charRestrictionsNews($id) {
        if($id){
            $charStr = strlen($id);
            if($charStr > 140){
                $charStr = substr($id, 0, 140);
                $setChar = $charStr.'...';
            } else {
                $setChar = $id;
            }
            return $setChar;
        }
    }

    // To set first 140 chars
    public static function charRestrictionsFooterNews($id) {
        if($id){
            $charStr = strlen($id);
            if($charStr > 35){
                $charStr = substr($id, 0, 35);
                $setChar = $charStr.'...';
            } else {
                $setChar = $id;
            }
            return $setChar;
        }
    }

    public static function formatSizeUnits($bytes){
        if ($bytes >= 1073741824){
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }elseif ($bytes >= 1048576){
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }elseif ($bytes >= 1024){
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }elseif ($bytes > 1){
            $bytes = $bytes . ' bytes';
        }elseif ($bytes == 1){
            $bytes = $bytes . ' byte';
        }else{
            $bytes = '0 bytes';
        }
        return $bytes;
}

    // To set first 25 chars
    public static function charRestrictionsArt($id) {
        if($id){
                $charStr = strlen($id);
            if($charStr > 25){
                $charStr = substr($id, 0, 25);
                $setChar = $charStr.'...';
            } else {
                $setChar = $id;
            }
            return $setChar;
        }
    }

    // To load donated year
    public static function yearRange() {
        for($i=1700;$i<=date('Y');$i++) {
            $year_data[$i] = $i;
        }
        return $year_data;
    }

    // To load category year
    public static function catYear() {
        for($i=1947;$i<=date('Y');$i++) {
            $year_data[$i] = $i;
        }
        return $year_data;
    }

    // To get grade name
    public static function getGrade($id) {
        if($id){
            $get_grade = CoinsGrade::select('grade')->where('id', $id)->first();
            return $get_grade['grade'];
        } else {
            return false;
        }
    }

    // To get country name
    public static function getCountry($id) {
        if($id){
            $get_country = Country::select('country_name')->where('id', $id)->first();
            return $get_country['country_name'];
        } else {
            return false;
        }
    }

    public static function percentget($mainkey,$year,$tablename) {
        if($mainkey){
            $table = strtolower($tablename);
            $percenttype = DB::table($table)->where('Mainkey',$mainkey)->where('Year',$year)->get();
            return $percenttype;
        } else {
            return false;
        }
    }

    public static function multidropdownget($mainkey,$tablename) {
        if($mainkey){
            $table = strtolower($tablename);
            $multidropdown = DB::table($table)->where('Mainkey',$mainkey)->get();
            return $multidropdown;
        } else {
            return false;
        }
    }

    public static function rmvsplcharcter($value) {
        if($value){
            $string = str_replace(' ', '', $value);
            $string1 = preg_replace('/[^A-Za-z0-9\-ığşçöüÖÇŞİıĞ]/', '', $string);
            $subsections = preg_replace('/[^A-Za-z0-9 !@#$%^&*().]/u','', strip_tags($string1));
            return $subsections;
        } else {
            return false;
        }
    }

    public static function dbcheck(){
        $check = env('ONLINEDB');
        if($check == 1){
            try {
                    DB::connection('mysql2')->getPdo();
                    if(DB::connection('mysql2')->getDatabaseName()){
                        //echo "Yes! Successfully connected to the DB: " . DB::connection('mysql2')->getDatabaseName();
                        return 1;
                    }
                } catch (\Exception $e) {
                    return 0;
                }
        } else {
            return 0;
        }
    }


    // To set unique image name
    public static function setImageName($name) {
        if($name){
            $set_name = time().$name;
            return $set_name;
        } else {
            return false;
        }
    }

    // To set pagination per page
    public static function setPaginationNo() {
        $pageSize = 9;
        return  $pageSize;
    }

    // To encrypt Image name
    public static function encryptImageName($path,$get_img){
        //die($path);
        if(\File::exists($path)){
            $image = $get_img;
            $overall_path = $path;
            // Read image path, convert to base64 encoding
            $imageData = base64_encode(file_get_contents($overall_path));
            // Format the image SRC:  data:{mime};base64,{data};
            $src = 'data: '.mime_content_type($overall_path).';base64,'.$imageData;
            return $src;
        } else {
            $src = URL::to(trans('main.news_events.noimage'));
            return $src;
        }
    }

    // To User name
    public static function getUserName($id) {
        if($id){
            $get_name = User::select('display_name')->where('id', $id)->first();
            return $get_name['display_name'];
        } else {
            return false;
        }
    }

    // To User name
    public static function getUserImage($id) {
        if($id){
            $get_name = User::select('profile_pic')->where('id', $id)->first();
            return $get_name['profile_pic'];
        } else {
            return false;
        }
    }

    // format date to india format
    public static function formatDate($date=false,$format = 'd.m.Y') {
        if($date) {
            $date = new \DateTime($date);
            return $date->format($format);
        }else{
            $date = new \DateTime();
            return $date->format($format);
        }
    }

    // format date to india format
    public static function manuFormatDate($date=false,$format = 'd-m-Y') {
        if($date) {
            $date = new \DateTime($date);
            return $date->format($format);
        }else{
            $date = new \DateTime();
            return $date->format($format);
        }
    }

    // format date to india format
    public static function adminViewDate($date=false,$format = 'd-M-Y h:i:s A') {
        if($date) {
            $date = new \DateTime($date);
            return $date->format($format);
        }else{
            $curDate = date("d-M-Y H:i:s");
            return $curDate;
        }
    }


    // format date to mysql format
    public static function formatMysqlDate($date,$format = 'Y-m-d') {
        if($date) {
            $date = new \DateTime($date);
            return $date->format($format);
        }else{
            $date = new \DateTime();
            return $date->format($format);
        }
    }

     /*
    * return the number with the given limit - particularly for the float numbers
    */
    public static function mysqlDateTime($date=FALSE, $format = 'Y-m-d h:m:s'){
       if($date){
            return date($format, strtotime($date));
       }else{
            return date($format);
       }
    }

    /*
     *  This is the function to return seo title
     */

    public static function getSeo($seo) {
		$str = strtolower($seo);
		$seoTitle = strtolower(str_replace(array('  ', ' '), '-', preg_replace('/[^a-zA-Z0-9 s]/', '', trim($str))));
		return $seoTitle;
    }

	/*
     *  This is the function to return order by
     */

    public static function get_order_by() {
        $array = (['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10',]);
        return $array;
    }


     /**
     * To fetch the news & events
     *
     * @return value
     */


    /**
     * To fetch the count of coins
     *
     * @return value
     */
    public static function coinsCount()
    {
        $data['coins'] = Coins::where('status', 'Active')->count();

        return $data;
    }

    /**
     * To fetch the coins
     *
     * @return value
     */
    public static function coinsTitle($title)
    {
        $data['coins'] = Coins::where('status', 'Active')->where('id', $title)->first();

        return $data['coins']['title'];
    }

    /**
     * To fetch the stamps
     *
     * @return value
     */
    public static function stampsTitle($title)
    {
        $data['stamps'] = Stamps::where('status', 'Active')->where('id', $title)->first();

        return $data['stamps']['title'];
    }

    /**
     * To fetch the count of stamps
     *
     * @return value
     */
    public static function stampsCount()
    {
        $data['stamps'] = Stamps::where('status', 'Active')->count();

        return $data;
    }

    /**
     * To fetch the count of artifacts
     *
     * @return value
     */
    public static function artifactsCount()
    {
        $data['artifacts'] = Artifacts::where('status', 'Active')->count();

        return $data;
    }

    /**
     * To fetch the count of users
     *
     * @return value
     */
    public static function usersCountAll()
    {
        $data['users'] = User::where('user_type', 'user')->count();

        return $data;
    }

    /**
     * To fetch the count of users today date
     *
     * @return value
     */
    public static function usersCountToday()
    {
        $data['usersToday'] = User::where('user_type', 'user')->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->count();

        return $data;
    }

    /**
     * To fetch the count of users yesterday date
     *
     * @return value
     */
    public static function usersCountYesterday()
    {
        $data['usersYesterday'] = User::where('user_type', 'user')->whereDate('created_at', '=', Carbon::yesterday())->count();

        return $data;
    }

    /**
     * To fetch the count of users last week date
     *
     * @return value
     */
    public static function usersCountLastWeek()
    {
        $data['monday'] = date("Y-m-d", strtotime("last week monday"));
        $data['sunday'] = date("Y-m-d", strtotime("last week sunday"));
        $data['usersLastWeek'] = User::where('user_type', 'user')->whereBetween('created_at',[$data['monday'],$data['sunday']])->count();

        return $data;
    }

    /**
     * To fetch the count of users last month date
     *
     * @return value
     */
    public static function usersCountLastMonth()
    {
        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();
        $data['usersLastMonth'] = User::where('user_type', 'user')->whereBetween('created_at',[$fromDate,$tillDate])->count();
        return $data;
    }

    /**
     * To fetch the count of users last year date
     *
     * @return value
     */
    public static function usersCountLastYear()
    {
        $data['usersLastYear'] = User::where('user_type', 'user')->whereYear('created_at', date('Y', strtotime('last year')))->count();
        return $data;
    }

    /**
     * To fetch the count of Feedback On Photos
     *
     * @return value
     */
    public static function feedbackCountAll()
    {
        $data['feedbackAll'] = FeedbackOnPhotos::count();

        return $data;
    }

    /**
     * To fetch the count of Feedback On Photos today date
     *
     * @return value
     */
    public static function feedbackCountToday()
    {
        $data['feedbackToday'] = FeedbackOnPhotos::where('status', 'Active')->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->count();

        return $data;
    }

    /**
     * To fetch the count of user Request Files Count
     *
     * @return value
     */
    public static function userRequestFilesCountAll()
    {
        $data['userRequestFilesAll'] = UserRequestFiles::count();

        return $data;
    }

    /**
     * To fetch the count of user Request Files Count today date
     *
     * @return value
     */
    public static function userRequestFilesCountToday()
    {
        $data['userRequestFilesToday'] = UserRequestFiles::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->count();

        return $data;
    }

    /**
     * To fetch the count of tag request all
     *
     * @return value
     */
    public static function tagCountAll()
    {
        $data['tag'] = PhotoTagging::count();

        return $data;
    }

    /**
     * To fetch the count of tag request today date
     *
     * @return value
     */
    public static function tagCountToday()
    {
        $data['tagToday'] = PhotoTagging::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->count();

        return $data;
    }

    /**
     * To fetch the count of tag request yesterday date
     *
     * @return value
     */
    public static function tagCountYesterday()
    {
        $data['tagYesterday'] = PhotoTagging::whereDate('created_at', '=', Carbon::yesterday())->count();

        return $data;
    }

    /**
     * To fetch the count of tag request last week date
     *
     * @return value
     */
    public static function tagCountLastWeek()
    {
        $data['monday'] = date("Y-m-d", strtotime("last week monday"));
        $data['sunday'] = date("Y-m-d", strtotime("last week sunday"));
        $data['tagLastWeek'] = PhotoTagging::whereBetween('created_at',[$data['monday'],$data['sunday']])->count();

        return $data;
    }

    /**
     * To fetch the count of tag request last month date
     *
     * @return value
     */
    public static function tagCountLastMonth()
    {
        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();
        $data['tagLastMonth'] = PhotoTagging::whereBetween('created_at',[$fromDate,$tillDate])->count();
        return $data;
    }

    /**
     * To fetch the count of tag request last year date
     *
     * @return value
     */
    public static function tagCountLastYear()
    {
        $data['tagLastYear'] = PhotoTagging::whereYear('created_at', date('Y', strtotime('last year')))->count();
        return $data;
    }

    /**
     * To insert Logs
     *
     * @return array
     */
    public static function logs($module_name,$description)
    {   $user_id = Auth::id();

        $ip = $_SERVER['SERVER_ADDR'];
        $userAgent = $_SERVER["HTTP_USER_AGENT"];
        $devicesTypes = array(
            "Computer" => array("msie 10", "msie 9", "msie 8", "windows.*firefox", "windows.*chrome", "x11.*chrome", "x11.*firefox", "macintosh.*chrome", "macintosh.*firefox", "opera"),
            "Tablet"   => array("tablet", "android", "ipad", "tablet.*firefox"),
            "Mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini"),
            "Bot"      => array("googlebot", "mediapartners-google", "adsbot-google", "duckduckbot", "msnbot", "bingbot", "ask", "facebook", "yahoo", "addthis")
        );
        foreach($devicesTypes as $deviceType => $devices) {
            foreach($devices as $device) {
                if(preg_match("/" . $device . "/i", $userAgent)) {
                    $deviceName = $deviceType;
                }
            }
        }

        $values = array('user_id' => $user_id,'module_name' => $module_name,'description'=>$description,'ip'=>$ip,'device'=>$deviceName);
        $result = DB::table('logs')->insert($values);
        $dbcheck    = STCHelper::dbcheck();
        if($dbcheck == 1){
            $datas = DB::connection('mysql2')->table('logs')->insert($values);
        }
        return $result;

    }

    /**
     * To check whether the profile is updated
     *
     * @return array
     */
    public static function checkProfileUpdate($id)
    {
        if($id){
            $data = User::where('id', $id)->where('profile_update_status', 'Yes')->count();
            return $data;
        }
    }

    // To get photogallery and sub category images
    public static function getPhotoGalleryImage($main_id,$sub_id) {
        if($main_id && $sub_id){
            $getCatAll = PhotoGallery::where('main_category_id', $main_id)->where('sub_category_id', $sub_id)->groupBy('main_category_id','sub_category_id')->where('status', 'Active')->orderBy('main_category_id', 'DESC')->get();
            return $getCatAll;
        } else {
            return false;
        }
    }
    // To get photogallery and sub category images
    public static function getPhotoGalleryImage1($main_id,$sub_id) {
        if($main_id && $sub_id){
            $getCatAll = PhotoGallery::where('main_category_id', $main_id)->where('sub_category_id', $sub_id)->where('status', 'Active')->get();
            return $getCatAll;
        } else {
            return false;
        }
    }

    // To get main category name
    public static function getMainCategoryName($id) {
        if($id){
            $getCatName = MainCategory::select('category_name')->where('id', $id)->first();

            return $getCatName->category_name;
        } else {
            return false;
        }
    }

    /**
     * To updated the auto generated password for a particular email
     *
     * @return array
     */
    public static function setpasswordAttribute($password,$email){
        $data = DB::update('update users set password = ? where email = ?',[$password,$email]);
        $dbcheck    = STCHelper::dbcheck();
        if($dbcheck == 1){
            $datas = DB::connection('mysql2')->update('update users set password = ? where email = ?',[$password,$email]);
        }
        return $data;
    }

    /**
     * To get messages send to particular id
     *
     * @return array
     */
    public static function getMessages($id) {
        if($id){
            $getMsg = Messages::where('user_id', $id)->groupBy('user_id')->where('status', 'Sent')->where('viewStatus','Not Viewed')->where('deleted_at',NULL)->OrderBy('id', 'desc')->count();
            return $getMsg;
        } else {
            return false;
        }
    }

    // To get photogallery and sub category images
    public static function getPhotoGalleryImages($id) {
        if($id){
            $getImageName = PhotoGallery::where('id', $id)->where('status', 'Active')->first();
            if($getImageName){
                return $getImageName->main_photo;
            } else {
                return 'noimage';
            }

        } else {
            return false;
        }
    }
}
