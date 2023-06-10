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
          <h5 class="sub-section-head">Current Church Staff</h5>
          <table class="table">
              <thead>
              <tr>
                  <th class="col-head">Staff Member</th>
                  <th class="col-head">Contact</th>
                  <th class="col-head">Role(s)</th>
                  <th class="col-head"><center><button><i class="fas fa-add"></i> Add</button></center></th>
              </tr>
              </thead>
              <tbody>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><center><a href=""><i class="fas fa-edit"></i></a></center></td>
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
                <p>Tell us about your current staff and each of the following roles they serve in:</p>
                <ul>
                  <li>Admin Asst</li>
                  <li>Board Chairman</li>
                  <li>Children Leader</li>
                  <li>Alliance Women Leader</li>
                  <li>Mens Ministry Leader</li>
                  <li>Missions Leader</li>
                  <li>Secretary of Board</li>
                  <li>Treasurer</li>
                  <li>Vice Chair of Board</li>
                  <li>Young Adult Leader</li>
                  <li>Youth Leader</li>
                </ul>
              </div>
              <div class="help">
              <h6><center>How This Helps</center></h6>
              <p>This information allows us to provide your church staff with access to email communications, newsletters, blogs, and missions leader tools.</p>
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