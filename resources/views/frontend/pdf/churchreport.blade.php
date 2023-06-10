<!doctype html>
<html >
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
  
    <title>Annual Report</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
     </head>
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
        /* .content-col{
            column-count: 2;
        } */
        .child{
            padding-left:30px;
        }
        .child p{
            margin-bottom: 0rem!important;
        }
        a{
            color:#801214;
        }
        .content-col{
            column-count: 2;
        }
        </style>
</head>
@php
    use Illuminate\Support\Facades\Session;
    use App\Helpers\ARHelper;
    use Illuminate\Support\Facades\Auth;
    use Carbon\Carbon;

    $segments = request()->segments();
    $mainkey = $segments[1];
    $year = $segments[2];
    $j = 0;
@endphp
<title>Annual Report</title>
<body>
<div class="col-md-12" id="bri_ind_container">
    <div class="php-email-form">
        <section class="section-church-report" style="padding:0px;">
            <div class="row head-row">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 20%">
                            <center><img src="http://127.0.0.1:8000/assets/img/alliance-logo.jpg" alt="" width="80
                                px"></center>
                        </td>
                        <td style="width: 60%">
                            <center>
                                <table style="width: 100%">
                                    <tr>
                                        <td><center><label class="main-title high">The Christian and Ministry Alliance</label><center></td>
                                    </tr>
                                    <tr>
                                        <td><center><label class="main-title high">Local Alliance Church and Annual Report</label></center></td>
                                    </tr>
                                    <tr>
                                        <td><center><label class="main-title sub">Reporting Period : January 1, {{$year}} - December 31, {{$year}}</label></center></td>
                                    </tr>
                                    <tr>
                                        <td><center><label class="main-title high">Report Due : February 23, 2023</label></center></td>
                                    </tr>
                                </table>
                            </center>
                        </td>
                        <td style="width: 20%">
                            <center>
                                <table>
                                    <tr></tr>
                                    <tr><center><label class="main-title high">CHURCH CODE</label></center></tr>
                                    <tr><center>
                                        <label class="">
                                            {{substr($commondata->ChurchCode,0,2)?? '' }}-{{substr($commondata->ChurchCode,2,2)?? '' }}-{{substr($commondata->ChurchCode,4,3)?? '' }}
                                        </label>
                                    </center></tr>
                                    <tr></tr>
                                </table>
                            </center>
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            <div class="row" style="padding:0px 10px;">
                <table style="width: 100%">
                    <tr style="font-size: 12px">
                        <td style="width: 50%">
                            <table style="width: 100%">
                                <tr>
                                    <td><label class="main-title high">Official Directory City</label><label class="res-data">{{$commondata->MailingCity ?? ''?? '' }}</label></td>
                                </tr>
                                <tr>
                                    <td><label class="main-title high">E-mail </label><label class="res-data"><a href="mailto:{{$commondata->USAEmail ?? '' }}">{{$commondata->USAEmail ?? '' }}</a></label></td>
                                <tr>
                                    <td><label class="main-title high">WebSite Address</label><label class="res-data"><a href="" target="_blank">{{$commondata->WebSite ?? '' }}</a></label></td>
                                </tr>
                            </table> 
                        </td>
                        <td style="width: 50%">
                            <table style="width: 100%">
                                <tr>
                                    <td><label class="main-title high">Church Name </label><label class="res-data">{{$commondata->MailingName ?? ''}}</label></td></tr>
                                <tr>
                                    <td>
                                        <div class="col-6">
                                            <label class="main-title high">Telephone</label><label class="res-data">{{$commondata->OfficePhone ?? ''}}</label>
                                        </div>
                                        <div class="col-6">
                                            <label class="main-title high">Fax </label><label class="res-data">{{$commondata->Fax ?? '' }}</label>
                                        </div>
                                    </td>
                                <tr>
                                    <td><label class="main-title high">Name of Individual Entering Report</label><label class="res-data">{{ ARHelper::getMainkeyName($commondata->UpdateBy) ?? '' }}</label></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            <div class="row" style="padding:0px 10px;">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 content-col">
                    
                    @php $i=1; @endphp
                    @foreach($mainsection as $value)
                    <table style= "width:100%">
                        <tr>
                            <td colspan="2"><label class="main-title">{{ strtoupper($value->Name); }}</label></td>
                        </tr>
                        @php
                          $subsection = ARHelper::subsection($value->Name);
                        @endphp

                        @foreach($subsection as $subvalue)

                            <tr>
                                <td colspan="2">
                                    <label class="sub-title">
                                        @php
                                        $usertype = Auth::user()->usertype;
                                        $true = ARHelper::restrictionActiveDates($usertype);
                                        @endphp
                                        @if($true == 1)
                                            <a href="{{url('AnnualReport/ChurchReport/'.ARHelper::rmvsplcharcter($subvalue->MainsectionName).'/'.ARHelper::rmvsplcharcter($subvalue->Name).'/'.ARHelper::encryptUrl($commondata->Mainkey).'/'.$year)?? '' }}">{{ $subvalue->Name }}<span style="margin-left: 5px"><i class="fa fa-edit"></i></span></a>
                                        @else
                                            <a href="javascript:void(0)" onclick="restrictUser()">{{ $subvalue->Name }}</a>
                                        @endif
                                    </label>
                                </td>
                            </tr>
                            @php
                            if($annualreportdata != ""){
                                $Questions = ARHelper::Sectionsummaryquestions($subvalue->Name,$annualreportdata->YearReported,$annualreportdata->Mainkey);
                            }else{
                                $Questions = ARHelper::Sectionsummaryquestions($subvalue->Name,'','');
                            }
                            @endphp
                            @foreach($Questions as $Quesval)
                                <tr>
                                    <td>
                                        @php
                                        $j++;
                                        @endphp
                                        <label class="ques">{{ $i++ }}. {!! strip_tags($Quesval['QuestionLabel']) !!}</label>
                                    </td>
                                    <td>
                                        <label class="res-data">
                                            {{ $Quesval['QuestioncodeAns'] ?? '' }}
                                        </label><br>
                                    </td>
                                </tr>
                                @if($Quesval['childQuestionLabel'] != null)
                                <tr>
                                    <td>
                                        <span id="childques{{$j}}">
                                            <label class="child">
                                                {{ $Quesval['childQuestionLabel'] ?? '' }}
                                            </label>
                                        </span>
                                    </td>
                                    <td> 
                                        <label class="res-data">
                                            {{ $Quesval['ChildQuestioncodeAns'] ?? '' }}
                                        </label><br>
                                    </td> 
                                </tr>
                                @endif
                                @if($Quesval['Questype'] == "Checkbox")
                                @php
                                $getcheckbox = explode(", ",$Quesval['QuesCheckbox']);
                                @endphp
                                @foreach($getcheckbox as $key => $value)
                                @php
                                    $checkval = explode(":",$value);
                                @endphp
                                <tr>
                                    <td><label class="check-box-value">{!! $checkval[0] !!}</label></td>
                                    <td>
                                        @if($annualreportdata != "")
                                        <label class="res-data">{{ ARHelper::churchReportDatas($annualreportdata->Mainkey,$annualreportdata->YearReported,$checkval[1]) }}</label>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                @if($Quesval['Questype'] == "Percent")
                                <tr>
                                    @php
                                        $percent = ARHelper::getpercent($Quesval['Questioncode'],$year,$commondata->Mainkey);
                                    @endphp
                                    @foreach($percent as $value)
                                    <td>
                                        <label class="child">{{$value->Name}}</label>   
                                    </td>
                                    <td> 
                                        <label class="res-data">{{$value->Percent}}%</label>
                                    </td> 
                                    @endforeach
                                </tr>  
                                @endif
                                @if($Quesval['Questype'] == "Multi Dropdown")
                                <tr>
                                    @php
                                        $multidropdown = ARHelper::getMultiDropdown($Quesval['Questioncode'],$commondata->Mainkey);
                                    @endphp
                                    @foreach($multidropdown as $value)
                                    <td colspan="2">
                                        <label class="child">{{$value->FieldName}}</label><br>  
                                    </td>
                                    @endforeach
                                </tr> 
                                @endif
                            @endforeach
                        @endforeach
                    </table>
                    <br>
                    @endforeach
                    
                </div>
            </div>
        </section>
    </div>
</div>
</body>

</html>
