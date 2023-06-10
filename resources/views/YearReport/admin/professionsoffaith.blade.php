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
          <h5 class="sub-section-head">Professions of Faith</h5>
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
                <td>Children (through age 11)</td>
                <td><input type="text" class="form-control" name="" value="{{ $annualreportdata->Conversions0to11 }}"></td>
                <td>{{ $lastyear->Conversions0to11 }}</td>
              </tr>
              <tr>
                <td>Youth 12-18</td>
                <td><input type="text" class="form-control" name="" value="{{ $annualreportdata->Conversions12to18 }}"></td>
                <td>{{ $lastyear->Conversions12to18     }}</td>
              </tr>
              <tr>
                <td>Young Adult 19-30</td>
                <td><input type="text" class="form-control" name="" value="{{ $annualreportdata->Conversions19to30 }}"></td>
                <td>{{ $lastyear->Conversions19to30 }}</td>
              </tr>
              <tr>
                <td>Adults 31+</td>
                <td><input type="text" class="form-control" name="" value="{{ $annualreportdata->ConversionsOver30 }}"></td>
                <td>{{ $lastyear->ConversionsOver30 }}</td>
              </tr>
              <tr>
                @php
                $totalProfession = $annualreportdata->Conversions0to11 + $annualreportdata->Conversions12to18 + $annualreportdata->Conversions19to30 + $annualreportdata->ConversionsOver30;

                $lastYearTotalProfession = $lastyear->Conversions0to11 + $lastyear->Conversions12to18 + $lastyear->Conversions19to30 + $lastyear->ConversionsOver30;
                @endphp
                <td class="col-head"><h6>Total Professions of Faith</h6></td>
                <td><input type="text" class="form-control" name="ConversionsTotal" value="{{ $totalProfession }}"></td>
                <td>{{ $lastYearTotalProfession }}</td>
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