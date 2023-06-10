@extends('YearReport.layouts.index')
@section('contents')
@php 
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;  
$year = request()->segment(count(request()->segments()));
@endphp 

<div class="tab-section">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <section class="sub-section">
          <h5 class="sub-section-head">Membership</h5>
          <table class="table table-responsive" style="width:100%">
            <thead>
              <tr>
                <th class="col-head">Question</th>
                <th class="col-head">This Year</th>
                <th class="col-head stat">Last Year</th>
              </tr>
            </thead>
            <tbody>            
              <tr>
                <td class="col-head"><h6>Members as of 12/31/{{$year-1}}</h6></td>
                <td><input type="text" class="form-control" name="PreviousYearMembers" value="{{ $annualreportdata->PreviousYearMembers }}"></td>
                <td>{{ $lastyear->MembersTotal }}</td>
              </tr>
              <tr>
                <td>- Members Removed</td>
                <td><input type="text" class="form-control" name="MembersRemoved" value="{{ $annualreportdata->MembersRemoved }}"></td>
                <td>{{ $lastyear->MembersRemoved }}</td>
              </tr>
              <tr>
                <td>+ Members Added</td>
                <td><input type="text" class="form-control" name="MembersAdded" value="{{ $annualreportdata->MembersAdded }}"></td>
                <td>{{ $lastyear->MembersAdded }}</td>
              </tr>
              <tr>
                @php

                $equal_members = $annualreportdata->PreviousYearMembers + $annualreportdata->MembersAdded - $annualreportdata->MembersRemoved;

                $previous_equal_members = $lastyear->PreviousYearMembers + $lastyear->MembersAdded - $lastyear->MembersRemoved;



                @endphp
                <td class="col-head"><h6>Equals Members as of 12/31/{{$year}}</h6></td>
                <td><input type="text" class="form-control" name="" value="{{ $equal_members }}"></td>
                <td>{{$previous_equal_members}}</td>
              </tr>
              <tr>
                <td>+ Total Adherents</td>
                <td><input type="text" class="form-control" name="AdherentsTotal" value="{{ $annualreportdata->AdherentsTotal }}"></td>
                <td>{{ $lastyear->AdherentsTotal }}</td>
              </tr>
              <tr>

                @php

                $equals_total_member = $equal_members + $annualreportdata->AdherentsTotal;
                $previous_equals_total_member = $previous_equal_members + $lastyear->AdherentsTotal;

                @endphp
                <td class="col-head"><h6>Equals Total Members + Adherents</h6></td>
                <td><input type="text" class="form-control" name="InclusiveTotal" value="{{ $equals_total_member }}"></td>
                <td>{{$previous_equals_total_member}}</td>
              </tr>

            </tbody>
          </table>
        </section>
        
        <section class="sub-section">
          <h5 class="sub-section-head">Ethinicity <i class="fas fa-question-circle"></i></h5>
          <table class="table table-responsive" id="ethnicitytable" style="width:100%">
            <thead>
              <tr>
                <th class="col-head">Ethnicity</th>
                <th class="col-head">Approximate Percentage</th>
                <th class="col-head">This Year</th>
                <th class="col-head">Last Year</th>
                <th class="col-head">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach( $ethnicity as $ethnicity_value)
              <tr>
                <td>{{ $ethnicity_value->Ethnicity }}</td>
                <td><input type="range" class="form-range" data-id="{{ $ethnicity_value->Percentage }}" value="{{ $ethnicity_value->Percentage }}" min="1" max="100" id="myRange{{ $ethnicity_value->Percentage }}"></td>
                <td><span id="perValue{{ $ethnicity_value->Percentage }}"></span>%</td>
                <td>100%</td>
                <td><i  id ="Ethnicitydel"class="fas fa-trash"></i></td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <td class="col-head">
                  <select name="country" id="country" class="form-select">
                    <option value=""></option>
                    @foreach($ethnicitydropdown as $ethni_dropdown)
                    <option value="{{ $ethni_dropdown->Ethnicity }}" {{ $ethni_dropdown->Ethnicity == $annualreportdata->Ethnicity ? 'selected' : ''}}>{{ $ethni_dropdown->Ethnicity }}</option>
                    @endforeach
                  </select>
                </td>
                <td class="col-head"><button id="addethnicity">Add Ethnicity</button></td>
                <td>100%</td>
                <td>100%</td>
                <td><i class="fas fa-check"></i><i class="fas fa-warning"></i></td>
              </tr>
            </tfoot>
          </table> 
        </section>
        <center><button id="ethnicitystore">Continue</button></center>
        <br>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <section class="sub-section">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript">

$("#addethnicity").on('click', function() {
 var name = $("#country").val();
 
 if(name != ""){
var newRow = '<tr><td>'+name+'</td>'+'<td><input type="range" class="form-range" data-id="" value="100" min="1" max="100" id=""></td>'+'<td> <span id="perValue100"></span> %</td>'+
'<td>100%</td>'+
'<td><i id ="Ethnicitydel" class="fas fa-trash"></i></td></tr>';

  if ($("#ethnicitytable > tbody > tr").is("*"))
    $("#ethnicitytable > tbody > tr:last").after(newRow)
  else $("#ethnicitytable > tbody").append(newRow)
 }
else{
  alert("Please select country");
 } 
});
$(document).on('click', '#Ethnicitydel', function() {
  $(this).parents('tr').remove();
});

$('.form-range').each(function(){
  var dataId =  $(this).attr('data-id');
  sliderpercentage(dataId);
});

function sliderpercentage(dataId){
  var sli = "myRange"+dataId;
  var out = "perValue"+dataId;
  var slider = document.getElementById(sli);
  var output = document.getElementById(out);
  output.innerHTML = slider.value;

  slider.oninput = function() {
  output.innerHTML = this.value;
  }
}

$("#ethnicitystore").on('click',function(){
  alert('yes');
})

</script>
@endsection

