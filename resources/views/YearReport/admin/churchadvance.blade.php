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
        <form>
          <section class="sub-section">
          <h5 class="sub-section-head">Church Advance</h5>
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
                  <td>Organized Group Prayer</td>
                  <td><input type="text" class="form-control" name="GroupPrayer" value="{{ $annualreportdata->GroupPrayer }}"></td>
                  <td>{{ $lastyear->GroupPrayer }}</td>
              </tr>
              <tr>
                @php
                  $discipleship_plan = $annualreportdata->DiscipleshipPlan;
                @endphp
                  <td>
                    <label>Discipleship Roadmap</label><br>
                    <label> Participants</label>
                  </td>
                  <td>
                    <select class="form-select" name="DiscipleshipPlan" id="DiscipleshipPlan">
                      <option value=""></option>
                      <option value="Y" {{ $discipleship_plan == 'Y' ? 'selected' : '' }}>Yes</option>
                      <option value="N" {{ $discipleship_plan == 'N' ? 'selected' : '' }}>No</option>
                    </select>
                    <br>
                    <input type="text" class="form-control">
                  </td>
                  <td>
                    <span>{{ $lastyear->DiscipleshipPlan }}</span>
                    <br><br>
                    <span>{{ $lastyear->DiscipleshipPlan }}</span>
                  </td>
              </tr>
              <tr>
                @php
                  $leadership_plan = $annualreportdata->LeadershipPlan;
                @endphp
                <td>
                  <label>Leadership Development Roadmap</label><br>
                  <label> Participants</label>
                </td>
                <td>
                  <select class="form-select" name="LeadershipPlan" id="LeadershipPlan">
                    <option value=""></option>
                    <option value="Y" {{ $leadership_plan == 'Y' ? 'selected' : '' }}>Yes</option>
                    <option value="N" {{ $leadership_plan == 'N' ? 'selected' : '' }}>No</option>
                  </select>
                  <br>
                  <input type="text" class="form-control">
                </td>
                <td>
                    <span>{{ $lastyear->LeadershipPlan }}</span>
                    <br><br>
                    <span>{{ $lastyear->LeadershipPlan }}</span>
                  </td>
              </tr>
              <tr>
                @php
                  $evangelism_plan = $annualreportdata->EvangelismPlan;
                @endphp
                <td>
                  <label>Evangelism Roadmap</label><br>
                  <label>Participants</label>
                </td>
                <td>
                  <select class="form-select" name="EvangelismPlan" id="EvangelismPlan">
                    <option value=""></option>
                    <option value="Y" {{ $evangelism_plan == 'Y' ? 'selected' : '' }}>Yes</option>
                    <option value="N" {{ $evangelism_plan == 'N' ? 'selected' : '' }}>No</option>
                  </select>
                  <br>
                  <input type="text" class="form-control">
                </td>
                <td>
                    <span>{{ $lastyear->EvangelismPlan }}</span>
                    <br><br>
                    <span>{{ $lastyear->EvangelismPlan }}</span>
                  </td>
              </tr>
              <tr>
                @php
                  $outreach_plan = $annualreportdata->OutreachPlan;
                @endphp
                <td>
                  <label>Community Transformation Roadmap</label><br>
                  <label>Participants</label>
                </td>
                <td>
                  <select class="form-select" name="OutreachPlan" id="OutreachPlan">
                    <option value=""></option>
                    <option value="Y" {{ $outreach_plan == 'Y' ? 'selected' : '' }}>Yes</option>
                    <option value="N" {{ $outreach_plan == 'N' ? 'selected' : '' }}>No</option>
                  </select>
                  <br>
                  <input type="text" class="form-control">
                </td>
                <td>
                    <span>{{ $lastyear->OutreachPlan }}</span>
                    <br><br>
                    <span>{{ $lastyear->OutreachPlan }}</span>
                  </td>
              </tr>
              <tr>
                <td colspan="2">
                  Find out more information about Church Advance programs. Select all that apply. <i class="fas fa-question-circle"></i>
                  <div class="row ch-ad-pro" style="padding: 14px 0px 0px 70px;">
                    <div class="col-10">
                      <label class="">Changing Course Consultation</label><br>
                      <label class="">PEAK Assessment Tool</label><br>
                      <label class="">Alliance Transitional Ministry Network (ATMN)</label><br>
                      <label class="">Fresh Start</label><br>
                      <label class="">EquippingU Maximum Impact</label><br>
                      <label class="">EquippingU Dynamic Influence</label><br>
                    </div>
                    <div class="col-2">
                      <span><input type="checkbox" name="CAProgramConsultation" id="CAProgramConsultation" class="form-check-input"></span><br>
                      <span><input type="checkbox" name="CAProgramPEAK" id="CAProgramPEAK" class="form-check-input"></span><br>
                      <span><input type="checkbox" name="CAProgramATMN" id="CAProgramATMN" class="form-check-input"></span><br>
                      <span><input type="checkbox" name="CAProgramFreshStart" id="CAProgramFreshStart" class="form-check-input"></span><br>
                      <span><input type="checkbox" name="CAProgramMaxImpact" id="CAProgramMaxImpact" class="form-check-input"></span><br>
                      <span><input type="checkbox" name="CAProgramDynamicInfluence" id="CAProgramDynamicInfluence" class="form-check-input"></span><br>
                    </div>
                  </div>
                </td>
                <td></td>
            </tr>
              <tr>
                  <td>Mortgage Debt</td>
                  <td><input type="text" class="form-control" name="ChurchDebt" value="{{ $annualreportdata->ChurchDebt }}"></td>
                  <td>{{ $lastyear->BulletinCount }}</td>
              </tr>
              <tr>
                <td>Special Mailing Inserts</td>
                <td><input type="text" class="form-control" name="BulletinCount" value="{{ $annualreportdata->BulletinCount }}"></td>
                <td>{{ $lastyear->BulletinCount }}</td>
            </tr>
              </tbody>
          </table>
          </section>
          <center><button>Continue</button></center>
          <br>
          
        </form>
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