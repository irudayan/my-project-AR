@extends('backend.layouts.main')
@section('content')
@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Activedate;
use App\Models\User;
use App\Models\church;
$username = Auth::user()->username;
$usertype = Auth::user()->usertype;
// dd($usertype);
$datenow = Carbon::now();
$period = $datenow->year-1;
if($usertype != 'Admin' && $usertype != 'NationalOffice'){ 
    if($usertype =='Users'){
        $getusertype =  Activedate::select('EndDate')->where('Rolestype','Pastor')->first();
    }elseif($usertype =='Pastor'){
        $getusertype =  Activedate::select('EndDate')->where('Rolestype','Pastor')->first();
    }
    else{
        $getusertype =  Activedate::select('EndDate')->where('Rolestype',$usertype)->first();
    }
    $date = Carbon::parse($getusertype->EndDate);
    $day = $date->day;
    $month = $date->month;
    $periodyear = $date->year;
    $month = date('F', strtotime($getusertype->EndDate));
}

$segments = request()->segments();
$mainkey = $segments[2];
$year = $segments[3];
$j = 0;

$churchmainkey = explode(",", base64_decode($mainkey))[0] - 122354125410; 
$churchstatus = Auth::user()->churchdistrict;
$churchactive = church::select('Active')->where('Mainkey',$churchmainkey)->first();

@endphp

<style>
.res-data{
    float:right;
}
.sub-label{
    color:#000000;
    font-weight: 700;
    font-size:12px;
    padding-left: 40px;
}
.section-church-report{
    font-weight: bold;
    font-size:12px;
    line-height: 14px;;
}
.main-title.high{
    color:black;
    font-size:15px;
}
.main-title.sub{
    color:black;
    font-size:12px;
}
.sub-title{
    font-weight: bold;
    color:black;
    font-size:14px;
    color:#801214;
    width: 100%;
}
.main-title.sub{
    font-size:10px;
}
.main-title{
    font-size:15px;
}
.ques{
    font-size:12px;
}
.check-box-value{
    font-size:12px;
}
.res-data{
    font-size:12px;
    padding-right: 15px;
}
a:hover{
    color:#801214;
    text-decoration:underline;
}
.check-box-value{
    padding-left: 30px;
}
.content-col{
    column-count: 2;
}
.child{
    padding-left:30px;
}
.child p{
    margin-bottom: 0rem!important;
}
.summaryedit a{
    color: #fff;
}
.staff span{
    display: inline-block;
    width: 30%;
}

@media print {
    section{
        padding: 0px 0px;
    }
    .contact .php-email-form {
        padding: 0px;
        padding-left: 20px;
    }
    #footer{
    display: none !important;
    }
    #header{
    display: none !important;
    }
    .breadcrumbs{
        display: none !important;
    }
    .menubar{
        display: none !important;
    }
    #topbar{
        display: none !important;
    }
    #button{
        display: none !important;
    }
    .toc.item {
    display: none !important;
    }
    i:before {
        display: none !important;
    }
    .summaryedit{
        display: none !important;
    }
    .summaryedit a{
        display: none !important;
    }
    @page {
        size:A4 Portrait;
        size: 21cm 29.7cm;
        margin-right: 0px;
        margin-left: 0px;
        margin-top: 10px auto;
        margin-bottom: 10px auto;
        /* padding: 10px auto; */
        -webkit-print-color-adjust: exact;
    }


    
    html, body {

        margin: 0 !important;
        color:black;
        font-size:15px;
        overflow: hidden;
        font-weight: normal;
    }

    .section-church-report{
        font-weight: bold;
        font-size:12px;
        line-height: 14px;
    }
    .sub-title{
        font-weight: bold;
        color:black;
        font-size:12px;
        color:#801214;
    }
    .res-data{
        float:right;
    }
    .sub-label{
        color:#000000;
        font-weight: 700;
        font-size:12px;
        padding-left: 40px;
    }
}

</style>
<div class="col-md-12" id="bri_ind_container">
    <div class="php-email-form">
        <section class ="section-church-report" style="padding:0px;">
            <div class="row head-row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                    <center><img src="https://atmn.cmalliance.org/assets/img/alliance-logo.png" alt="" width="80
                    px"></center>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" >
                    <center><label class="main-title high">The Christian and Missionary Alliance</label><center>
                    <center><label class="main-title high">Local Alliance Church and Annual Report</label></center>
                    <center><label class="main-title sub">Reporting Period : January 1, {{$year}} - December 31, {{$year}}</label></center>
                    @if($usertype != 'Admin' && $usertype != 'NationalOffice')
                    <center><label class="main-title high">Report Due : {{$month}}  {{$day}},{{$periodyear}}</label></center>
                    @endif
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                    <br>
                    <center><label class="main-title high">CHURCH CODE</label></center>
                    <center>
                        <label class="">
                        {{substr($commondata->ChurchCode,0,2)?? '' }}-{{substr($commondata->ChurchCode,2,2)?? '' }}-{{substr($commondata->ChurchCode,4,3)?? '' }}
                        </label>
                    </center>
                    @php
                        $url = ARHelper::churchreportedit();
                        $usertype = Auth::user()->usertype;
                        $true = ARHelper::restrictionActiveDates($usertype);
                    @endphp
                    @if($usertype != 'Admin' && $usertype != 'NationalOffice')
                        @if($churchactive->Active == "Active")
                        @if($true == 1)
                            @if($period == $year)
                                <center><button class="summaryedit"><a href="{{ url($url,[$mainkey,$year]) }}">Edit Report</a></button></center>
                            @endif
                         @else
                            <center><button class="summaryedit"><a href="javascript:void(0)" onclick="restrictUser()">Edit Report</a></button></center>
                        @endif
                     @else
                        <center><button class="summaryedit"><a href="javascript:void(0)" onclick="restrictUserchurchactive()">Edit Report</a></button></center>
                    @endif
                    @elseif($usertype == 'NationalOffice')
                    <center><button class="summaryedit"><a href="{{ url($url,[$mainkey,$year]) }}">View Report</a></button></center>

                    @else
                        <center><button class="summaryedit"><a href="{{ url($url,[$mainkey,$year]) }}">Edit Report</a></button></center>
                    @endif
                </div>
            </div>
            <br>
            <br>
            <div class="row" style="padding:0px 10px;">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" >
                    <label class="main-title high">Official Directory City</label><label class="res-data">{{$commondata->MailingCity ?? ''?? '' }}</label><br>
                    <label class="main-title high">E-mail </label><label class="res-data"><a href="mailto:{{$commondata->USAEmail ?? ''?? '' }}">{{$commondata->USAEmail ?? ''?? '' }}</a></label><br>
                    <label class="main-title high">WebSite Address</label><label class="res-data"><a href="{{$commondata->WebSite ?? ''?? '' }}" target="_blank">{{$commondata->WebSite ?? ''?? '' }}</a></label><br>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <label class="main-title high">Church Name </label><label class="res-data">{{$commondata->MailingName ?? ''?? '' }}</label><br>
                    <div class="row">
                        <div class="col-6">
                            <label class="main-title high">Telephone</label><label class="res-data">{{$commondata->OfficePhone ?? ''?? '' }}</label>
                        </div>
                        <div class="col-6">
                            <label class="main-title high" class="float:right;">Fax </label><label class="res-data">{{$commondata->Fax ?? ''?? '' }}</label>
                        </div>
                    </div>
                    <label class="main-title high">Name of Individual Entering Report </label><label class="res-data">
                        @if($annualreportdata != "")
                            @if($period != $annualreportdata->YearReported)
                                {{ ARHelper::getMainkeyName($annualreportdata->UpdateBy) ?? '' }}
                            @else
                                {{ $annualreportdata->UpdateBy ?? '' }}
                            @endif
                        @else
                            {{$username ?? ''}}
                        @endif
                    </label><br>
                </div>
            </div>
            <br>
            <br>
            <div class="row" style="padding:0px 10px;">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 content-col">

                    @php $i=1; @endphp
                    @foreach($mainsection as $value)

                        <label class="main-title">{{ strtoupper($value->Name); }}</label><br>

                        @php
                          $subsection = ARHelper::subsection($value->Name);
                        @endphp

                        @foreach($subsection as $subvalue)

                            <label class="sub-title">
                                @php
                                $usertype = Auth::user()->usertype;
                                $true = ARHelper::restrictionActiveDates($usertype);
                                @endphp

        @if($usertype != 'Admin' && $usertype != 'NationalOffice')
            @if($churchactive->Active == "Active")
            @if($true == 1)
                @if($period == $year)
                <a href="{{url('AnnualReport/ChurchReport/'.ARHelper::rmvsplcharcter($subvalue->MainsectionName).'/'.ARHelper::rmvsplcharcter($subvalue->Name).'/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">{{ $subvalue->Name }}<span style="margin-left: 5px"><i class="fa fa-edit"></i></span></a>
                @else
                <a href="javascript:void(0)" onclick="restrictUser()">{{ $subvalue->Name }}</a>
                @endif
            @else
            
            <a href="javascript:void(0)" onclick="restrictUser()">{{ $subvalue->Name }}</a>
            @endif
            @else
            <a href="javascript:void(0)" onclick="restrictUserchurchactive()">{{ $subvalue->Name }}</a>
            @endif
        @elseif($usertype == 'NationalOffice')
        <a href="{{url('AnnualReport/ChurchReport/'.ARHelper::rmvsplcharcter($subvalue->MainsectionName).'/'.ARHelper::rmvsplcharcter($subvalue->Name).'/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">{{ $subvalue->Name }}<span style="margin-left: 5px"></span></a>
      @else
            <a href="{{url('AnnualReport/ChurchReport/'.ARHelper::rmvsplcharcter($subvalue->MainsectionName).'/'.ARHelper::rmvsplcharcter($subvalue->Name).'/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">{{ $subvalue->Name }}<span style="margin-left: 5px"><i class="fa fa-edit"></i></span></a>
        @endif

                                {{-- @if($true == 1)
                                    <a href="{{url('AnnualReport/ChurchReport/'.ARHelper::rmvsplcharcter($subvalue->MainsectionName).'/'.ARHelper::rmvsplcharcter($subvalue->Name).'/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">{{ $subvalue->Name }}<span style="margin-left: 5px"><i class="fa fa-edit"></i></span></a>
                                @else
                                    <a href="javascript:void(0)" onclick="restrictUser()">{{ $subvalue->Name }}</a>
                                @endif --}}
                            </label><br>
                            @if ($subvalue->Name == 'Church Staff')
                                @php
                                $mainkeys = explode(",", base64_decode($mainkey))[0] - 122354125410;
                                $staff = DB::table('staff')
                                    ->leftJoin('staffrole', 'staff.StaffID', '=', 'staffrole.StaffID')
                                    ->leftJoin('staffroletype', function($join)
                                    {
                                        $join->on('staffrole.RoleTypeID', '=', 'staffroletype.RoleTypeID');
                                    })
                                    ->select('staff.id','staff.StaffID','staff.Title','staff.FirstName','staff.MiddleName','staff.LastName','staff.Suffix','staff.FullName','staff.Email')
                                    ->groupBy('staff.LastName','staff.StaffID','staff.Title','staff.FirstName','staff.MiddleName','staff.Suffix', 'staffrole.StaffID','staff.id','staff.FullName','staff.Email')
                                    ->where('staff.EntityMainkey','=', $mainkeys)
                                    ->orderBy('staffrole.RoleTypeID')
                                    ->get();

                                $registerstaffs = DB::table('users')
                                    ->select('username','StaffID','StaffOrgID')
                                    ->where('churchdistrict', '=', $mainkeys)
                                    ->whereNull('StaffID')
                                    ->WhereNull('StaffOrgID')
                                    ->get();
                                @endphp
                                @foreach ($registerstaffs as $regstaff)
                                <label class="check-box-value">
                                    {{$regstaff->username}}
                                </label><br>
                                @endforeach
                                @foreach ($staff as $staffval)
                                @php
                                    $stafftitle = isset($staffval->Title) ? $staffval->Title.' ' :  '';
                                    $midname = isset($staffval->MiddleName) ? ' '.$staffval->MiddleName : '';
                                    $suffix = isset($staffval->Suffix) ? ' '.$staffval->Suffix : '';
                                    
                                    $lastname = isset($staffval->LastName) ? $staffval->LastName.',' : '';
                                    $fullname = $lastname.' '.$stafftitle.''.$staffval->FirstName.''.$midname.''.$suffix;
                                    $staffemail = isset($staffval->Email) ? ' '.$staffval->Email : '';
                                    
                                    $empty = '';
                                    $staffname = $staffval->FullName;
                                @endphp

                               
                                <label class="check-box-value">
                                    @if(isset($staffval->LastName))
                                    {{ $fullname }} &nbsp;&nbsp;  <a href = "mailto:{{ $staffemail }}"> {{ $staffemail }}</a>
                                    
                                    @elseif(isset($staffname))
                                    {{$staffname}} &nbsp;&nbsp;  <a href = "mailto:{{ $staffemail }}"> {{ $staffemail }}</a>
                                    @else
                                    {{ $empty }}
                                    @endif
                                </label><br>
                                @endforeach
                            @endif


                            @php
                            if($annualreportdata != ""){
                                $Questions = ARHelper::Sectionsummaryquestions($subvalue->Name,$annualreportdata->YearReported,$annualreportdata->Mainkey);
                            }else{
                                $Questions = ARHelper::Sectionsummaryquestions($subvalue->Name,'','');
                            }

                            @endphp
                            @foreach($Questions as $Quesval)
                                @php
                                $j++;
                                @endphp
                                <label class="ques" id="{{ $i }}">{{ $i++ }}. {!! strip_tags($Quesval['QuestionLabel']) !!}</label>
                                <label class="res-data">
                                    {{ $Quesval['QuestioncodeAns'] ?? '' }}
                                </label><br>
                                @if($Quesval['childQuestionLabel'] != null)
                                    <span id="childques{{$j}}">
                                        <label class="child">
                                            {{ $Quesval['childQuestionLabel'] ?? '' }}
                                        </label>
                                        <label class="res-data">
                                            {{ $Quesval['ChildQuestioncodeAns'] ?? '' }}
                                        </label><br>
                                    </span>
                                @endif

                                @if($Quesval['Questype'] == "Checkbox")
                                    @php
                                    $getcheckbox = explode(", ",$Quesval['QuesCheckbox']);
                                    @endphp
                                    @foreach($getcheckbox as $key => $value)
                                    @php
                                        $checkval = explode(":",$value);
                                    @endphp
                                        <label class="check-box-value">{!! $checkval[0] !!}</label>
                                        <label class="res-data">
                                            @if($annualreportdata != "")
                                                {{ ARHelper::churchReportDatas($annualreportdata->Mainkey,$annualreportdata->YearReported,$checkval[1]) }}
                                            @endif
                                        </label><br>
                                    @endforeach
                                @endif
                                @if($Quesval['Questype'] == "Percent")
                                    @php
                                        $percent = ARHelper::getpercent($Quesval['Questioncode'],$year,$commondata->Mainkey);
                                    @endphp
                                    @foreach($percent as $value)
                                        <label class="child">{{ $value->Name }}</label><label class="res-data">{{ $value->Percent ?? ''}}%</label><br>
                                    @endforeach
                                @endif
                                @if($Quesval['Questype'] == "Multi Dropdown")
                                    @php
                                        $multidropdown = ARHelper::getMultiDropdown($Quesval['Questioncode'],$commondata->Mainkey);
                                    @endphp
                                    @foreach($multidropdown as $value)
                                        <label class="child">{{$value->FieldName}}</label><br>
                                    @endforeach
                                @endif
                            @endforeach

                        @endforeach
                        <br>
                    @endforeach

                </div>
            </div>
        </section>
    </div>
</div>
{{-- <div id="button">
    <a href="{{url('pdfgenerate',[$mainkey,$year])}}"><img class="noPrint" src="/assets/img/print.png" width="160px"></a>
</div> --}}
<div id="button">
<a href="javascript:window.print();" onclick="document.title='AnnualReport1{{$year}}'; window.print(); return false;"><img class="noPrint" src="/assets/img/print.png" width="160px"></a>
</div>
<script>

yearchange();
function yearchange(){

    yearval = { 0:'PrevYear', 1:'CurrentYear', 2:'ReportYear'};

    $.each(yearval, function(ind,val) {

        if(val == 'PrevYear'){
            Yeardata ={{$year}}-1;
        }else if(val == 'CurrentYear'){
            Yeardata = {{$datenow->year}};
        }else if(val == 'ReportYear'){
            Yeardata ={{$year}};
        }else{
            Yeardata ="";
        }

        var foundin = $('label.ques:contains("('+val+')")');
        $.each(foundin, function(index,value) {
            id = $(this).attr('id');
            data = $('label.ques#'+id+':contains("('+val+')")').text($('label.ques#'+id+':contains("('+val+')")').text().replace("("+val+")",Yeardata));
        });
    });
 
}

//auto print
const thePath = window.location.hash;
    if(thePath == "#print"){
        document.title='AnnualReport1{{$year}}';
        window.print();
    }
    function getchild(id,spanId,year,mainkey,code,url){

        data = {
                id : id,
                year : year,
                mainkey : mainkey,
                code : code
        };
        var getchildans = "";
        $.ajax({
            type: "get",
            url: url,
            data:data,
            async:false,
            success: function(response) {
                if(response.dataQues != ''){
                    data = response.dataQues;
                    getchildans = getChildAns(data.Questioncode,'{{$year}}','{{$commondata->Mainkey}}');
                    $('#childques'+spanId).empty().append('<label class="child">'+data.QuestionLabel+'</label><label class="res-data">'+getchildans+'</label><br>');
                }
            }
        });
        return getchildans;
    }

    function getChildAns(ques,year,mainkey){
        var dataval;
        $.ajax({
            type: "get",
            url: "{{ url('getChildAns') }}",
            data:{
                ques : ques,
                year : year,
                mainkey : mainkey
            },
            async:false,
            success: function(response) {
                dataval = response.dataQues;
            }
        });
        return dataval;
    }


    function restrictUser(){
        alert('We regret to inform you that your reporting period has expired!');
    }
    function restrictUserchurchactive(){
        alert('This Church is not Active !');
    }
</script>

@endsection
