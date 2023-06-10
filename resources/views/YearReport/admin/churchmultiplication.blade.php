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
          <h5 class="sub-section-head">Church Multiplication</h5>
          <table class="table table-responsive">
              <thead>
              <tr>
                  <th class="col-head">Question</th>
                  <th class="col-head">This Year</th>
                  <th class="col-head stat">Last Year</th>
              </tr>
              </thead>
              <tbody>
                <tr>
                    <td>In the last 12 months, how many new people have entered a leadership development process within your church?</td>
                    <td><input type="text" class="form-control" name="LeadersDeveloped" value="{{ $annualreportdata->LeadersDeveloped }}"></td>
                    <td>{{ $lastyear->LeadersDeveloped }}</td>
                </tr>
                <tr>
                    <td>In the last 12 months, how many new leaders has your church deployed beyond your current ministry context?</td>
                    <td><input type="text" class="form-control" name="LeadersDeployed" value="{{ $annualreportdata->LeadersDeployed }}"></td>
                    <td>{{ $lastyear->LeadersDeployed }}</td>
                </tr>
                <tr>
                  @php
                    $plant_intent = $annualreportdata->PlantIntent;
                  @endphp
                    <td>Are you taking intentional steps toward planting a church or a multisite in the next three years? </td>
                    <td>
                      <select class="form-select" name="PlantIntent" id="PlantIntent">
                        <option value=""></option>
                        <option value="Y" {{ $plant_intent == 'Y' ? 'selected' : '' }}>Yes</option>
                        <option value="N" {{ $plant_intent == 'N' ? 'selected' : '' }}>No</option>
                      </select>
                    </td>
                    <td>{{ $lastyear->PlantIntent }}</td>
                </tr>
                <tr>
                  @php
                    $church_plant = $annualreportdata->ChurchPlant;
                  @endphp
                  <td>Church(es) planted in the last three years</td>
                  <td>
                    <select class="form-select" name="ChurchPlant" id="ChurchPlant">
                      <option value=""></option>
                      <option value="Y" {{ $church_plant == 'Y' ? 'selected' : '' }}>Yes</option>
                      <option value="N" {{ $church_plant == 'N' ? 'selected' : '' }}>No</option>
                    </select>
                  </td>
                  <td>{{ $lastyear->ChurchPlant }}</td>
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