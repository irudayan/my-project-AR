@extends('YearReport.layouts.index')

@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;
use App\Models\Annualreport;
use Carbon\Carbon;

$now = Carbon::now();
$reportYear = $now->year-1;
$usertype = Auth::user()->usertype;
$segments = request()->segments();
$mainkey = $segments[4];
$year = $segments[5];
$getmainkey = ARHelper::decryptUrl($mainkey);
@endphp
@section('contents')
<style>
ul {
  list-style: none;
  padding-left: 1rem;
}
ul .subvalueactive:before{
  background-image: url('{{asset("assets/png/checkmark.png")}}');
  background-size: 14px 13px;
  display: inline-block;
  width: 14px;
  height: 13px;
  content:"";
}
ul .subvalue:before{
    background-image: url('{{asset("assets/png/listmark.png")}}');
    background-size: 14px 13px;
    display: inline-block;
    width: 14px;
    height: 13px;
    content:"";
}
ul{
  font-size:15px;
}
.QA{
  font-size:15px;
}
.error-sumbit{
  background-color: #fbd9da;
  color: red;
  border: 2px solid red;
}
.error-sumbit label{
  font-size: 12px;
  padding-left: 20px;
  margin-bottom: 0px; 
}
</style>
<div class="tab-section">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <section class="sub-section">
          <h5 class="sub-section-head">Report has been {{ $annualreportdata->ReportStatus ?? 'Not Started' }}!</h5>
          {{-- @if($annualreportdata != null)
          <p>Your report was successfully submitted on {{ date('m/d/Y', strtotime($annualreportdata->updated_at)) ?? '' }}.</p>
          @endif --}}
          <p>If you need to make changes to your report, Click the tab name of the section in question to modify your answers.</p>
        </section>

        @if ($usertype == 'District' || $usertype == 'Admin')
            @php
            $percent = ARHelper::getcompletepercent($getmainkey,$year);
            $getvalidate = Annualreport::select('id','Mainkey','ReportStatus','validate','YearReported')->where('Mainkey',$getmainkey)->where('YearReported',$year)->first();
            @endphp
            <section class="sub-section">
                <span style="padding-left: 20px">
                    <input class="form-check-input validate" name="validate" type="checkbox" id="validate{{$getvalidate->id ?? ''}}" data-id="{{$getvalidate->Mainkey ?? ''}}" value="Y"  @if ($getvalidate->validate ?? '' == 'Y') checked  @endif  @if($percent != 100) disabled="disabled" @endif>
                </span>
                <label>Reviewed by District Office</label>
            </section>
        @endif

        <div class="error-sumbit" id="error-sumbit" style="display: none;">
        </div>
        <br>
        @php
        $submit = ARHelper::getcompletepercent($mainkey,$year) ?? '0';
        @endphp
        @if ($usertype != 'NationalOffice')
        <center><button id="submit" type="submit" @if($submit > 90) disabled style="background-color:#d3d3d3" @endif>Submit</button></center>
        @endif
        <br>
        <section class="sub-section">
          <h5 class="sub-section-head">What's Next?</h5>
          <p>We will send a notification to you once we have the following tools readily available, along with the access information.</p>
          <ol>
            <li><strong>Historical Charts</strong> - Using 8 critical points of data, easily track your churches progress over the last 10 years</li>
            <li><strong>Going Deeper</strong> - A 4-step tool to assist you in taking the next step with your church in celebrating what God has done and where your church can be more effective </li>
          </ol>
        </section>
        <a href="{{route('churchreportdynamic',[$mainkey,$year])}}#print" target="_blank"><img class="noPrint" src="/assets/img/print.png" width="160px"></a>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <section class="sub-section">
          <div class="question">
            <div class="QA">
              @php
              if($annualreportdata != ''){
                $Mainkey = $annualreportdata->Mainkey;
              }
              else{
                $Mainkey = '';
              }
              @endphp
              <h6 style="padding: 7px 0 8px 0;"><center>{{ARHelper::getcompletepercent($Mainkey,$year) ?? '0'}}% Complete</center></h6>
                <table style="margin: 15px;">

                  @foreach($mainsection as $value)
                  @php
                    $subsection = ARHelper::subsection($value->Name);
                  @endphp

                  <tr>
                    <th>
                      <strong>
                        <u>
                          <a href="{{url('AnnualReport/ChurchReport/'.$value->Name.'/'.ARHelper::reviewlink($value->Name).'/'.ARHelper::encryptUrl($churchdata->Mainkey).'/'.$year)}}">{{ $value->Name }}</a>
                        </u>
                        <br>
                      </strong>
                    </th>
                  </tr>
                  <tr>
                    <td>
                      <ul>
                      @foreach($subsection as $subvalue)
                      @php
                        $getstatus = ARHelper::subsectionstatus($Mainkey,$year,$subvalue->SubSectionCode);
                      @endphp
                        <li class="{{ $getstatus == '1' ? 'subvalueactive' : 'subvalue' }}">{{$subvalue->Name}}</li>
                      @endforeach
                      </ul>
                    </td>
                  </tr>
                  @endforeach
                </table>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

$("#submit").on('click', function() {
    data = {
        "review" : "Review",
        "mainkey" : "{{$mainkey ?? ''}}",
        "year" : "{{$year ?? ''}}"
    };
    $.ajax({
        type: "get",
        dataType: "json",
        url: "{{ url('storereviewsubmit') }}",
        data: data,
        beforeSend: function(){
          $("#overlay").fadeIn(300);
        },
        success: function(response) {
          $("#overlay").fadeOut(300);
          if(response.Success){
            swal("Success!", ""+response.Success+"", "success").then(function(){
                window.location.reload();
            });
          }else{
            var report = response.data;
            $.each(report,function($key,$value){
              if($value == 0){
                $("#error-sumbit").removeAttr('style');
                $("#error-sumbit").append('<label>* Need to complete '+$key+' Tab.</label><br>');
              }
            });
          }
        } 
    });
});

$(document).ready(function(){

  $('.validate').on('change',function(){

      if(this.checked){
          var val = 'Y';
      }else{
          var val = 'N';
      }

      var data = {
          'mainkey' : $(this).attr('data-id'),
          'validate' : val,
          'YearReport' : "{{$reportYear}}"
      };

      var method = 'GET';
      var url = "{{ url('AnnualReport/validate') }}";

      validatecheckbox(data,method,url);
  });

  function validatecheckbox(data,method,url){
    $.ajax({
      method : method,
      url: url,
      data : data,
      success: function(response) {
      }
    });
  }

});

</script>

@endsection
