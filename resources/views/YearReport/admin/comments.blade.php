@extends('YearReport.layouts.index')

@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;
$year = request()->segment(count(request()->segments()));                
@endphp

@section('contents')

<div class="tab-section">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <section class="sub-section">
          <h5 class="sub-section-head">Comments</h5>
          <table>
            <tr>
              <td><p style="width: 640px;">Do you have any comments regarding this year's Annual Report?</p></td>
            </tr>
            <tr>
              <td><textarea class="form-control" name="Comment" id="Comment" style="width:100%;">{{ $annualreportdata->Comment }}</textarea></td>
            </tr>
            <tr>
              <td>
                <br>
                <center><button>Yes</button>&nbsp;<button>No</button></center>
              </td>
            </tr>
          </table>
          
        </section>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <section class="sub-section">
          <div class="question">
            <div class="QA">
              <h6><center>Question Assistant</center></h6>
              <p>If you would like to give an explanation for any of the figures entered in this report, enter them now.</p>
            </div>
            <div class="help">
              <h6><center>How This Helps</center></h6>
              <p>Understanding the circumstances behind the trends in your church are helpful to the district office when verifying your report.</p>
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