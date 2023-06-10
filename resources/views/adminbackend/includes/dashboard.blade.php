@extends('adminbackend.layouts.index')
@php
    use App\Helpers\ARHelper;
    use App\Models\Annualreport;
    use App\Models\District;
    use App\Models\DistrictChurch;
    use Carbon\Carbon;

    $now = Carbon::now();
    $reportYear = $now->year-1;
    $otp = Auth::user()->otp ?? '';
    $otpStatus = Auth::user()->otp_status ??'';
    $segmentlast =last(request()->segments());

    $segments = url()->current();
    $url = explode("/",$segments);
    $segurl = $url[4];
    $urlData = base64_decode($segurl);
    parse_str($urlData, $params);

    $districtname = Auth::user()->district ??'';
    $getuserdistrict =  District::select('Name')->where('Mainkey',$districtname)->first();

    $district = District::all();
    $churchdistrictname = Auth::user()->churchdistrict ??'';
    $getuserchurchdistrict = DistrictChurch::select('ChurchName')->where('ChurchMainkey',$churchdistrictname)->first();

@endphp
@section('section')

<style>
button.close {
    padding: 0;
    background-color: transparent;
    border: 0;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;

}
.icon{
  font-size: 18px;
}
.count{
    font-size: 18px;
    color: #012970;
    font-weight: 700;
    margin: 0;
    padding: 0;
}
.countlable{
    font-weight: 1000;
    color: #801214;
}
.status{
    padding-top: 10px !important;
}
.check-icon {
  color: #801214;
  background: #f6f6fe;
font-size: 22px !important;
    border-radius: 50%!important;
}
.church-icon {
  color: #ff771d;
  background: #ffecdf;
font-size: 20px !important;
    border-radius: 50%!important;
}
.report-icon {
  color: #2eca6a;
  background: #e0f8e9;
font-size: 19px  !important;
border-radius: 50%!important;
}
.text-color{
  color: #ff771d;
}
.status-report{
  cursor: pointer;
}

</style>
   <!-- bootstrap -->
   {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> --}}
   <!-- dataTable -->
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
   {{-- <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">  --}}

<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">

        <!-- Report submitted Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card revenue-card">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"></a>
              {{-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul> --}}
            </div>

            <div class="card-body status-report" id="submitted">
              <h5 class="card-title">Report Submitted </h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bx bx-list-check"></i>
                  {{-- <i class="bx bxs-report"></i> --}}
                </div>
                {{-- <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bx bx-list-check"></i>
                </div> --}}
                <div class="ps-3">
                  <h6>{{ $SubmitReport ?? '00' }}</h6>
                  <span class="text-success small pt-1 fw-bold">{{ $SubmitReportPercent ?? '0'}}%</span> <span class="text-muted small pt-2 ps-1"></span>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- End Report submitted Card -->

        <!-- Report Pending Card-->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card customers-card">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"></a>
              {{-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul> --}}
            </div>

            <div class="card-body status-report" id ="Inprogres">
              <h5 class="card-title">Report In Progress </h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bx bxs-report" ></i>
                </div>
                <div class="ps-3">
                  <h6>{{$ProgressReport ?? '00'}}</h6>
                  <span class="text-color small pt-1 fw-bold">{{$ProgressReportPercent??'0'}}%</span> <span class="text-muted small pt-2 ps-1"></span>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- End Report Pending Card-->

        <!-- Churches Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"></a>
              {{-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul> --}}
            </div>

            <div class="card-body status-report" id="notstarted">
              <h5 class="card-title">Report Not Started </h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bx bx-church"></i>
                </div>
                <div class="ps-3">
                  <h6><span class="text-danger">{{$PendingReport ?? '00'}}</span>/{{ $Churchcount ?? '00' }}</h6>
                  <span class="text-danger small pt-1 fw-bold">{{$PendingReportPercent??'0'}}%</span> <span class="text-muted small pt-2 ps-1"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End Churches Card -->

        <!-- Churchlist Section -->
        <div class="col-12">
          <div class="card recent-sales overflow-auto">
            <div class="filter">
              <div class="col-sm-12" style="padding-left: 1px !important">
                  <span id='loader' style='display: none;'>
                      <img src="{{asset('assets/img/gif/ajaxload.gif')}}" width='32px' height='32px' >
                  </span>
                  <span class="filter-span">
                    <input class="form-check-input"  name="disableCheckbox" type="checkbox" id="staffexport" value="Y">
                    <label class="form-check-label" for="gridCheck">Include Staff</label>
                  </span>
                  <span class="filter-span">
                    <input class="form-check-input align" type="checkbox" name="checkAll" id="checkAll">
                    <label class="form-check-label" for="gridCheck">
                       Select All
                    </label>
                  </span>
                  <button class="exportbtn" id="exportbtn" data-toggle="tooltip" title="Export to CSV" disabled="disabled"><i class="mdi mdi-file-excel"></i><span id="exportcount">Export</span></button>
              </div>
            </div>
            <div class="card-body">
              <h5 class="card-title">Church List <span>| Church Report</span></h5>
               <!-- <Admin Status> -->
                {{-- <div class="row">
                  <div class="col-sm-4" style="background-color: #f6f9ff;">
                      <div class="form-check icon">
                          <i class="bi bi-check2-circle  check-icon"></i>
                          <label class="form-check-label status" for="gridCheck">
                          <span class="countlable" id="submitted">Submitted</span> <b>:</b> <span class="count">{{ $SubmitReport ?? '00' }}</span>  <span class="text-danger small pt-1 fw-bold">({{ $SubmitReportPercent ?? '0'}}%)</span>
                          </label>
                      </div>
                  </div>
                  <div class="col-sm-4" style="background-color: #f6f9ff;">
                      <div class="form-check icon">
                          <i class="bi bi-hourglass-split report-icon"></i>
                          <label class="form-check-label status" for="gridCheck">
                              <span class="countlable" id="Inprogres">In Progress</span> <b>:</b> <span class="count">{{$ProgressReport ?? '00'}}</span> <span class="text-danger small pt-1 fw-bold">({{$ProgressReportPercent??'0'}}%)</span>
                          </label>
                      </div>
                  </div>
                  <div class="col-sm-4" style="background-color: #f6f9ff;">
                      <div class="form-check icon">
                          <i class="bx bx-church church-icon"></i>
                          <label class="form-check-label status" for="gridCheck">
                          <span class="countlable" id="notstarted">Not Started</span> <b>:</b> <span class="count">{{$PendingReport ?? '00'}}</span>
                              <span class="text-danger small pt-1 fw-bold">({{$PendingReportPercent??'0'}}%)</span>
                          </label>
                      </div>
                  </div>
                </div> --}}
                <!-- <Admin Status End> -->
              <table class="table table-borderless" id="churchlist">
                <thead style="font-size: 13px">
                    <tr>
                    <th class="firstcheck" data-orderable="false">#</th>
                        <th scope="col">Church Name</th>
                        <th scope="col">Mainkey</th>
                        <th scope="col" style="width: 100px;">Church Code</th>
                        <th scope="col" style="width: 100px;">Church Staff</th>
                        <th scope="col">Report Status</th>
                        <th scope="col">Validate</th>
                        <th scope="col">Active</th>
                        <th scope="col">Mail To</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                  <br>
                  <div class="alert alert-success " id="exportsuccess" style="display:none">
                  Exported Successfully.
                  <div style="float:right;margin-top: -5px;">
                  <button type="button" id="Closesuccess" class="close" data-dismiss="modal" >&times;</button>
                  </div>
                  </div>
                  {{-- @foreach($data as $value)

                    <tr id="user_row{{$value->id}}">
                      <td><input class="form-check-input" type="checkbox" name="export" id="export" onchange="exportcheck(this)" value="{{$value->id}}"></td>
                      <td>
                        <a href="{{url('AnnualReport/ChurchReport/'.base64_encode(($value->Mainkey + 122354125410)).'/'.$reportYear.'') }}" target="_blank">{{ $value->MailingName }}</a>
                      </td>
                      <td>{{ $value->Mainkey }}</td>
                      <td>{{substr($value->ChurchCode,0,2)}}-{{substr($value->ChurchCode,2,2)}}-{{substr($value->ChurchCode,4,4)}}</td>
                      <td>  @if($value->ReportStatus != "")
                        {{ $value->ReportStatus }}
                        @else
                        Not Started
                        @endif</td>
                      <td>
                        <input class="form-check-input validate" name="validate" type="checkbox" id="validate{{ $value->Mainkey }}" onchange="validatecheckbox({{ $value->Mainkey }},this)" data-id="{{ $value->Mainkey }}" value="Y" @if ($value->validate == 'Y') checked @endif @if($value->ReportStatus != 'Completed') disabled @endif>
                      </td>
                      <td><a href="mailto:{{ $value->USAEmail }}">{{ $value->USAEmail }}</a></td>
                      <td>
                        <i class="fa fa-edit churchEdit" style="color:#801214" data-bs-toggle="modal" data-bs-target="#church-edit" onclick="churchemailedit({{$value->Mainkey}})"></i>
                      </td>
                    </tr>
                  @endforeach --}}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Main Section Modal -->
<div class="modal fade church-edit" id="church-edit" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <form id="church-edit-form">
              @csrf
              <div class="modal-header">
                  <h5 class="modal-title">Email Update</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-9">
                    <label class="form-label">Church Name</label>
                    <input type="text" class="form-control" id="chruchname" value="" disabled>
                  </div>
                  <div class="col-3">
                    <label class="form-label">Church Mainkey</label>
                    <input type="text" class="form-control" id="churchmainkey" value="" disabled>
                  </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Email <span class="mandatory">*</span></label>
                        <input type="text" class="form-control" name="email" id="chruchemail" value="">
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary-report">Update</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
          </form>
      </div>
    </div>
</div>

{{-- List all the staffs --}}
<div class="modal fade church-edit" id="listallstaff" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <form id="church-edit-form">
              @csrf
              <div class="modal-header">
                  <h5 class="modal-title">View Staffs</h5>
                  <button type="button" id="CloseModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-12">

                    <table class="table table-borderless" id="viewstaffs">
                        <thead style="font-size: 13px">
                            <tr>
                                <th scope="col">Staff Name</th>
                                <th scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody id="staffviewid">

                        </tbody>
                      </table>

                  </div>

                </div>
              </div>
          </form>
      </div>
    </div>
</div>

<script>

// view staff on Dashboard


    $('#churchlist').on('click','.viewstaff',function(e) {
        e.preventDefault();
        
        var staffmainkey = $(this).attr('data-val');
        var url = "{{url('viewdashboardstaff')}}"
        viewstaff(staffmainkey,url);
    });

    function viewstaff(staffmainkey,url){
        $.ajax({
            type: "get",
            url: url,
            data: {
                EntityMainKey:staffmainkey
            },

            success: function(response) {

                const names = response.data;
                if(names.length != 0){
                  $("#listallstaff").appendTo("body").modal('toggle');
                  $.each(names, function( key, value ) {
                   var stafftitle = value['Title'] ? value['Title']+' ' : '';
                   var midname = value['MiddleName'] ? ' '+value['MiddleName'] : '';
                   var suffix = value['Suffix'] ? ' '+value['Suffix'] : '';
                   var lastname = value['LastName'] ? value['LastName']+',' : '';
                   var fullname = lastname+' '+stafftitle+''+value['FirstName']+''+midname+''+suffix;

                   var empty = '';
                   var staffname = value['FullName'];

                   if(value['FirstName'] || lastname || stafftitle || midname || suffix || stafftitle){
                    var arstaffname = fullname;
                    console.log(arstaffname);

                   }else if(staffname){
                    var arstaffname = staffname;
                   }else{
                    var arstaffname = empty;
                   }

                    $("#staffviewid").append(" <tr><td>"+arstaffname+"</td><td>"+value['Email']+"</td></tr>");
                    });
                  }else{
                    let isExecuted = confirm("There is no Annual Report staff's in this church.."); 
                  }
            }
        });
    }

    $("#CloseModal").click(function() {
      $('#myprofile').modal('hide');
    });

    $(".modal").on("hidden.bs.modal", function() {
      $('#staffviewid').empty();
    });


    var otp ='{{$otp}}';
    var segmentlast ="{{$params['otp'] ?? ''}}";
    var otpStatus ="{{ $otpStatus ?? '' }}";
    if(otpStatus == 0){
    if(otp != ''){
        if (otp == segmentlast) {
        let isExecuted = confirm("If you want to change your password, you can reset it..");
        if(isExecuted !=''){
            window.location.href = "{{ route('change-password',array(ARHelper::encryptUrl(Auth::user()->id))) }}";
        }
        }
    }
    }

    $(document).ready(function(){
        $('table#churchlist').DataTable().column(4).visible(false);
        $("#staffexport").on('change', function() {
        if ($(this).is(':checked')) {
            $('table#churchlist').DataTable().column(4).visible(true);

        } else {
            $('table#churchlist').DataTable().column(4).visible(false);
        }
        });
    });


     var tableMain = $('table#churchlist').DataTable({
        processing: true,
        serverSide: true,
        Filter: true,
        bInfo: true,
        bPaginate: true,
        ajax: "{{ url('dashboardchurchlistfilter') }}",
        columns: [
            {data: 'actioncheck', name: 'Actioncheck', orderable: false, searchable: true},
            {data: 'mailingname', orderable: true, searchable: true},
            {data: 'Mainkey', orderable: true, searchable: true},
            {data: 'ChurchCode', orderable: true, searchable: true},
            {data: 'ChurchStaff', orderable: true, searchable: true},
            {data: 'status', orderable: true, searchable: true},
            {data: 'validate', orderable: true, searchable: true},
            {data: 'Active', orderable: true, searchable: true},
            {data: 'USAEmail', orderable: true, searchable: true},
            {data: 'action', name: 'Action', orderable: false, searchable: true},
        ],
        columnDefs: [
            {
            responsivePriority: 1,
            targets: 0
            },
            {
            responsivePriority: 2,
            targets: -1
            }
        ],
        lengthMenu: [
          [10, 25, 50, 100 ,500, -1],
          [10, 25, 50, 100 ,500,'All',-1],
        ],
        
    });

// Active checkbox

// function Activechurch(){
//  if ( $('#Activecheckbox').prop('checked')) {
// } 
// else {
//    let isExecuted = confirm("Only active churches can edit their Annual Report. Inactive churches can only view existing reports. Are you sure you want to make this change..?");
//  if(isExecuted !=''){
//   $('#Activecheckbox').prop('checked',false);
//    }
//    else{
//         $('#Activecheckbox').prop('checked',true);
//        }
//    }
// }

function Activechurch(mainkey,val){
    if(val.checked){
        var val = 'Active';
    }else{
  let isExecuted = confirm("Only active churches can edit their Annual Report. Inactive churches can only view existing reports. Are you sure you want to make this change..?");
  if(isExecuted !=''){
    var val = 'Inactive';    
  }else{
    $('.Activecheckbox').prop('checked',true);
  }
    }
    var data = {
        'mainkey' : mainkey,
        'Active' : val,
    };
    $.ajax({
        method : 'GET',
        url: "{{ url('AnnualReport/active') }}",
        data : data,
        success: function(response) {

        }
    });
}

    $( "#churchlist_length" ).change(function() {
      $('#checkAll').prop('checked',false);
      $('#exportbtn').removeClass('active').attr('disabled','disabled');
      $("span#exportcount").html("Export");
      });


    $('#churchlist').on('click','.mainsectionedit',function() {
        $("#church-edit").appendTo("body").modal('toggle');
        var id = $(this).attr('id');
        var data = $(this).attr('data-id');
        var val = $(this).attr('data-val');
        var url = "{{url('churchlistedit')}}";
        showsection(url,data,val);
    });

    function showsection(url,data,val){
        $.ajax({
            type: "get",
            url: url,
            data: {
                id : data,
                MainKey:val

            },

            success: function(response) {

                $("#chruchname").val(response.data.MailingName);
                $("#churchmainkey").val(response.data.ChurchMainkey);
                $("#chruchemail").val(response.data.USAEmail);
            }
        });
    }

    $("#submitted").click(function(){
        var labelText = 'Completed';
        triggerAction(labelText);
    });

    $("#notstarted").click(function(){
        var labelText = 'Not Started';
        triggerAction(labelText);
    });

    $("#Inprogres").click(function(){
        var labelText = 'In Progress';
        triggerAction(labelText);
    });

    function triggerAction(labelText){
        $(".dataTables_filter input").val(labelText);
        tableMain.search(labelText).draw();
    }

// $('#churchlist').DataTable({
//     lengthMenu: [
//         [10, 25, 50, 100 ,500, -1],
//         [10, 25, 50, 100 ,500,'All',-1],
//     ]
// });

    function churchemailedit(mainkey){
        $.ajax({
            method : "get",
            data : {'mainkey' : mainkey},
            url:"{{ url('AnnualReport/churchedit') }}",
            success: function(response) {
                data = response.editchurchdata;
                $("#chruchname").val(data['MailingName']);
                $("#churchmainkey").val(data['Mainkey']);
                $("#chruchemail").val(data['USAEmail']);
            }
        });
    }

    // jQuery.validator.addMethod("accept", function(value, element, param) {
    //     return value.match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,8})$/);
    // },'The email should be in the format: abc@gmail.com');

    $("#church-edit-form").validate({
        rules: {
        email : {
            email:true,
            accept: true,
            required: true,
            maxlength:100,
            pattern : /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i,
        },
        },
        messages : {
        email: {
            required: "Please enter a valid Email",
            pattern: "Please enter a valid Email.",
        },
        },
        submitHandler: function(form) {

        data ={
            "churchmainkey" : $("#churchmainkey").val(),
            "USAEmail" : $("#chruchemail").val(),
        };

        $.ajax({
            method : "get",
            data : data,
            url:"{{ url('churchdataupdate') }}",
            success: function(response) {
                $("#church-edit").modal("hide");

                swal("Success!", ""+response.data+"", "success").then(okay => {
                if (okay) {
                    window.location.reload();
                }
                });
            }
        });
    }
  });
  $("#myprofileuser").validate({
  rules: {
      username: {

              required: true,
              maxlength: 50,
              minlength:8,

            },
      email: {
             required:true,
              email:true,
              accept: true,
              required: true,
              maxlength:100,
      },
      district:{
              required: true,
      }
  },
  messages: {
      username: {
          required: "Please enter a valid Username",

      },
      email: {
          required: "Please enter a valid Email",

           regex:"Please enter a valid Email"
      },
      district:{
          required: "Please Choose a District ",
      }
  },
  submitHandler: function(form) {
    var formId = 'myprofileuser';

    $.ajax({
        method : "POST",
        data : $("#"+formId+"").serializeArray(),
        url:"{{ url('AnnualReport/Update-Users') }}",
        success: function(response) {
            $("#myprofile").modal("hide");

            swal("Success!", ""+response.success+"", "success").then(function(){
                    window.location.reload();

            });
        }
    });
  }
});

// $("#exportallbtn").on('click',function() {
//     $.ajax({
//         method : "get",
//         url:"{{ url('Exportallchurchlist') }}",
//         beforeSend: function(){
//                 // Show image container
//                 $("#loader").show();
//             },
//         success: function(response) {

//           $("#loader").hide();

//                 var a = document.createElement('a');
//                 var url = "{{asset('files/Churchreportlist.csv')}}";
//                 a.href = url;
//                 a.download = 'Churchreportlist.csv';
//                 document.body.append(a);
//                 a.click();
//                 a.remove();
//                 $("#exportsuccess").removeAttr('style');
//             }
//     });
// });

    $("#checkAll").click(function () {
        var check = $(this).prop('checked');
        var numberChecked = $('input:checkbox[name="export"]').not(this).prop('checked', this.checked).length;
        if(check == true){
            $('#exportbtn').addClass('active').removeAttr('disabled');
            $("span#exportcount").html("Export (" + numberChecked + ")");

        }else{
        $('#exportbtn').removeClass('active').attr('disabled','disabled');
        $("span#exportcount").html("Export");
        }
    });

    $('#exportbtn').click(function () {
        i = 0;
        var arr = [];
        $('#export:checked').each(function () {
            arr[i++] = $(this).val();
        });

        exportCSV(arr);
    });

    function exportCSV(arr) {

        var data = {
          id : arr,
          staff : $("#staffexport:checked").val()
        };

        var url = "{{ Route('churchexportXlxs') }}";
        $.ajax({
            method : "get",
            url: url,
            data : data,
            beforeSend: function(){
                // Show image container
                $("#loader").show();
            },
            success: function(response) {
              $("#loader").hide();
                var a = document.createElement('a');
                var url = "{{asset('files/Churchreportlist.csv')}}";
                a.href = url;
                a.download = 'Churchreportlist.csv';
                document.body.append(a);
                a.click();
                a.remove();
                $("#exportsuccess").removeAttr('style').delay(2000).fadeOut();
            }
        });
    }
     $("#Closesuccess").click(function() {
        $('#exportsuccess').attr('style','display:none');
        
        
    });
// export all

 // end export
 function validatecheckbox(mainkey,val){
    if(val.checked){
        var val = 'Y';
    }else{
        var val = 'N';
    }
    var data = {
        'mainkey' : mainkey,
        'validate' : val,
        'YearReport' : "{{$reportYear}}"
    };
    $.ajax({
        method : 'GET',
        url: "{{ url('AnnualReport/validate') }}",
        data : data,
        success: function(response) {

        }
    });
}
function exportcheck(val){
 var data= $("#export:checked").length;
  if(val.checked){
    $("#exportbtn").addClass('active').removeAttr('disabled');
    $("span#exportcount").html("Export (" + data + ")");

  }else{
    i = 0;
    var arr = [];
    $('input#export:checked').each(function () {
        arr[i++] = $(this).val();
        $("span#exportcount").html("Export (" + data + ")");

    });

    if(arr != ''){
        $('#exportbtn').addClass('active').removeAttr('disabled');
        $("span#exportcount").html("Export (" + data + ")");
    }else{
        $('#exportbtn').removeClass('active').attr('disabled','disabled');
        $("span#exportcount").html("Export");
    }
  }
}

// modal hide
$(".modal").on("hidden.bs.modal", function() {
    $("#chruchname").val('');
    $("#churchmainkey").val('');
    $("#chruchemail").val('');
});

var value = "{{$districtname}}";
var churchdistrict = "{{$churchdistrictname}}";

$.ajax({
    type:"get",
    url:"{{ url('AnnualReport/getdistrict') }}",
    data:{
        'district' : value
    },
    success:function(response){
         var options = $("#churchdistrict");
         options.empty().append("<option>Select Church</option>");
        $.each(response, function () {
            var text = ''+this.ChurchName+', '+this.MailingCity;
            options.append($("<option />").val(this.ChurchMainkey).text(text));
        });
        $('#churchdistrict option[value="'+churchdistrict+'"]').attr('selected','selected');

    }
});


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

</script>
@endsection
