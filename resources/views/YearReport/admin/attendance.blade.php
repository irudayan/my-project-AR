@extends('YearReport.layouts.index')

@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;
$year = request()->segment(count(request()->segments()));           
@endphp

@section('contents')

<div class="tab-section">
  <br>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <section class="sub-section">
          <h5 class="sub-section-head">Average Weekly Attendance</h5>
          <table class="table">
            <thead>
              <tr>
                <th class="col-head">Question</th>
                <th class="col-head">This Year</th>
                <th class="col-head stat">Last Year</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  Main Worship Service(s) Combined<br>
                  * Do not include numbers for average digital attendance.
                </td>
                <td>
                  <input type="text" class="form-control" name="MorningAttendance" value="{{ $annualreportdata->MorningAttendance }}">
                </td>
                <td>{{ $lastyear->MorningAttendance }}</td>
              </tr>

              <tr>
                <td>Primary Worship Service Language/Dialect <br> <br>Language - Other</td>
                <td>
                  <select class="form-select" name="Language" id="Language">
                    @foreach($language as $languagevalue)
                    <option value="{{ $languagevalue->Language }}" {{ $languagevalue->Language == $annualreportdata->Language ? 'selected' : ''}}>{{ $languagevalue->Language }}</option>
                    @endforeach

                  </select>
                  <br>
                  <input type="text" class="form-control" name="LanguageOther" value="{{ $annualreportdata->LanguageOther }}">
                </td>
                <td><span class="last_language">{{ $lastyear->Language }}</span>
                <br><br>
                <span class="last_other_language">{{ $lastyear->LanguageOther }}</span></td>
              </tr>

              <tr>
              @php
                $weekend_dig = $annualreportdata->DigitalService;
              @endphp

                <td>Weekend Digital Service(s)	
                  <br><br>
                  Digital Attendance</td>
                <td>
                  <select class="form-select" name="DigitalService" id="DigitalService">
                    <option value=""></option>
                    <option value="Y" {{ $weekend_dig == 'Y' ? 'selected' : '' }}>Yes</option>
                    <option value="N" {{ $weekend_dig == 'N' ? 'selected' : '' }}>No</option>
                  </select>
                  <br>
                  <input type="text" class="form-control" name="DigitalAttendance" value="{{ $annualreportdata->DigitalAttendance }}">
                </td>
                <td><span class="last_language">{{ $lastyear->DigitalService }}</span>
                <br><br>
                <span class="last_other_language">{{ $lastyear->DigitalAttendance }}</span></td>
              </tr>

              <tr>
                <td>Adult Small Group Ministries</td>
                <td><input type="text" class="form-control" name="SmallGroupAttendance" value="{{ $annualreportdata->SmallGroupAttendance }}"></td>
                <td>{{ $lastyear->SmallGroupAttendance }}</td>
              </tr>
              <tr>
                <td>Youth Group Ministries (12-18)</td>
                <td><input type="text" class="form-control" name="YouthGroupAttendance" value="{{ $annualreportdata->YouthGroupAttendance }}"></td>
                <td>{{ $lastyear->YouthGroupAttendance }}</td>
              </tr>
              <tr>
                <td>Children Ministries (through age 11)</td>
                <td><input type="text" class="form-control" name="ChildrenAttendance" value="{{ $annualreportdata->ChildrenAttendance }}"></td>
                <td>{{ $lastyear->ChildrenAttendance }}</td>
              </tr>
            </tbody>
          </table>
        </section>
        <center><button>Continue</button></center>
        <br>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <section>
          <div class="question">
            <div class="QA">
              <h6><center>Question Assistant</center></h6>
              <p>The question assistant displays tips and information regarding every question on the Annual Report.</p>
            </div>
            <div class="help">
              <h6><center>How This Helps</center></h6>
              <p>The question assistant displays tips and information regarding every question on the Annual Report.</p>
            </div>
            <div class="have-questions">
              <label><strong>Have Questions?</strong></label><br>
              <label><i class="fas fa-envelope"></i>&nbsp;dmomail@cmalliance.org</label><br>
              <label><i class="fas fa-phone"></i>&nbsp;1-877-284-3262 opt 4</label>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>
@endsection
