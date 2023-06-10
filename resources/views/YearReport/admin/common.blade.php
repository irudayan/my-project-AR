@extends('YearReport.layouts.index')
@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;
use Carbon\Carbon;
use App\Models\DistrictChurch;
$segments = request()->segments();
$pagesectiondata = $segments[3];
$year = $segments[5];
$datenow = Carbon::now();
$j = 0;
$usertype = Auth::user()->usertype;
$getMainkey = explode(",", base64_decode($segments[4]))[0] - 122354125410;
$districtnames = DistrictChurch::where('ChurchMainkey',$getMainkey)->first();
$MainkeyNO = ARHelper::decryptUrl($segments[4]);


@endphp
@section('contents')
<style>
  .submitstyle{
    color: #fff;
  border: none;
  background-color: #801214;
  padding: 2px 17px;
  border-radius: 4px;
  cursor: pointer;
  }
  
</style>
<div class="tab-section">
  <br>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <form role="form" id="report-form">
          @csrf
        <section class="sub-section">
          @if($annualreportdata != "")
          <input type="hidden" name="id" id="id" value="{{ ARHelper::churchReportData(ARHelper::decryptUrl($segments[4]),$year,'id') ?? ''}}">
          @endif
          <span id="append-id"></span>
          <input type="hidden" name="sectionName" value="{{$segments[3]}}">
          <input type="hidden" name="Mainkey" id="Mainkey" value="{{ARHelper::decryptUrl($segments[4])}}">
          <input type="hidden" name="YearReported" id="YearReported" value="{{$segments[5]}}">
          @foreach($pageSection as $value)
            @php
              $questions = ARHelper::SectionQuestions($value->Name);
            @endphp
            <h5 class="sub-section-head">{{$value->Name}}</h5>

            @foreach($questions as $val)
              @if($val->Questype == "Multi Dropdown")
              <label class="head-ques">
                {!! $val->QuestionText !!}
              </label>
              @endif
            @endforeach
            @if($value->PageSectionCode != "Comments")
            <table class="table">
              <thead>
                  @if($value->PagesectionColumn != "")
                    @php
                     $column = explode(',',$value->PagesectionColumn);
                    @endphp
                    
                    @foreach($column as $key => $col)
                    
                     
                      @if($col != "")

                      @php  $data = str_replace("Action","",$col);@endphp
                      @if ($usertype == 'NationalOffice')
                      <th class="col-head">{{ $data }}</th>
                        @else
                         <th class="col-head">{{ $col }}</th>
                      @endif
                     

                      @endif

                    @endforeach
                  @endif
              </thead>
              <tbody>
                @foreach($questions as $val)
                  @php
                  $j++;
                  if($annualreportdata != ""){
                    $getdata = ARHelper::churchReportData($annualreportdata->Mainkey,$annualreportdata->YearReported,$val->Questioncode);
                    $subopt = $val->SuboptionQuestion;

                    if($subopt == "Yes"){
                      $showdata = "Y";
                    }elseif($subopt == "No"){
                      $showdata = "N";
                    }else{
                      $showdata = $val->SuboptionQuestion;
                    }
                  }else{
                    $getdata = "";
                    $subopt = $val->SuboptionQuestion;

                    if($subopt == "Yes"){
                      $showdata = "Y";
                    }elseif($subopt == "No"){
                      $showdata = "N";
                    }else{
                      $showdata = $val->SuboptionQuestion;
                    }
                  }
                  @endphp


                  <script>
                    $(document).ready(function(){
                      url = "{{url('getChild')}}";
                      getchild('{{ARHelper::churchReportData(ARHelper::decryptUrl($segments[4]),$segments[5],$val->Questioncode)}}','{{$val->id}}','{{$j}}',url);
                    });
                  </script>

                  <tr>
                    @if($val->Questype != "Checkbox")
                      @if($val->Questype == "Percent")
                          @php
                          $percentvalue = ARHelper::percentget(ARHelper::decryptUrl($segments[4]),$segments[5],$val->Questioncode);
                          $in = 1;
                          @endphp
                          @foreach( $percentvalue as $percent_value)
                          @php $in++; @endphp
                          <tr class="percent">
                              <td class="percent-name">{{ $percent_value->Name }}</td>
                              <td>
                                <input type="range" name="Ethnicityrange[]" class="form-range" data-id="{{ $percent_value->Percent
                                +$in }}" value="{{ $percent_value->Percent }}" data-val="{{ $percent_value->Name }}" data-table="{{$val->Questioncode}}" data-val-id="{{ $percent_value->id }}" min="0" max="100" id="myRange{{ $percent_value->Percent+$in}}">
                              </td>
                              <td>
                                <span id="perValue{{ $percent_value->Percent+$in }}" class="perValueSp"></span>%</td>
                              <td class=""></td>
                              <td><i id ="Percentdel" class="fas fa-trash" data-table="{{$val->Questioncode}}" data-id="{{ $percent_value->id }}"></i></td>
                          </tr>
                          @endforeach
                      @else
                        @if($val->Questype == "Multi Dropdown")
                          @php
                          $multidropdown = ARHelper::multidropdownget($churchdata->Mainkey,$val->Questioncode);
                          @endphp
                          @foreach( $multidropdown as $multidropdown_value)
                          <tr>
                            <td>{{ $multidropdown_value->FieldName }}</td>
                            <td><i id ="multidropdowndel" data-id="{{ $multidropdown_value->id }}" data-table="{{ $val->Questioncode }}" class="fas fa-trash"></i></td>
                          </tr>
                          @endforeach
                        @else

                          <td>
                            <label id="{!! $val->Questioncode ?? '' !!}" dataid="{{$val->id}}">{!! $val->QuestionText ?? '' !!}</label><br>
                            <span id="ChildQuestext{{$j}}">
                            </span>
                          </td>
                          <td>

                            @if($val->Questype == "Text")
                              @if($annualreportdata != "")
                                @php
                                $Quesdata = ARHelper::churchReportData($annualreportdata->Mainkey,$annualreportdata->YearReported,$val->Questioncode);

                               @endphp
                              @endif
                              <input class="form-control tabchange" type="text" onclick="quesasst(this.id)" name="{{ $val->Questioncode }}" id="{{ $val->Questioncode }}" data-id="{{$val->id}}" data-val="{{$j}}" data-label="{{$val->QuestionLabel}}"  style="min-width: 150px;" value="{{ $Quesdata ?? '' }}" @if($val->disableCheckbox == "Y") readonly @endif data-rule-required="true"><br>


                            @endif

                            @if($val->Questype == "Numeric")
                              @if($annualreportdata != "")
                                @php
                                $Quesdata = ARHelper::churchReportData($annualreportdata->Mainkey,$annualreportdata->YearReported,$val->Questioncode);
                                @endphp
                              @endif
                              <input class="form-control Calc tabchange" type="text"  onkeypress="return /[0-9]/i.test(event.key),isNumberKey()" onclick="quesasst(this.id)" name="{{ $val->Questioncode }}" id="{{ $val->Questioncode }}" maxlength="8" data-id="{{$val->id}}" data-val="{{$j}}" data-label="{{$val->QuestionLabel}}"  style="min-width: 150px;" value="{{ $Quesdata ?? '' }}" @if($val->disableCheckbox == "Y") readonly @endif data-rule-required="true"><br>

                            @endif

                            @if($val->Questype == "Formula")
                              @if($annualreportdata != "")
                                @php
                                $Quesdata = ARHelper::churchReportData($annualreportdata->Mainkey,$annualreportdata->YearReported,$val->Questioncode);
                                @endphp
                              @endif
                              <input class="form-control Calc {{$val->Questype}} tabchange" type="text" formuladata="{{ $val->Formula }}" onclick="quesasst(this.id)" name="{{ $val->Questioncode }}" id="{{ $val->Questioncode }}" data-id="{{$val->id}}" data-val="{{$j}}" data-label="{{$val->QuestionLabel}}"  style="min-width: 150px;" value="{{ $Quesdata ?? '' }}" @if($val->disableCheckbox == "Y") readonly @endif data-rule-required="true"><br>

                            @endif

                            @if($val->Questype == "Dropdown")
                            <select name="{{ $val->Questioncode }}" onclick="quesasst(this.id,'Questioncode')" id="{{ $val->Questioncode }}" data-id="{{ $val->id }}" data-val="{{$j}}" data-label="{{$val->QuestionLabel}}" class="form-select tabchange" @if($val->disableCheckbox == "Y") readonly @endif style="min-width: 150px;">
                              <option value=""></option>
                              @php
                              $QuesdropdownOption = explode(", ",$val->QuesdropdownOption);
                              @endphp
                              @foreach($QuesdropdownOption as $key=>$qesdrop)
                                @php
                                if($annualreportdata != ""){
                                  $dropval = ARHelper::churchReportData(ARHelper::decryptUrl($segments[4]),$segments[5],$val->Questioncode) ?? '' ;
                                  if($qesdrop == "Yes"){
                                    $dropdownval = "Y";
                                  }elseif($qesdrop == "No"){
                                    $dropdownval = "N";
                                  }else {
                                    $dropdownval = $qesdrop;
                                  }
                                }else{
                                  $dropval = "";
                                  $dropdownval = $qesdrop;
                                }
                                @endphp
                                <option value="{{$dropdownval}}" @if($dropdownval == $dropval) selected @endif>{{$qesdrop}}</option>
                              @endforeach
                            </select>
                            <br>

                            @endif
                            <label id="emptyField{{$val->id}}" style="display:none"></label>
                            <span id="ChildQuesField{{$j}}">

                            </span>
                          </td>
                        @endif
                      @endif
                    @else
                      <td colspan="2">
                        <label id="checkbox-ques-label">{!! $val->QuestionText ?? '' !!}</label><br>
                        <div class="row ch-ad-pro" style="padding-left: 70px;">
                          @php
                          $getcheckbox = explode(", ",$val->QuesCheckbox);
                          @endphp
                          <div class="col-10">
                            @foreach($getcheckbox as $key => $value)
                            @php
                              $checkval = explode(":",$value);
                            @endphp
                              <label class="">{{$checkval[0]}}</label><br>
                            @endforeach
                          </div>
                          <div class="col-2">
                            @foreach($getcheckbox as $key => $value)
                            @php
                              $checkval = explode(":",$value);
                              if($annualreportdata != ""){
                                $datacheck = ARHelper::churchReportData($annualreportdata->Mainkey,$annualreportdata->YearReported ,$checkval[1]) ?? '' ;
                              }else{
                                $datacheck = "";
                              }
                            @endphp
                              <span>
                                <input type="checkbox" onchange="quesasst(this.id,'Questioncode')" name="{{$checkval[1]}}" id="{{$val->Questioncode ?? ''}}" data-id="{{ $val->id }}" class="form-check-input tabchange" value="Y" data-label="{{$val->QuestionLabel}}" @if($datacheck == "Y") Checked @endif>
                              </span><br>
                            @endforeach
                          </div>
                        </div>
                      </td>
                    @endif
                    @if($val->Questype != "Percent")
                      @if($val->Questype != "Multi Dropdown")
                        <td>

                          @if($val->Questype == "Text")
                            <label>
                              <p>
                              {{ ARHelper::churchReportData(ARHelper::decryptUrl($segments[4]),$segments[5] - 1 ,$val->Questioncode) ?? '' }}
                            </p>
                            </label>
                          @endif

                          @if($val->Questype == "Numeric")
                            <label>
                              <p>
                              {{ ARHelper::churchReportData(ARHelper::decryptUrl($segments[4]),$segments[5] - 1 ,$val->Questioncode) ?? '' }}
                            </p>

                            </label><br>
                          @endif

                          @if($val->Questype == "Formula")
                            <label>
                              <p>
                              {{ ARHelper::churchReportData(ARHelper::decryptUrl($segments[4]),$segments[5] - 1 ,$val->Questioncode) ?? '' }}
                              </p>
                            </label><br>
                          @endif

                          @if($val->Questype == "Dropdown")
                            <label>
                              <p>
                              {{ ARHelper::churchReportData(ARHelper::decryptUrl($segments[4]),$segments[5] - 1 ,$val->Questioncode) ?? '' }}
                              </p>
                            </label><br>
                          @endif

                          @if($val->Questype == "Checkbox")
                            <label id="empty-checkbox-label">
                              <p></p>
                            </label><br>
                            @foreach($getcheckbox as $key => $value)
                            @php
                              $checkval = explode(":",$value);
                            @endphp
                              <span>{{ ARHelper::churchReportData(ARHelper::decryptUrl($segments[4]),$segments[5] - 1 ,$checkval[1]) ?? '' }}</span><br>
                            @endforeach
                          @endif
                          <label id="emptylabel{{$val->id}}" style="display:none">
                          </label>
                          <span id="ChildQuesPrevAns{{$j}}">

                          </span>
                        </td>
                      @endif
                    @endif
                  </tr>
                @endforeach

            {{-- Staff section start --}}
            @if ( $segments[3] == 'ChurchStaff')
            @php
            $usertype = Auth::user()->usertype;
          @endphp
           @if ( $usertype != 'NationalOffice')
            <span style="margin-left: 36em"><button id="addstaffs" class="addstaffs"><i class="fas fa-add"></i> Add</button></span>
            @endif
            @foreach ($registerstaffs as $regstaff)
           @if ($regstaff->StaffID == '' && $regstaff->StaffOrgID == '')
            <tr>
                <td class="staffnames">
                    {{$regstaff->username}}
                </td>
                <td class="staffemail">
                  <a href="mailto:{{ $regstaff->email }}"> {{$regstaff->email}}</a>
                </td>
                <td class="rolenames">
                  @php
                    $newstaffrole =  str_replace(",", "<br />", nl2br($regstaff->roles));
                  @endphp
                    <div>{!! $newstaffrole !!}</div>
                </td>
                <td>
                  {{-- @if ($usertype != 'NationalOffice') --}}
                  @if($usertype == 'Admin' || $usertype == 'District')
                        <a href="javascript:void(0)" class="mainsectionedit" id="mainsectionedit{{$regstaff->id}}" data-id="{{$regstaff->id}}" data-val="newuser" data-original-title="view"><i class="fa fa-edit"></i></a>

                        <a href="javascript:void(0)" class="newstaffroledelete" id="newstaffroledelete{{$regstaff->id}}" data-id="{{$regstaff->id}}" data-val="newstaffroledelete" data-original-title="Delete"><i class="fa fa-trash"></i></a>

                  @endif
                {{-- @endif --}}

                </td>
            </tr>
            @endif
            @endforeach
            @foreach ($staff as $staffval)
            @php

                $stafftitle = isset($staffval->Title) ? $staffval->Title.' ' :  '';
                $midname = isset($staffval->MiddleName) ? ' '.$staffval->MiddleName : '';
                $suffix = isset($staffval->Suffix) ? ' '.$staffval->Suffix : '';
                $lastname = isset($staffval->LastName) ? $staffval->LastName.',' : '';
                $fullname = $lastname.' '.$stafftitle.''.$staffval->FirstName.''.$midname.''.$suffix;
                $entitymainkey = $staffval->EntityMainkey;
                $empty = '';
                $staffname = $staffval->FullName;
            @endphp

            <tr>
                <td class="staffnames">
                  @if(isset($staffval->LastName))
                  {{ $fullname }}
                  @elseif(isset($staffname))
                  {{$staffname}}
                  @else
                  {{ $empty }}
                  @endif

                    <div class="staff-title">{{ $staffval->PositionTitle }}</div>
                </td>
                <td class="staffemail">
                    <div><a href="mailto:{{ $staffval->Email }}">{{ $staffval->Email }}</a> </div>
                    <div>
                        {{$staffval->Phone}}
                        @if ($staffval->Phone_Extension != '')
                        {{ $staffval->Phone_Extension }}
                        @endif
                    </div>
                </td>

                <td class="rolenames" style="width: 140px;">
                    @php
                        $staffrole1 = DB::table('vpastorroles')
                            ->select('RoleName')
                            ->where('Mainkey','=',$staffval->StaffMainkey)
                            ->where('EntityMainkey','=',$staffval->EntityMainkey)
                            ->orderBy('RoleName', 'ASC')
                            ->get();

                        $staffactivity = DB::table('vstaffactivity')
                            ->select('ActBeginDate','ActMin', 'ActSubMin1', 'IndividualMainkey','EntityMainkey')
                            ->where('IndividualMainkey','=',$staffval->StaffMainkey)
                            ->where('EntityMainkey','=',$staffval->EntityMainkey)
                            ->where('Status','!=', 'Unknown')
                            ->where('ActBeginDate', '<=', Carbon::now())
                            ->where('ActEndDate', '<=', Carbon::now())
                            ->orWhere('ActEndDate','>=', Carbon::now())
                            ->get();
                        @endphp
                        @foreach ($staffactivity as $staffact)
                        @if ($staffact->IndividualMainkey == $staffval->StaffMainkey )
                        @if ($staffact->ActMin != 'Unassigned')

                        <div>

                           @if($staffact->ActMin == 'District Personnel' || $staffact->ActMin == 'Minister for or Director for' || $staffact->ActMin == 'Other Ministry')

                            @if(empty($staffact->ActSubMin1))
                              {{ $staffact->ActMin }}
                            @else
                              {{ $staffact->ActSubMin1 }}
                            @endif

                           @else

                            @if(empty($staffact->ActMin))
                              {{ $staffact->ActSubMin1 }}
                            @else
                              {{ $staffact->ActMin }}
                            @endif
                           @endif
                          <span style="font-size: 0.8em;"> ({{ date("m/d/Y", strtotime($staffact->ActBeginDate))}})</span></div>
                        @endif
                        @endif
                        @endforeach
                        @foreach ($staffrole1 as $strole )
                        @if ( $strole->RoleName )
                        @if ($strole->RoleName != 'Unassigned')
                        {{ $strole->RoleName }}
                        <br>
                        @endif
                        @endif
                        @endforeach
                    @php
                        $exstaffrole1 = DB::table('staffrole')
                            ->select('StaffID','RoleTypeID')
                            ->where('StaffID','=',$staffval->StaffID)
                            ->orderBy('RoleTypeID', 'DESC')
                            ->get();

                        $newaddrole = $staffval->roles;
                        $empty = '';
                        $array = explode(',', $newaddrole);
                    @endphp
                    @if (!empty($staffval->staffroleid))
                      @if (empty($staffval->roles))
                        @foreach ($exstaffrole1 as $exstrole )
                          @if ($exstrole->StaffID  == $staffval->StaffID)
                              {{ ARHelper::getstaffrole($exstrole->RoleTypeID) }}<br>
                          @endif
                        @endforeach
                      @endif
                      @if ($newaddrole == 1)
                          {{$empty}}
                      @else
                        @foreach ($array as $starole)
                          {{ $starole }}
                          <br>
                        @endforeach
                    @endif
                    @endif
                    @if (empty($staffval->staffroleid))
                        @foreach ($array as $starole)
                        @if ($starole == 1)
                          {{$empty}}
                        @else
                        {{ $starole }}
                        @endif
                        <br>
                        @endforeach
                    @endif
                </td>

                <td>
                  @php
                    $button = DB::table('vstaffactivity')
                    ->where('EntityMainkey','=',$staffval->EntityMainkey)
                    ->where('IndividualMainkey','=',$staffval->StaffMainkey)
                    ->get();
                  @endphp
                   @if (count($button) == 0)
                  @if ($usertype != 'NationalOffice')

                        <a href="javascript:void(0)" class="staffroleedit dataexort" id="staffroleedit{{$staffval->id}}" data-id="{{$staffval->id}}" data-val="existinguser" data-original-title="view"><i class="fa fa-edit"></i></a>

                        <a href="javascript:void(0)" class="staffroledelete" id="staffroledelete{{$staffval->id}}" data-id="{{$staffval->id}}" data-val="staffroledelete" data-original-title="Delete"><i class="fa fa-trash"></i></a>
                  @endif
                     @endif

                </td>
            </tr>
            @endforeach
          @endif
{{-- Staff section end --}}

        </tbody>
              @foreach($questions as $val)

                @if($val->Questype == "Percent")
                  <tfoot>
                    <tr>
                      <td class="col-head">
                        <select name="percent" id="percent" dataId = "{{$val->Questioncode ?? ''}}" class="form-select percent" onclick="quesasst(this)">
                          @php
                            $QuesPercent = $val->QuesPercent;
                            $QuesPercentval = explode(", ",$QuesPercent);
                          @endphp
                          <option value="">Select</option>
                          @foreach($QuesPercentval as $key => $Perval)
                          <option value="{{$Perval}}">{{$Perval}}</option>
                          @endforeach
                        </select>
                      </td>
                      <td class="col-head"><span id="input-other-percent"></span><label class="percent-button" data-id='in' data-table="{{ $val->Questioncode }}" dataval="{{ $val->Questioncode }}" id="addPrecent" disabled="disabled">Add Field</label></td>
                      <td><span id="totalPercentage"></span>%</td>
                      <td>100%</td>
                      <td><i id="per" class="fas fa-check" data-toggle="tooltip"></i></td>
                    </tr>
                  </tfoot>
                @endif
                @if($val->Questype == "Multi Dropdown")
                  <tfoot>
                    <tr>
                      <td class="col-head">
                        <select name="multidropdown" id="multidropdown" class="form-select multidropdown" dataId="{{$val->Questioncode ?? ''}}" onclick="quesasst(this)">
                          @php
                            $Quesmultidropdown = $val->Quesmultidropdown;
                            $Quesmultidropdownval = explode(", ",$Quesmultidropdown);
                          @endphp
                          <option value="">Select</option>
                          @foreach($Quesmultidropdownval as $key => $Perval)
                          <option value="{{$Perval}}">{{$Perval}}</option>
                          @endforeach
                        </select>
                        <br>
                        <span id="input-other-multidropdown"></span>
                      </td>
                      <td class="col-head" style="width:110px">
                        <label class="multidropdown-button" data-id='in' data-table="{{ $val->Questioncode }}" dataval="{{ $val->Questioncode }}" id="addmultidropdown"><center>Add Field</center></label>
                      </td>
                    </tr>
                  </tfoot>
                @endif
              @endforeach
            </table>
            @else
              @foreach($questions as $val1)
                <label id="{!! $val->Questioncode ?? '' !!}" dataid="{{$val->id}}">{!! $val->QuestionText ?? '' !!}</label><br>
                @if($val1->Questype == "Textarea")
                  @if($annualreportdata != "")
                      @php
                      $Quesdata = ARHelper::churchReportData($annualreportdata->Mainkey,$annualreportdata->YearReported,$val1->Questioncode);
                      @endphp
                  @endif

                  <Textarea class="form-control tabchange" name="{{ $val1->Questioncode }}" id="{{ $val1->Questioncode }}" onclick="quesasst(this.id)" name="{{ $val1->Questioncode }}" data-id="{{$val1->id}}" data-val="{{$j}}" data-label="{{$val1->QuestionLabel}}" @if($val1->disableCheckbox == "Y") readonly @endif data-rule-required="true" {{ $usertype == 'NationalOffice' ? 'disabled' : ''}}>{!! $Quesdata ?? '' !!}</Textarea>
                  <br>
                @endif
              @endforeach
            @endif
            <br>
          @endforeach
        </section>
        <br>
        @if ($usertype != "NationalOffice")
        <center><button id="submit" type="submit">Save & Continue</button></center>
        @else
        <center><label class="submitstyle" onclick="submitnextNO(this)" >Next</label></center>

        @endif
        
        <br>
      </form>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <section class="sticky-sidebar-css">
          <div class="question">
            <div class="QA">
              <h6 style="padding: 7px 0 8px 0;"><center>Question Assistant</center></h6>
              <div id="Question-Asst">
                @if ( $segments[3] == 'ChurchStaff')
                <p>Tell us about your current staff and each of the following roles they serve in:</p>
                  <ul id="roles">
                    @foreach ($staffsroles as $roles)
                    <li>{{ $roles->role_name;}}</li>
                @endforeach
                  </ul>

                @else
                  <p id="Question-Asst-data">The question assistant displays tips and information regarding every question on the Annual Report.</p>
                @endif

              </div>
            </div>
            <div class="help">
              <h6 style="padding: 7px 0 8px 0;"><center>How This Helps</center></h6>
              <div id="Question-Help-Text">
                @if ( $segments[3] == 'ChurchStaff')
                  <p id="Question-Help-Text-data">This information allows us to provide your church staff with access to email communications, newsletters, blogs, and missions leader tools.</p>
                @else
                  <p id="Question-Help-Text-data">This section will explain why we ask this question and why it is important.</p>
                @endif

              </div>
            </div>
            <div class="have-questions">
              <label><strong>Have Questions?</strong></label><br>
              <label><i class="fas fa-envelope"></i>&nbsp;annualreport@cmalliance.org</label><br>
              <label><i class="fas fa-phone"></i>&nbsp;877-284-3262 option 4</label>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>

{{-- Staff model start --}}

        {{-- Model --}}
        <div class="container">
            <div class="modal" id="myModal" >
            <div class="modal-dialog modal-md modal-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background-color:#801214;color: #fff;">
                <h4>Manage Staffs</h4>
                <button type="button" id="CloseModal" class="close" data-dismiss="modal" >&times;</button>
                </div>
                <form id="manageusers" class="manageusers">
                 @csrf
                <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label for="name" class="form-label">User Name </label>
                        <input type="text" id="username" name="username" class="form-control username" id="main-section-name" value="">
                    </div>
                    <div class="col-12">
                      <label for="name" class="form-label">Title</label>
                      <input type="text" id="PositionTitleedit" name="PositionTitle" class="form-control" id="main-section-name" value="">
                    </div>
                    <div class="col-12">
                        <label for="name" class="form-label">District </label>
                        <select class="form-select" name="district" id="district">
                          @foreach($district as $dis)
                          <option value="{{$dis->Mainkey}}">{{ $dis->Name }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="name" class="form-label">Church </label>
                        <select class="form-select" name="churchdistrict" id="churchdistrict">
                         <option value=""></option>
                      </select>
                    </div>
                    <div class="col-12">
                        <label for="description" class="form-label">Email<span class="mandatory">*</span></label>
                        <input type="text" id="email" name="email" class="form-control" id="main-section-name" value="">
                    </div>

                    <div class="col-8">
                        <label for="name" class="form-label">Phone</label>
                        <input type="text" id="addPhone" name="Phone" class="form-control" id="main-section-name" value="">
                    </div>

                    <div class="col-4">
                        <label for="name" class="form-label">Phone Extension</label>
                        <input type="text" id="Phone_Extensions" name="Phone_Extension" class="form-control" id="main-section-name" value="">
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Website Role</label>
                        <select class="form-select" name="usertype" id="usertype">
                            <option value="Users">Editor</option>
                            <option value="Pastor">Pastor</option>
                            <option value="District">District Staff</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Staff Role<span class="mandatory">*</span></label>
                        <select id='staffroles' name="roles[]" class="form-select select exstaff" multiple="multiple">
                            @foreach ($staffsroles as $sroles)
                            <option value="{{ $sroles->role_name }}">{{ $sroles->role_name }}</option>
                            @endforeach
                        </select>
                    </div>

                  <div class="col-12">
                    <label for="description" class="form-label" >Generate OTP</label> <span class="btn otpgenerate" id="btn" style="margin-left: -12px;"><i class="fa-solid fa-rotate rotate"></i></span> <span class="copy-clipboard pointer" id="copyspan" onclick="copyToClipboard()" ><i class="bi bi-clipboard-check"></i> <span id="copy-label">Copy link</span></span>
                    
                    
                    <span class="uncopy-clipboard" id="uncopyspan" ><i class="bi bi-clipboard-check"></i> <span id="copy-label">Copy link</span></span>

                    <input type="text" id="otpdata" name="otp" class="form-control" id="main-section-name" value="" readonly >
                    <input type="hidden" id="urldata" value="">
                  </div>
                    <input type="hidden" value="" name="id" id="exid">
                    <input type="hidden" value="" name="otp" id="otpdatalink">
                    <input type="hidden" value=""  id="submiturldata">
                </div>
                <br>
                <div class="modal-footer">
                <button class="btn btn-add m-t-15 waves-effect mb-3 existinguser" id="staffroleupdate" style="background-color: #801214;color:#fff;" >Update</button>
                <button class="btn btn-add m-t-15 waves-effect mb-3 newuser" id="manageusersupdate" style="background-color: #801214;color:#fff;" >Update</button>
                <input class="btn btn-add m-t-15 waves-effect mb-3" type="button" id="modelclose"  value="Cancel" style="background-color: #801214;color:#fff;" >
                </div>
            </div>
        </form>
        </div>
        </div>
        </div>
    </div>

    <!-- Delete Modal start -->
    <div class="container">
    <div class="modal" id="deleteModal" >
    <div class="modal-dialog modal-md modal-centered">
    <div class="modal-content">
        <div class="modal-header" style="background-color:#801214;color: #fff;">
            <h4>Delete Staff</h4>
            <button type="button" id="delclose" class="close" data-dismiss="modal" >&times;</button>
        </div>
        <form id="deletestaff" class="deletestaff">
        @csrf
            <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <label for="description" class="form-label">Are you sure do you want to delete this record?</label>
                </div>
            <input type="hidden" value="" name="id" id="delid">
            </div>
            <br>
            <div class="modal-footer">
            {{-- Delete button --}}
            <button class="btn btn-add m-t-15 waves-effect mb-3 existinguserdelete" id="existinguserdelete" style="background-color: #801214;color:#fff;" >Delete</button>
            <button class="btn btn-add m-t-15 waves-effect mb-3 newuserdelete" id="newuserdelete" style="background-color: #801214;color:#fff;" >Delete</button>

            <button class="btn btn-add m-t-15 waves-effect mb-3" id="btndelclose" style="background-color: #801214;color:#fff;" >
            Cancel</button>
            </div>
            </div>
        </form>
    </div>
    </div>
    </div>
    </div>
{{-- Delete Staff end --}}
{{-- Add staff start --}}
<div class="container">
    <div class="modal" id="addStaffModal" >
    <div class="modal-dialog modal-md modal-centered">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header" style="background-color:#801214;color: #fff;">
        <h4>Add Staffs</h4>
        <button type="button" id="addCloseModal" class="close" data-dismiss="modal" >&times;</button>
        </div>
        <form id="addnewstaff" class="addnewstaff">
         @csrf
        <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <label for="name" class="form-label">Name<span class="mandatory">*</span></label>
                <input type="text" id="FullName" name="FullName" class="form-control" id="main-section-name" value="">
            </div>
            <div class="col-12">
              <label for="name" class="form-label">Title</label>
              <input type="text" id="PositionTitle" name="PositionTitle" class="form-control" id="main-section-name" value="">
            </div>
            <div class="col-12">
                <label for="description" class="form-label">Email<span class="mandatory">*</span></label>
                <input type="text" id="Email" name="Email" class="form-control" id="main-section-name" value="">
            </div>

            <div class="col-8">
                <label for="name" class="form-label">Phone</label>
                <input type="text" id="Phone" name="Phone" class="form-control" id="main-section-name" value="">
            </div>
            <div class="col-4">
                <label for="name" class="form-label">Phone Extension</label>
                <input type="text" id="Phone_Extension" name="Phone_Extension" class="form-control" id="main-section-name" value="">
            </div>


            <div class="col-12">
                <label for="description" class="form-label">Website Role</label>
                <select class="form-select" name="usertype" id="usertype" disabled>
                    <option value="Users">Editor</option>
                    <option value="Pastor">Pastor</option>
                    <option value="District">District Staff</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>

            <div class="col-12">
                <label for="description" class="form-label">Staff Role<span class="mandatory">*</span></label>
                <select id='staffroles' name="roles[]" class="form-select select addstaff" multiple="multiple">
                    @foreach ($staffsroles as $aroles)
                        <option value="{{$aroles->role_name }}">{{$aroles->role_name }}</option>
                    @endforeach
                </select>
              </div>

            <div class="col-12">
                <label for="name" class="form-label">District </label>
                <select class="form-select" name="district" disabled>
                <option value="{{$districtnames->DistrictMainkey ??''}}">{{ $districtnames->DistrictName ?? '' }}</option>
                </select>
            </div>

            <div class="col-12">
                <label for="name" class="form-label">Church </label>
                    <select class="form-select" name="churchdistrict" disabled>
                    <option value="{{$districtnames->ChurchMainkey ?? ''}}">{{ $districtnames->ChurchName ??'' }}</option>
                    </select>
            </div>

        <input type="hidden" id="EntityMainkey" name="EntityMainkey" value="{{ $getMainkey ?? ''}}">
         <input type="hidden"  name="churchdistrict" value="{{$districtnames->ChurchMainkey ?? ''}}">
        <input type="hidden"  name="district" value="{{$districtnames->DistrictMainkey ?? ''}}">
        </div>
        <br>
        <div class="modal-footer">
        <button class="btn btn-add m-t-15 waves-effect mb-3" id="addnewstaffs" style="background-color: #801214;color:#fff;" >Add</button>
        <input class="btn btn-add m-t-15 waves-effect mb-3" type="button" id="modelcloseadd"  value="Cancel" style="background-color: #801214;color:#fff;" >
        {{-- <button class="btn btn-add m-t-15 waves-effect mb-3" id="modelclose" style="background-color: #801214;color:#fff;" >
        Cancel</button> --}}
        </div>
    </div>
</form>
</div>
</div>
</div>
</div>

{{-- Add staff end --}}
{{-- Staff model end --}}
 <!-- Validate js Files -->
 <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
 <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>


<script>


    // jQuery.validator.addMethod("accept", function(value, element, param) {
    //      //return value.match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/);
    //   return value.match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,8})$/);
    // },'The email should be in the format: abc@gmail.com');

    // jQuery.validator.addMethod("extension", function(value, element, param) {
    //     return value.match(/^[+]?(\d{1,2})?[\s.-]?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/);
    // },'Please enter a valid Phone Number.');

$("#addnewstaff").validate({
      rules: {
          FullName : {
              required: true,
          },
          Email : {
            required:true,
            email:true,
            accept: true,
            required: true,
            maxlength:100,
            pattern : /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i,
          },
          'roles[]' : {
              required: true,
          },
          Phone: {
            // phoneUS: true,
            pattern: /^[+]?(\d{1,2})?[\s.-]?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/,
         },
         Phone_Extension:{
            maxlength:15,
         },
      },
      messages : {
          FullName : {
              required: "Please enter the Name.",

          },
          Email : {
            required: "Please enter a valid Email.",
            regex:"Please enter a valid Email.",
            pattern: "Please enter a valid Email.",
          },
          'roles[]' : {
              required: "Select staff Roles.",
          },
          Phone : {
            pattern: "Please enter a valid Phone Number.",
          },
          Phone_Extension:{
            maxlength:"Extension not be longer than 15 character.",
         },
      },
      submitHandler: function(form) {
        var data = $("#addnewstaff").serializeArray();
        var method = 'POST';
        var gettype = 'addnewstaff';
        var url = "{{ url('AnnualReport/Add-Staffs') }}";
        manageusers(data,method,url,gettype);
      }
    });

function copyToClipboard(element) {
  data = $("#urldata").val();
  otpdata = $("#otpdata").val();
  linkdata = $("#otpdatalink").val(otpdata);
  submitval = $("#submiturldata").val();
  if(submitval == 'newuser'){
    dataencrypt = encryptdata(data);
    link = window.location.origin+"/login/"+dataencrypt;
  }if(submitval == 'existinguser'){
    link = window.location.origin+"/login/"+data;
  }
  $("#otpdata").val(link).select();
  document.execCommand('copy');
  $("#copy-label").html("Copied!");

 }

 function encryptdata(data) {
     urldata = "";

        $.ajax({
            method : "get",
            url: "{{url('encryptdata')}}",
            data : {
                val : data
            },
            async: false,
            success: function(response) {
              urldata = response.urldata;
            }
        });
        return  urldata;
    }

   $(document).ready(function(){
     // generate otp start


    $(".rotate").click(function () {
        $(this).toggleClass("down");
        $('#uncopyspan').hide();  
        $('#copyspan').show(); 

    })

    $(".rotate").on('click',function(){
          var data = {
            'id' : $("#exid").val(),
            'findUser' : ""
          };
          var url = "{{ url('otpgenerate') }}";
          $.ajax({
             method : "get",
             url: url,
             data : data,
             aysnc:false,
             success: function(response) {
                 $("#urldata").val(response.urldata);
                 $("#otpdata").val(response.otp);
                 $("#otpdatalink").val(response.otp);
             }
         });
     });


    // Numeric calculation Funtion sections Start
    FormulaCalulate();

    $('table th:nth-child(3)').addClass('columnwidth');

    $("input.Calc").on('change',function(){
      FormulaCalulate();
    });

    function FormulaCalulate(){

        formuladata = [];
        jQuery("input.Formula").each(function() {
            fordata = $(this).attr('formuladata');
            if(fordata != ""){
              formuladata.push({
                [this.name] : fordata
              })

            }
        });

        $.each(formuladata, function (key ,value) {

          formula  = value;

          Formdata = {};

          jQuery("input.Calc").each(function() {
              Formdata={...Formdata, [this.name]:{val : this.value,code : this.name}}
          });

          var dataForm = Formdata;

          var success = multinumericformula(dataForm,formula);

        });
    }

    function multinumericformula(dataForm,formula){
      $.ajax({
          type: "get",
          url: "{{ url('multinumericformula') }}",
          data: {
            Formdatas : dataForm,
            formula : formula
          },
          async:false,
          success: function(response) {

            QuestionCode = response.QuestionCode;
            numericValue = response.numericValue;

            $("input#"+QuestionCode).val(numericValue);

            id = $("#id").val();
            
            if(id != ""){
              val =  $("input#"+QuestionCode).val();
              dataname = $("input#"+QuestionCode).attr('id');
              year = $("#YearReported").val();
              Mainkey = $("#Mainkey").val();
              reportAutoSave(id,val,dataname,year,Mainkey);
            }
            
          }
      });

    }

    // Numeric calculation Funtion sections end

    $("textarea").each(function () {
      this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
      }).on("input", function () {
      this.style.height = 0;
      this.style.height = (this.scrollHeight) + "px";
    });

    // Form Submit with validation dynamic validation

    $(document).on('submit', function(event) {

      event.preventDefault();

      var submitstatus = "";

      if(submitstatus != ""){
        $("#report-form").validate();

        // adding rules for inputs and select
        $('form#report-form input[type=text]').each(function() {

          name = $(this).attr('name');
          dataLabel = $(this).attr('data-label');

          $(this).rules("add",{
            required: true,
            messages: {
                required: "Please enter "+dataLabel,
              }
          });
        });

        $('form#report-form select').each(function() {
          if($("#percent").attr('name') == "percent"){
            f1 = $("#percent").attr('name');
          } else if($("#multidropdown").attr('name') == "multidropdown"){
            f1 = $("#multidropdown").attr('name');
          }else{
            f1 = "";
          }

          f2 = $(this).attr('name');

          if(f1 != f2){
            name = $(this).attr('name');
            dataLabel = $(this).attr('data-label');
            $(this).rules("add",
            {
              required: true,
              messages: {
                required: "Please  select "+dataLabel,
              }
            })
          }
        });

        // test if form is valid

        if($('#report-form').validate().form()) {
          formdata = $("#report-form").serializeArray();
          $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ url('StoreAnnualreport') }}",
            data: formdata,
            success: function(response) {

              data = response.route;
              console.log(data);
              $('#append-id').append('<input type="hidden" name="id" value="'+data.id+'">');
              window.location.href = "{{url('/')}}"+data;
              // swal("Success!", ""+response.msg+"", "success").then(okay => {
              //     if (okay) {

              //     }
              // });
            }
          });
        }
      }else{

        formdata = $("#report-form").serializeArray();
        $.ajax({
          type: "POST",
          dataType: "json",
          url: "{{ url('StoreAnnualreport') }}",
          data: formdata,
          beforeSend: function(){
            $("#overlay").fadeIn(300);
          },
          success: function(response) {
            $("#overlay").fadeOut(300);
            data = response.route;
            $('#append-id').append('<input type="hidden" name="id" value="'+data.id+'">');
            window.location.href = "{{url('/')}}"+data;
            // swal("Success!", ""+response.msg+"", "success").then(okay => {
            //     if (okay) {
            //         window.location.href = "{{url('/')}}"+data;
            //     }
            // });
          }
        });

      }
    });

    $(".percent").on('change',function(){

        if($(this).val() == "Other"){
          $("#input-other-percent").html("<input type='text' class='form-control' id='percentdata' name='percent' val=''><br>");
        }else{
          $("#input-other-percent").empty();
        }
    });

    $(".multidropdown").on('change',function(){

        if($(this).val() == "Other"){
          $("#input-other-multidropdown").html("<input type='text' class='form-control' id='multidropdowndata' name='multidropdown' val=''>");
        }else{
          $("#input-other-multidropdown").empty();
        }
    });

    $("#report-form select").on('change',function(){
        val = $(this).val();
        dataId= $(this).attr('data-id');
        dataval = $(this).attr('data-val');
        url = "{{url('getChildAnsQues')}}";

        dataname= $(this).attr('id');
        id = $("#id").val();
        year = $("#YearReported").val();
        Mainkey = $("#Mainkey").val();

        name = $(this).attr('name');

        if(name != "multidropdown" && name != "percent" && name != ""){
          $("#overlay").fadeIn(300);
        }

        // if(name != "percent"){
        //   $("#overlay").fadeIn(300);
        // }

        reportAutoSave(id,val,dataname,year,Mainkey);
        getchild(val,dataId,dataval,url);
    });


    $("#report-form input").on('change',function(){
        $type = $(this).attr('type');

        if($type == "checkbox"){
          if(this.checked){
            val = $(this).val();
          }else{
            val = 'N';
          }
          dataname= $(this).attr('name');
        }else{
          dataname= $(this).attr('id');
          val = $(this).val();
        }

        dataId= $(this).attr('data-id');
        dataval = $(this).attr('data-val');
        url = "{{url('getChildAnsQues')}}";


        id = $("#id").val();
        year = $("#YearReported").val();
        Mainkey = $("#Mainkey").val();

        name = $(this).attr('name');

        if(name != "multidropdown" && name != "percent"){
          $("#overlay").fadeIn(300);
        }

        reportAutoSave(id,val,dataname,year,Mainkey);
        getchild(val,dataId,dataval,url);
    });

    $(document).on('change','.select',function() {
        val = $(this).val();
        dataId= $(this).attr('data-id');
        dataval = $(this).attr('data-val');
        url = "{{url('getChildAnsQues')}}";

        dataname= $(this).attr('id');
        id = $("#id").val();
        year = $("#YearReported").val();
        Mainkey = $("#Mainkey").val();

        reportAutoSave(id,val,dataname,year,Mainkey);
    });

    $(document).on('change','.input',function() {
        val = $(this).val();
        dataId= $(this).attr('data-id');
        dataval = $(this).attr('data-val');
        url = "{{url('getChildAnsQues')}}";

        dataname= $(this).attr('id');
        id = $("#id").val();
        year = $("#YearReported").val();
        Mainkey = $("#Mainkey").val();

        reportAutoSave(id,val,dataname,year,Mainkey);
    });

    var myvalue = $('#checkbox-ques-label p').height();  //grabs the td.value element based on your html markup
    var offsetHeight = myvalue+10+'px'; //sets div_vhc height to that of td.value

    $('#empty-checkbox-label').attr('style','height:'+offsetHeight);

  });


  $(document).on('change','.appendcheck',function() {
      if(this.checked) {
        val = $(this).val();
      } else {
        val = 'N';
      }

      dataname= $(this).attr('data-id');
      id = $("#id").val();
      year = $("#YearReported").val();
      Mainkey = $("#Mainkey").val();
      reportAutoSave(id,val,dataname,year,Mainkey);
  });

  function reportAutoSave(id,val,dataname,year,Mainkey){
    data = {
      id : id,
      val : val,
      dataname : dataname,
      year : year,
      Mainkey : Mainkey
    };

    $.ajax({
        type : "get",
        url : "{{ url('reportAutoSave') }}",
        data : data,
        async: true,
        success: function(response) {
          data = response.data;
          $('#append-id').append('<input type="hidden" name="id" id="id" value="'+data['id']+'">');
        }
    });
  }

  function getchild(val,dataId,SpanId,url){

    if(val == "Y"){
      ParentQuesAns = "Yes";
    }else if (val == "N"){
      ParentQuesAns = "No";
    }else{
      ParentQuesAns = val;
    }

    $.ajax({
        type: "get",
        url: url,
        data:{
            id : dataId,
            val : ParentQuesAns
        },
        async: false,
        success: function(response) {
          if(response.get == 'single'){
              if(response.data != null){
                  var data = response.data;
                  childenable(data,SpanId);
              }else{

                  $("#ChildQuestext"+SpanId).empty();
                  $("#ChildQuesField"+SpanId).empty();
                  $("#ChildQuesPrevAns"+SpanId).empty();
              }

          }

          if(response.get == 'multi'){
            $.each(response.data,function(key, element ) {
                jQuery("label p").each(function() {
                    id = element.ParentQuestion;

                    dataid = $(this).closest('tr').find("label").attr('dataid');
                    if(id == dataid){
                      tdheight = 40;
                      height = $(this).closest('tr').find("label").height();
                      if(element.Questype == "Checkbox"){
                        var offsetHeight1 = height-tdheight;
                        var offsetHeight2 = height;
                      }else{
                        var offsetHeight1 = height-tdheight;
                        var offsetHeight2 = height;

                      }


                      if(offsetHeight1 == "0"){
                        $("#emptyField"+id).attr('style','display:none');
                        $("#emptylabel"+id).attr('style','display:none');
                      }else{
                        $("#emptyField"+id).removeAttr('style').attr('style','height:'+offsetHeight1+'px;padding:0px;margin:0px;');
                        $("#emptylabel"+id).removeAttr('style').attr('style','height:'+offsetHeight2+'px;padding:0px;margin:0px;');
                      }
                    }

                });

                var ParentQuestionAns = element.ParentQuestionAns;

                var ParentQuestion = getQuesParent(element.ParentQuestion,element.ParentQuestionAns,'{{$year}}','{{ARHelper::decryptUrl($segments[4])}}');

                if(ParentQuestion == "Y"){
                  ParentAns = "Yes";
                }else if (ParentQuestion == "N"){
                  ParentAns = "No";
                }else{
                  ParentAns = ParentQuestion;
                }

                if(ParentAns == ParentQuestionAns){
                  childenable(element,SpanId);
                }

            });
          }
        }
    }).done(function() {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      },500);
      restrictfields()
    });

  }


$('.tabchange').bind('keyup',function(event) {
    var dataval = $(this).attr('id');
    if(dataval == "percent" || dataval == "multidropdown"){
      quesasst(this);
    }else{
      quesasst(dataval);
    }
});


function quesasst(Id){

  if(Id.id != undefined){
    id = $(Id).attr('dataid');
  }else{
    id = Id;
  }


  $.ajax({
      type: "get",
      url: "{{ url('GetQuesass') }}",
      data:{
          code : id,
          questioncode : "Questioncode"
      },
      success: function(response) {
          $("#Question-Help-Text-data").empty().append(response.data.Queshelptext);
          $("#Question-Asst-data").empty().append(response.data.QuesAsstext);
      }
  });
}

function getQuesParent(ques,ans,year,mainkey){
  var dataval;
  $.ajax({
      type: "get",
      url: "{{ url('getQuesParent') }}",
      data:{
          ques : ques,
          ans : ans,
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

  function childenable(element,SpanId){
    var Questype = element.Questype;

    if(Questype == "Checkbox"){

        $("#ChildQuestext"+SpanId).empty().html('<label id="QuesChecklabel child-ques-label">'+element.QuestionText+'</label><span id="checkboxnameappend'+SpanId+'"></span>');
        var $checkboxQues = $("#checkboxnameappend"+SpanId);
        var $ChildQuesField = $("#ChildQuesField"+SpanId).empty().append('<div class="row ch-ad-pro" style="margin-left: 50px;margin-top: 25px;"><div class="col-10"><label id="ChildQuesFieldlabel"><p></p></label><span id="appendcheck"></span></div></div>');
        var $ChildQuesPrevAns = $("#ChildQuesPrevAns"+SpanId).empty().append('<label id="empty-checkbox-label" style="height:40px"><p></p></label><br><span id="appendcheckPrev"></span>');

        $checkboxQues.empty();
        $appendcheck = $('#appendcheck').empty();
        $appendcheckPrev = $('#appendcheckPrev').empty();

        const CheckboxArray = element.QuesCheckbox.split(", ");
        $.each( CheckboxArray, function( key, value ) {
          const CheckboxnameArray = value.split(":");

          var getchildans = getChildAns(CheckboxnameArray[1],'{{$year}}','{{ARHelper::decryptUrl($segments[4])}}');

          if(getchildans == "Y"){
            check = "checked";
          }else{
            check = "";
          }

          var getoldchildans = getChildAns(CheckboxnameArray[1],'{{$year}}'-1,'{{ARHelper::decryptUrl($segments[4])}}');

          if(getoldchildans == "Y"){
            checkPrev = "Y";
          }else{
            checkPrev = "N";
          }

          $checkboxQues.append('<div class="row ch-ad-pro" style="padding-left: 70px;"><div class="col-10"><label>'+CheckboxnameArray[0]+'</label></div></div>');
          Questioncode = "Questioncode";
          $appendcheck.append('<label class="QuesCheckfieldheight"><input type="checkbox" onchange="quesasst(this.id,'+Questioncode+')" name="'+CheckboxnameArray[1]+'" id="'+element.Questioncode+'" data-id="'+CheckboxnameArray[1]+'" class="form-check-input appendcheck" value="Y" data-label="'+element.QuestionLabel+'" '+check+'></label><br>');

          $appendcheckPrev.append('<span>'+checkPrev+'</span><br>');

          var heightinput =  parseInt($("#QuesChecklabel p").height())-23;
          var height =  parseInt($("#QuesChecklabel p").height())+23;

          if(height >= 40){
            $('#ChildQuesFieldlabel').attr('style','padding-top:'+heightinput+'px');
          }else{
            $('#ChildQuesFieldlabel').attr('style','display:none');
          }
        });

    }else{
      var getchildansnew = getChildAns(element.Questioncode,'{{$year}}','{{ARHelper::decryptUrl($segments[4])}}');
      var getoldchildans = getChildAns(element.Questioncode,'{{$year}}'-1,'{{ARHelper::decryptUrl($segments[4])}}');
    }

    if(getchildansnew == undefined){
      getchildanswer = "";
    }else{
      getchildanswer = getchildansnew;
    }

    if(getoldchildans == undefined){
      getoldchildanswer = "";
    }else{
      getoldchildanswer = getoldchildans;
    }

    if(Questype == "Text"){
        $("#ChildQuestext"+SpanId).empty().html('<label style="margin-top: 16px;">'+element.QuestionText+'</label>');
        $("#ChildQuesField"+SpanId).empty().append("<input class='form-control input "+element.Questioncode+"' onclick='quesasst(this.id)' type='text' name='"+element.Questioncode+"' id='"+element.Questioncode+"' data-label="+element.QuestionLabel+" value='"+getchildansnew+"'>");
        $("#ChildQuesPrevAns"+SpanId).empty().html("<label  style='margin-top: 16px;'><p>"+getoldchildanswer+"</p></label>");
    }

    if(Questype == "Numeric"){
      $("#ChildQuestext"+SpanId).empty().html('<label style="margin-top: 16px;">'+element.QuestionText+'</label>');
      $("#ChildQuesField"+SpanId).empty().append("<input class='form-control input "+element.Questioncode+"' onkeypress='return /[0-9]/i.test(event.key),isNumberKey()' onclick='quesasst(this.id)' type='text' name='"+element.Questioncode+"' id='"+element.Questioncode+"' data-label="+element.QuestionLabel+" value='"+getchildansnew+"'>");
      $("#ChildQuesPrevAns"+SpanId).empty().html("<label style='margin-top: 16px;'><p>"+getoldchildanswer+"</p></label>");
    }

    if(Questype == "Dropdown"){
        $("#ChildQuestext"+SpanId).empty().html('<label style="margin-top: 16px;">'+element.QuestionText+'</label>');
        $("#ChildQuesField"+SpanId).empty().append("<select class='form-select select' name='"+element.Questioncode+"' onclick='quesasst(this.id)' id='"+element.Questioncode+"' data-id='"+element.id+"' data-label="+element.QuestionLabel+"></select>");

        const myArray = element.QuesdropdownOption.split(", ");
        var options = $("#"+element.Questioncode+"");
        options.append($("<option />").val('').text(''));
        $.each( myArray, function( key, value ) {
          options.append($("<option />").val(value).text(value));
        });

        $("#"+element.Questioncode+" option[value='"+getchildanswer+"']").attr('selected','selected');

        $("#ChildQuesPrevAns"+SpanId).empty().html("<label style='margin-top: 16px;'><p>"+getoldchildanswer+"</p></label>");
    }

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

  function updateRanger(dataId,i){
    $("#perValue"+i).text(dataId);
    overAllCal()
  }

var tempNo = 0;
$("#addPrecent").on('click', function() {
  tableId = $(this).attr('dataval');
  tablename = $(this).attr('data-table');
  $(this).parents('table').addClass(''+tableId+'');
  var dataname = $("#percent").val();

  if(dataname == "Other"){
    name = $("#percentdata").val();
  }else{
    name = $("#percent").val();
  }

  get = $("tr.percent td.percent-name").find('td.percent-name*:not("'+name+'")');
  prevObject = get.prevObject


  if(name != ""){
    if ($("."+tableId+" > tbody > tr").is("*")){
      tempNo = tempNo + 1;
      $totalPercentage = 100 - $("#totalPercentage").text();
      var newRow = '<tr class="percent"><td class="percent-name">'+name+'</td>'+'<td><input type="range" name="Ethnicityrange[]" class="form-range" data-id="'+tempNo+'" data-val="'+name+'" data-table="'+tablename+'" data-val-id="" value="'+$totalPercentage+'" min="0" max="100" id="myrange'+tempNo+'" oninput="updateRanger(this.value,'+tempNo+');sliderpercentage(this,value)"></td>'+'<td> <span id="perValue'+tempNo+'" class="perValueSp">'+$totalPercentage+'</span>%</td>'+'<td></td>'+'<td><i id ="Percentdel" class="fas fa-trash" data-id="" data-table="'+tablename+'"></i></td></tr>';
      $("."+tableId+" > tbody > tr:last").after(newRow);
      overAllCal();
      var dataId =  $(this).attr('data-id');
      var empty = $("#percent").val('');
      $("#percent option[value="+empty+"]").prop("selected", true);
      sliderpercentage(dataId);
    }else {
      $("."+tableId+" > tbody").append(newRow)
      var dataId =  $(this).attr('data-id');
      $("#percent option[value="+empty+"]").prop("selected", true);
      sliderpercentage(dataId);
    }
  }
  else{
    alert("Please select "+tablename);
  }

});

$(document).on('click', '#Percentdel', function() {
    if (confirm('Are you sure you want delete ?')) {
      id = $(this).attr('data-id');
      table = $(this).attr('data-table');
      successData = deletePercent(id,table);
      if(successData == "true"){
        swal("Success!", "Record Deleted Successfully", "success");
        $(this).parents('tr').remove();
      }else{
        swal("Warning!", "Record Doesn't Deleted!", "Warning");
      }
      overAllCal()
    }
});

function deletePercent(id,table){
    var data = "";
    $.ajax({
        type:"get",
        url: "{{url('percentDelete')}}",
        data:{
          id : id,
          table : table,
        },
        async:false,
        success:function(response){
          data = response;
        }
    });
    return data;
}

$("#addmultidropdown").on('click', function() {
  tableId = $(this).attr('dataval');
  tablename = $(this).attr('data-table');
  $(this).parents('table').addClass(''+tableId+'');
  var dataname = $("#multidropdown").val();


  if(dataname == "Other"){
    name = $("#multidropdowndata").val();
  }else{
    name = $("#multidropdown").val();
  }

  if(name != ""){

      var data = {
        FieldName : name,
        Mainkey : $("#Mainkey").val(),
        Tablename : tablename
      };

    var dataId = mulidropdownupdate(data);

    if ($("."+tableId+" > tbody > tr").is("*")){
      tempNo = tempNo + 1;
      var newRow = '<tr><td>'+name+'</td><td><i id ="multidropdowndel" data-table="'+tablename+'" data-id="'+dataId+'" class="fas fa-trash"></i></td></tr>';
      $("."+tableId+" > tbody > tr:last").after(newRow);
      $("#multidropdown option[value='']").prop("selected", true);
    }else {
      var newRow = '<tr><td>'+name+'</td><td><i id ="multidropdowndel" data-table="'+tablename+'" data-id="'+dataId+'" class="fas fa-trash"></i></td></tr>';
      $("."+tableId+" > tbody").append(newRow)
      var dataId =  $(this).attr('data-id');
      $("#multidropdown option[value='']").prop("selected", true);
    }
    $("#input-other-multidropdown").empty();
  }
  else{
    alert("Please select "+tablename);
  }
});

$(document).on('click', '#multidropdowndel', function() {
  if (confirm('Are you sure you want delete ?')) {
    var id = $(this).attr('data-id');
    var table = $(this).attr('data-table');
    var removeVal = deleteMultidropdown(id,table);
    if(removeVal == "true"){
      $(this).parents('tr').remove();
    }
  }
});


$('.form-range').each(function(){
  var dataId =  $(this).attr('data-id');
  sliderpercentage(dataId);
});

function mulidropdownupdate(data){
    var getdata = "";
    $.ajax({
        type:"get",
        url: "{{url('multidropdownupdate')}}",
        data:data,
        async:false,
        success:function(response){
          getdata = response;
        }
    });
    return getdata;
}

function deleteMultidropdown(id,table){
    var data = "";
    $.ajax({
        type:"get",
        url: "{{url('multidropdowndelete')}}",
        data:{
          'id' : id,
          'Tablename' : table
        },
        async:false,
        success:function(response){
          data = response;
        }
    });
    return data;
}


function sliderpercentage(dataId){
  var sli = "myRange"+dataId;
  var out = "perValue"+dataId;

  var slider = document.getElementById(sli);
  var output = document.getElementById(out);

  output.innerHTML = slider.value;
  slider.oninput = function() {
  output.innerHTML = this.value;
  overAllCal()
  }
}

overAllCal()
function overAllCal(){
  var mt = 0;
  $('.perValueSp').each(function(i,e){
      var obj = $(e).text();
      mt = parseInt(mt)+parseInt(obj);
      $("#totalPercentage").html(mt);
  })

  if($("tbody > tr").length > 0){
      if(mt == 100){
        $("#per").removeClass('fas fa-exclamation-triangle perstyle');
        $("#per").addClass('fas fa-check perstyle-in');
        $("#per").removeAttr('title');

        $("#percent").attr('disabled', 'disabled');
        $("#addPrecent").attr('style','background-color:#767676').attr('data-toggle', 'tooltip').attr('title', 'Please reduce any one of the percentage values');

        $("tr:gt(0) > td:not(:first-child) > input[type='range']").each(function() {
            rangeVal = $(this).val();
            rangeName = $(this).attr('data-val');
            id = $(this).attr('data-val-id');
            appendid = $(this).attr('id');
            tablename = $(this).attr('data-table');

            datas = {
              'id' : id,
              'Mainkey' : $("#Mainkey").val(),
              'Year' : $("#YearReported").val(),
              'Percent' : rangeVal,
              'Name' : rangeName,
              'tablename' : tablename
            };
            percentupdate(datas,appendid);
	      });

      } else {

        $("#percent").attr('disabled', false);
        $("#addPrecent").removeAttr('style').removeAttr('data-toggle');
        $("#per").removeClass('fas fa-check perstyle-in');
        $("#per").addClass('fas fa-exclamation-triangle perstyle');
        $("#per").attr('title','Percentages must total 100%');

      }
  }
}

function percentupdate(datas,appendid){
    $.ajax({
        type:"get",
        url: "{{url('percentUpdate')}}",
        data:datas,
        async:false,
        success:function(response){
          id = response.id;
          $("#"+appendid).attr('data-val-id',id);
        }
    });
}

function isNumberKey(){
  if(event.keyCode > 31 && (event.keyCode < 48 || event.keyCode > 57)){
    alert('Please enter only numbers');
    return false;
  }
}

</script>

{{-- Start Staff section --}}
<script>

    $('.select[multiple]').select2({
        width: '100%',
        closeOnSelect: false
    });

    // Staff Add start

    $(".addstaffs").click(function(e) {
        e.preventDefault();
        $('#addStaffModal').appendTo("body").modal('toggle');
        $(".addstaff").select2();
    });

        $("#addCloseModal").click(function() {
            $('#addStaffModal').modal('hide');
        });
         $("#modelcloseadd").click(function() {
            $('#addStaffModal').modal('hide');
        });
    // Staff Add end
    // Staff delete start
    $(".staffroledelete").click(function(e) {
        e.preventDefault();
        var dataval = $(this).attr('data-val');
        if(dataval == "staffroledelete"){
            $('.newuserdelete').hide();
        }
        var data = {'id' : $(this).attr('data-id')};
        var val = $(this).attr('data-id');
        $("#delid").val(val);
        $('#deleteModal').appendTo("body").modal('toggle');
    });

    $(".existinguserdelete").click(function(e) {
        e.preventDefault();
        var data = {'id':$("#delid").val()};
        var method = 'GET';
        var url = "{{ url('AnnualReport/delete-staffs') }}";
        var gettype = "deleteexistinguser";
        data = manageusers(data,method,url,gettype);
    });

    $(".newstaffroledelete").click(function(e) {
        e.preventDefault();
        var dataval = $(this).attr('data-val');
        if(dataval == "newstaffroledelete"){
            $('.existinguserdelete').hide();
        }
        var data = {'id' : $(this).attr('data-id')};
        var val = $(this).attr('data-id');
        $("#delid").val(val);
        $('#deleteModal').appendTo("body").modal('toggle');
    });

    $(".newuserdelete").click(function(e) {
        e.preventDefault();
        var data = {'id':$("#delid").val()};
        var method = 'GET';
        var url = "{{ url('AnnualReport/delete-newstaffs') }}";
        var gettype = "deletenewuser";
        data = manageusers(data,method,url,gettype);
    });

        $("#delclose").click(function() {
            $('#deleteModal').modal('hide');
        });
        $("#btndelclose").click(function() {
            $('#deleteModal').modal('hide');
        });
     // Staff delete end

    $(".staffroleedit").click(function(e) {
        e.preventDefault();
      var data = {'id' : $(this).attr('data-id')};
      var dataval = $(this).attr('data-val');
      var clickboard =  $('#otpdata').val();
      if(dataval == "existinguser"){
        $('#submiturldata').val('existinguser');
        $('.newuser').hide();
        $(".username").prop("disabled", true);
      }
      if(clickboard == ""){
        $('#uncopyspan').show();  
        $('#copyspan').hide(); 
      }else{
        $('#copyspan').show(); 
        $('#uncopyspan').hide(); 
      }
      var method = 'GET';
      var url = "{{ url('AnnualReport/Get-staffs') }}";
      var gettype = "existinguser";
      data = manageusers(data,method,url,gettype);
      $('#myModal').appendTo("body").modal('toggle');
      $(".exstaff").select2();
    });

    //  $("#staffroleupdate").click(function(e) {
    //     e.preventDefault();
    //     var method = 'POST';
    //     var formid = 'manageusers';
    //     var data = $("#manageusers").serializeArray();
    //     var url = "{{ url('AnnualReport/Update-Staffs') }}";
    //     manageusers(data,method,url);
    //  });

    $(".mainsectionedit").click(function(e) {
      e.preventDefault();
      var dataval = $(this).attr('data-val');
      if(dataval == "newuser"){
        $('#submiturldata').val('newuser');
        $('.existinguser').hide();
        $(".username").prop("disabled", true);
      }
      var data = {'id' : $(this).attr('data-id')};
      var method = 'GET';
      var url = "{{ url('AnnualReport/Get-Users') }}";
      manageusers(data,method,url);
      $('#myModal').appendTo("body").modal('toggle');
      $(".exstaff").select2();
    });

//   $("#manageusersupdate").click(function(e) {
//         e.preventDefault();
//         var method = 'POST';
//         var data = $("#manageusers").serializeArray();
//         var url = "{{ url('AnnualReport/Update-Users') }}";
//         manageusers(data,method,url);
//   });

    $("#CloseModal").click(function() {
      $('#myModal').modal('hide');
     });

    $("#modelclose").click(function() {
      $('#myModal').modal('hide');
     });

     $(".modal").on("hidden.bs.modal", function() {
      $('#staffroles option[selected="selected"]').removeAttr('selected');
      $('#usertype option[selected="selected"]').removeAttr('selected');
      $("#copy-label").html('Copy link');
      $("#overlay").fadeOut(300);
    });

    $("#manageusers").validate({
      rules: {
        email : {
            required:true,
            email:true,
            accept: true,
            required: true,
            maxlength:100,
          },
          'roles[]' : {
              required: true,
          },
          Phone: {
            // phoneUS: true,
            pattern: /^[+]?(\d{1,2})?[\s.-]?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/,
         },
         Phone_Extension:{
            maxlength:15,
         },
      },
      messages : {
        email : {
            required: "Please enter a valid Email.",

          },
          'roles[]' : {
              required: "Select staff Roles.",
          },
          Phone : {
            phoneUS: "Please enter a valid Phone Number.",
          },
          Phone_Extension:{
            maxlength:"Extension not be longer than 15 character.",
         },
      },
      submitHandler: function(form) {
        var method = 'POST';
        var formid = 'manageusers';
        var data = $("#manageusers").serializeArray();
        var submitval = $("#submiturldata").val();
        if(submitval == "newuser"){
          var url = "{{ url('AnnualReport/Update-Users') }}";
        }
        if(submitval == "existinguser"){
          var url = "{{ url('AnnualReport/Update-Staffs') }}";
        }

        var url = url;
        manageusers(data,method,url);
      }
    });

    function manageusers(data,method,url,gettype){
    $.ajax({
    method : method,
    url: url,
    data : data,
      success: function(response) {
        if(method == 'GET'){

                if(response.status == 'Deleted'){
                    $("#deleteModal").modal("hide");
                    swal("Success!", ""+response.success+"", "success").then(function(){
                    window.location.reload();
                     });
                }

                if(response.status == 'newDeleted'){
                    $("#deleteModal").modal("hide");
                    swal("Success!", ""+response.success+"", "success").then(function(){
                    window.location.reload();
                     });
                }

                if(gettype == 'existinguser'){
                  data = response.data;
                  district = response.district;
                  getdismainkey(district["DistrictMainkey"],district['ChurchMainkey']);
                  $('#exid').empty().val(data['id']);

                  var stafftitle = data['Title'] ? data['Title']+' ' :  '';
                  var midname = data['MiddleName'] ? ' '+data['MiddleName'] : '';
                  var suffix = data['Suffix'] ? ' '+data['Suffix'] : '';
                  var fullname = data['LastName']+', '+stafftitle+''+data['FirstName']+''+midname+''+suffix;
                  var staffname = data['FullName'];
                  if(staffname == null || staffname == ''){
                    $('#username').empty().val(fullname);
                  }else{
                    $('#username').empty().val(staffname);
                  }
                  $('#PositionTitleedit').empty().val(data['PositionTitle']);
                  $('#addPhone').empty().val(data['Phone']);
                  $('#Phone_Extensions').empty().val(data['Phone_Extension']);
                  $('#email').empty().val(data['Email']);
                  $('#district option[value="'+district["DistrictMainkey"]+'"]').attr('selected','selected');
                  $('#usertype option[value="'+data["usertype"]+'"]').attr('selected','selected');
                  if(data.roles){
                  const myArray = data.roles.split(", ");
                  $.each(myArray, function( key, value ) {
                       $('#staffroles option[value="'+value+'"]').attr('selected','selected');
                    });
                  }else{
                    $.each(response.sroles, function( key, value ) {
                       $('#staffroles option[value="'+value+'"]').attr('selected','selected');
                    });
                  }
                  $(".exstaff").select2();
                }else{
                data = response.data;
                getdismainkey(data["district"],data['churchdistrict']);

                $('#exid').empty().val(data['id']);
                $('#otpdata').empty().val(data['otp']);
                $('#urldata').empty().val(data['otp']);

                $('#username').empty().val(data['username']);
                $('#district option[value="'+data["district"]+'"]').attr('selected','selected');
                $('#email').empty().val(data['email']);
                $('#usertype option[value="'+data["usertype"]+'"]').attr('selected','selected');
                $('#user_status option[value="'+data["status"]+'"]').attr('selected','selected');
                const myArray = response.data.roles.split(", ");
                $.each( myArray, function( key, value ) {
                    $('#staffroles option[value="'+value+'"]').attr('selected','selected');
                    });
                    $(".exstaff").select2();

                if( response.data['status'] == "Inactive")
                {
                    $('.comment-section').removeAttr('style');
                    $('#comment').empty().val(response.data['comments']);
                }
              }
            }
            if(response.action == 'add'){
                $("#addStaffModal").modal("hide");
                swal("Success!", ""+response.success+"", "success").then(function(){
                window.location.reload();
            });
            }
            if(response.status == '1'){
              $("#myModal").modal("hide");
              swal("Success!", ""+response.success+"", "success").then(function(){
                window.location.reload();
            });
            }
            // $('.rotate').trigger('click');
      }
   });
}

function getdismainkey(value,churchdistrict){

$.ajax({
    type:"get",
    url:"{{ url('AnnualReport/getdistrict') }}",
    data:{
        'district' : value
    },
    success:function(response){
         var options = $("#churchdistrict");
        $.each(response, function () {
            var text = ''+this.ChurchName+', '+this.MailingCity;
            options.append($("<option />").val(this.ChurchMainkey).text(text));
        });
        $('#churchdistrict option[value="'+churchdistrict+'"]').attr('selected','selected');

    }
});
}
$("#district").change(function(){
        var district = $(this).val();
    $.ajax({
    type:"get",
    url:"{{ url('AnnualReport/getdistrict') }}",
    data:{
        'district' : district
    },
    success:function(response){
         var options = $("#churchdistrict");
         options.empty().append("<option>Select Church</option>");
        $.each(response, function () {
            var text = ''+this.ChurchName+', '+this.MailingCity;
            options.append($("<option />").val(this.ChurchMainkey).text(text));
        });
    }
});
});

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

      var foundin = $('td>label:contains("('+val+')")');
      
      $.each(foundin, function(index,value) {
          id = $(this).attr('id');
          data = $('label#'+id+':contains("('+val+')")').text($('label#'+id+':contains("('+val+')")').text().replace("("+val+")",Yeardata));
      });
  });

}
function  restrictfields(){
  var usertype = "{{  $usertype }}";
 
 if(usertype == "NationalOffice"){
  $("input").attr('disabled', 'disabled');
  $("select").attr('disabled', 'disabled');
 }
}

function submitnextNO(data){
  var url = $(location).attr('href');
  var parts = url.split("/");
  var last_part = parts[parts.length-3];
  var year = parts[parts.length-1];
  var mainkey = "{{ $MainkeyNO }}";
  
  $.ajax({
        type:"get",
        url: "{{url('MoveNextsection')}}",
        data: {
          'subsection' : last_part,
          'year' : year,
          'Mainkey':mainkey

        },
        async:false,
        success:function(response){
          data = response.route;
        window.location.href = "{{url('/')}}"+data;
        }
    });
}
</script>
{{-- Start Staff section --}}
@endsection
