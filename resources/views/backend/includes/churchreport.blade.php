@extends('backend.layouts.main')
@section('content')
@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;
use Illuminate\Support\Facades\Auth;

$year = request()->segment(count(request()->segments())); 

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
    line-height: 14px;
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
    font-size:12px;
    color:#801214;
}
.main-title.sub{
    font-size:10px;
}
a:hover{
    color:#801214;
    text-decoration:underline;
}
@media print {
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
.footer-top{
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
@page {
    size:A4 Portrait;
    size: 21cm 29.7cm;
    margin-right: 0px;
    margin-top: 0;
    margin-bottom: 0;
    margin: -5px;
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
                    <center><label class="main-title high">The Christian and Ministry Alliance</label><center>
                    <center><label class="main-title high">Local Alliance Church and Annual Report</label></center>
                    <center><label class="main-title sub">Reporting Period : January 1, {{$year}} - December 31, {{$year}}</label></center>
                    <center><label class="main-title high">Report Due : February 23, 2022</label></center>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                    <br>
                    <center><label class="main-title">CHURCH CODE :</label></center>
                    <center>
                        <label class="">
                        {{substr($commondata->ChurchCode,0,2)?? '' }}-{{substr($commondata->ChurchCode,2,2)?? '' }}-{{substr($commondata->ChurchCode,4,3)?? '' }}
                        </label>
                    </center>
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
                    <label class="main-title high">Name of Individual Entering Report</label><label class="res-data">{{ ARHelper::getMainkeyName($commondata->UpdateBy) ?? '' }}</label><br>
                </div>
            </div>
            <br>
            <br>
            <div class="row" style="padding:0px 10px;">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" >
                    <label class="main-title">I. GENERAL ATTENDANCE DATA</label><br>
                    <label class="sub-title"><a href="{{url('AnnualReport/ChurchReport/Membership/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">Membership</a></label><br>
                    <label class="">Members as of 12/31/{{$year - 1}}</label><label class="res-data">{{$annualreportdata->PreviousYearMembers?? '' }}</label><br>	
                    <label class="">Members removed in {{$year}}</label><label class="res-data">{{$annualreportdata->MembersRemoved?? '' }}</label><br>
                    <label class="">Members added in {{$year}}</label><label class="res-data">{{$annualreportdata->MembersAdded?? '' }}</label><br>
                    <label class="sub-label">Members as of 12/31/{{$year}}</label><label class="res-data">{{$annualreportdata->MembersTotal?? '' }}</label><br>
                    <label class="">Adherents</label><label class="res-data">{{$annualreportdata->AdherentsTotal?? '' }}</label><br>
                    <label class="sub-label">Total Members + Adherents</label><label class="res-data">{{$annualreportdata->InclusiveTotal?? '' }}</label><br>
                    <br>
                    <label class="sub-title"><a href="{{url('AnnualReport/ChurchReport/Membership/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">Ethnicity</a></label><br>
                    <label class="">Approximate Percentage</label><label class="res-data">{{$annualreportdata->MembersRemoved?? '' }}</label><br>
                    <br>
                    <label class="sub-title"><a href="{{url('AnnualReport/ChurchReport/Attendance/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">Average Weekly Attendance</a></label><br>
                    <label class="">Main worship service(s) combined</label><label class="res-data">{{$annualreportdata->MorningAttendance?? '' }}</label><br>	
                    <label class="">Primary worship language/dialect</label><label class="res-data">{{$annualreportdata->Language?? '' }}</label><br>	
                    <label class="">Weekend digital service(s)</label><label class="res-data">{{$annualreportdata->DigitalAttendance?? '' }}</label><br>	
                    <label class="">Adult small group ministries</label><label class="res-data">{{$annualreportdata->SmallGroupAttendance?? '' }}</label><br>	
                    <label class="">Youth group ministries (ages 12-18)</label><label class="res-data">{{$annualreportdata->YouthGroupAttendance?? '' }}</label><br>	 
                    <label class="">Children’s ministries (through age 11)</label><label class="res-data">{{$annualreportdata->ChildrenAttendance?? '' }}</label><br>
                    <br>
                    <label class="main-title">II.	EVANGELISM DATA</label><br>
                    <label class="sub-title"><a href="{{url('AnnualReport/ChurchReport/Professions-Of-Faith/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">Professions of Faith in {{$year}}</a></label><br>
                    <label class="">Children (through age 11)</label><label class="res-data">{{$annualreportdata->Conversions0to11?? '' }}</label><br>	
                    <label class="">Youth (ages 12-18)</label><label class="res-data">{{$annualreportdata->Conversions12to18?? '' }}</label><br>	
                    <label class="">Young Adults (ages 19-30)</label><label class="res-data">{{$annualreportdata->Conversions19to30?? '' }}</label><br>	
                    <label class="">Adults (ages 31 and over)</label><label class="res-data">{{$annualreportdata->ConversionsOver30?? '' }}</label><br>
                    <label class="sub-label">Total Professions of Faith</label><label class="res-data">{{$annualreportdata->ConversionsTotal?? '' }}</label><br>
                    <br>
                    <label class="sub-title"><a href="{{url('AnnualReport/ChurchReport/Baptisms/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">Baptisms in {{$year}}</a></label><br>
                    <label class="sub-label">Total Baptisms</label><label class="res-data">{{$annualreportdata->BaptismsTotal?? '' }}</label><br>
                    <br>
                    <label class="main-title">III.	FINANCIAL DATA</label><br>
                    <label class="sub-title"><a href="{{url('AnnualReport/ChurchReport/Income/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">Church Income</a></label><br>
                    <label class="">Local church</label><label class="res-data">${{$annualreportdata->IncomeLocal?? '' }}</label><br>	
                    <label class="">Giving units supporting local income</label><label class="res-data">${{$annualreportdata->IncomeLocal?? '' }}</label><br>
                    <label class="">Giving units supporting the Great</label><label class="res-data">{{$annualreportdata->FamilySupportLocal?? '' }}</label><br>
                    <label class="">Commission Fund (GCF)</label><label class="res-data">{{$annualreportdata->FamilySupportGCM?? '' }}</label><br>
                    <br>
                    <label class="main-title">IV.	MISSIONS</label><br>
                    <label class="sub-title"><a href="{{url('AnnualReport/ChurchReport/C&MA-Missions/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">C&MA Short-Term Missions</a></label><br>
                    <label class=""># of people to C&MA foreign sites</label><label class="res-data">{{$annualreportdata->STMCMAForeign?? '' }}</label><br>	
                    <label class=""># of people to C&MA domestic sites</label><label class="res-data">{{$annualreportdata->STMCMADomestic?? '' }}</label><br>
                    <label class="">$ contributed to C&MA mission trips</label><label class="res-data">${{$annualreportdata->STMCMAContributions?? '' }}</label><br>
                    <label class="">Did you hold an Alliance Missions Emphasis</label><label class="res-data">{{$annualreportdata->STMEvent?? '' }}</label><br> 
                    <label class="">event in {{$year}}?</label><br>
                    <label class="">Alliance International Financial Partnerships</label><label class="res-data"></label><br>
                    <label class="">Alliance International Partnerships</label><label class="res-data"></label>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <label class="sub-title"><a href="{{url('AnnualReport/ChurchReport/Non-C&MA-Missions/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">Non-C&MA Short-Term Missions</a></label><br>
                    <label class=""># of people to non-C&MA foreign sites</label><label class="res-data">{{$annualreportdata->STMNonCMAForeign?? '' }}</label><br>	
                    <label class=""># of people to non-C&MA domestic sites</label><label class="res-data">{{$annualreportdata->STMNonCMADomestic?? '' }}</label><br>
                    <label class="">$ contributed to non-C&MA missions & trips</label><label class="res-data">${{$annualreportdata->STMNonCMAContributions?? '' }}</label><br>
                    <br>
                    <label class="main-title">V. OTHER DATA</label><br>
                    <label class="sub-title"><a href="{{url('AnnualReport/ChurchReport/Church-Multiplication/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">Church Multiplication</a></label><br>
                    <label class=""># of new leaders in development process</label><label class="res-data">{{$annualreportdata->LeadersDeveloped?? '' }}</label><br>	
                    <label class=""># of new leaders deployed beyond context</label><label class="res-data">{{$annualreportdata->LeadersDeployed?? '' }}</label><br>
                    <label class="">Intent to plant in the next three years</label><label class="res-data">{{$annualreportdata->PlantIntent?? '' }}</label><br>
                    <label class="">Church(es) planted in the last three years</label><label class="res-data">{{$annualreportdata->ChurchPlant?? '' }}</label><br>
                    <br>
                    <label class="sub-title"><a href="{{url('AnnualReport/ChurchReport/Church-Advance/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">Church Advance</a></label><br>
                    <label class="">Organized group prayer</label><label class="res-data">{{$annualreportdata->GroupPrayer?? '' }}</label><br>	
                    <label class="">Discipleship roadmap</label><label class="res-data">{{$annualreportdata->DiscipleshipPlan?? '' }}</label><br>
                    <label class="">Leadership development roadmap</label><label class="res-data">{{$annualreportdata->DiscipleshipPlanNumber?? '' }}</label><br>
                    <label class="">Evangelism roadmap </label><label class="res-data">{{$annualreportdata->LeadershipPlan?? '' }}</label><br>
                    <label class="">Community transformation roadmap </label><label class="res-data">{{$annualreportdata->LeadershipPlanNumber?? '' }}</label><br>
                    <label class="">Request More Information </label><label class="res-data"></label><br>
                    <label class="">Mortgage debt </label><label class="res-data"></label><br>
                    <label class="">Special mailing inserts </label><label class="res-data"></label><br>
                    <br>
                    <label class="sub-title"><a href="{{url('AnnualReport/ChurchReport/Church-Staff/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">Church Staff (paid & volunteer)</a></label><br>
                    <label class="">Contact information:</label><label class="res-data"> Name | Email</label><br>
                    <label class="">Administrative Assistant</label><label class="res-data">_________________________</label><br>	
                    <label class="">Board Chairman</label><label class="res-data">_________________________</label><br>
                    <label class="">Children Leader (through age 11)</label><label class="res-data">_________________________</label><br>
                    <label class="">Alliance Women Leader</label><label class="res-data">_________________________</label><br>
                    <label class="">Men’s Ministry Leader</label><label class="res-data">_________________________</label><br>
                    <label class="">Missions Leader</label><label class="res-data">_________________________</label><br>
                    <label class="">Secretary of Board</label><label class="res-data">_________________________</label><br>
                    <label class="">Treasurer</label><label class="res-data">_________________________</label><br> 
                    <label class="">Vice Chair of Board</label><label class="res-data">_________________________</label><br>
                    <label class="">Young Adult Leader</label><label class="res-data">_________________________</label><br>
                    <label class="">Youth (12-18) Leader</label><label class="res-data">_________________________</label><br>
                    <br>
                    <label class="sub-title"><a href="{{url('AnnualReport/ChurchReport/Comments/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">Comments</a></label><br>
                </div>
        </section>
    </div>
</div>

<div id="button">
<a href="javascript:window.print();" onclick="document.title='AnnualReport1{{$year}}        '; window.print(); return false;"><img class="noPrint" src="/assets/img/print.gif" border="0"></a>
</div>

@endsection