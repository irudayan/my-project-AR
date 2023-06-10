@extends('backend.layouts.main')
@section('content')
@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

$otp = Auth::user()->otp ?? '';
$Authuser = Auth::user()->usertype ?? '';
$userRoleMainkey = Auth::user()->district ??'';
$otpStatus = Auth::user()->otp_status ??'';

$segmentlast =last(request()->segments());

$now = Carbon::now();
$reportYear = $now->year-1;


$segments = url()->current();
$url = explode("/",$segments);
$segurl = $url[4];
$urlData = base64_decode($segurl);
parse_str($urlData, $params);



@endphp

<style type="text/css">
    .user-type:hover{
        text-decoration: underline;
        cursor: pointer;
    }
    .user-status:hover{
        text-decoration: underline;
        cursor: pointer;
    }
    i.fa-info-circle{
        font-size: 12px;
    }
    #error-comment{
        color: red;
    }
    label {
    margin-bottom: 0;
    }
    .page-item.active .page-link {
    background-color: #801214;
    border-color: #801214;
    }
    .page-link {
    color: #801214;
    }
    .row.bar{
        background-color:#801214;
        color:#fff;
    }
    .chick{
        position: relative !important;
        padding-left: 50px !important;
        cursor: pointer !important;
        padding-top: 7px !important;
    }.firstcheck{
    width: 36.75px !important;
}.align{
            margin: 5px 0px 0px 4px !important;
    }
    .check-icon {s
  color: #2eca6a !important;
  background: #e0f8e9;
font-size: 22px !important;
    border-radius: 50%!important;
}
.church-icon {
  color:#ff0000;
  background:#f6f6fe ;
font-size: 20px !important;
    border-radius: 50%!important;
}
.report-icon {
  color: #ff7f2a;
  background: #ffecdf ;
font-size: 19px  !important;
border-radius: 50%!important;
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
.status{
    cursor: pointer;
}
#Inprogres:hover {
  cursor: pointer;
}
#notstarted:hover {
  cursor: pointer;
}
#submitted:hover {
  cursor: pointer;
}
.countadjust{
    position: relative;
    display: block;
    padding-left: 0.25rem;
}


</style>

<div class="col-md-9" id="bri_ind_container">
<div class="php-email-form" >

    <!-- Navbar -->
    <nav id="navbar" class="flexbox profile-nav">
      <!-- Navbar Inner -->
      <div class="navbar-inner view-width flexbox-space-bet">
        <div class="row bar">
            <label><h4 class="align-middle">Church List</h4></label>
        </div>
        <br>
      </div>
    </nav>
    <div class="row">
        @if($Authuser =='District' || $Authuser =='NationalOffice')
        <div class="col-sm-4" style="background-color: #f6f9ff;">
            <div class="countadjust">
                <i style="color: #2eca6a" class="bx bx-list-check check-icon"></i>
                <label class="form-check-label status" for="gridCheck">
                <span class="countlable" id="submitted">Submitted</span> <b>:</b> <span class="count">{{ $districtSubmitReport ?? '00' }}</span>  <span style="color: #2eca6a " class=" small pt-1 fw-bold">({{ $districtSubmitReportPercent ?? '0'}}%)</span>
                </label>
            </div>
        </div>
        <div class="col-sm-4" style="background-color: #f6f9ff;">
            <div class="countadjust">
                <i class="bx bxs-report report-icon"></i>
                <label class="form-check-label status" for="gridCheck">
                    <span class="countlable" id="Inprogres">In Progress</span> <b>:</b> <span class="count">{{$districtProgressReport ?? '00'}}</span> <span style="color: #ff7f2a" class="small pt-1 fw-bold">({{$districtProgressReportPercent??'0'}}%)</span>
                </label>
            </div>
        </div>
        <div class="col-sm-4" style="background-color: #f6f9ff;">
            <div class="countadjust">
                 <i class="bx bx-church church-icon"></i>
                <label class="form-check-label status" for="gridCheck">
                 <span class="countlable" id="notstarted">Not Started</span> <b>:</b> <span class="count">{{$districtPendingReport ?? '00'}}</span>
                    <span style="color: #ff0000" class=" small pt-1 fw-bold">({{$districtPendingReportPercent??'0'}}%)</span>
                </label>
            </div>
        </div>
        
        <br><br>
        <div class="col-sm-6 col-md-6 col-xl-6 col-xs-6">
            <div class="form-check" style="padding-top: 17px;">
                <input class="form-check-input"  name="disableCheckbox" type="checkbox" id="staffexport" value="Y">
                <label class="form-check-label" for="gridCheck" style="padding:0px 33px 0 0;">
                  Include Staff
                </label>
                <input class="form-check-input" type="checkbox" name="checkAll" id="checkAll">
                  <label class="form-check-label" for="gridCheck">
                     Select All
                 </label>
            </div>
            {{-- <div class="form-check" style="padding-top: 17px;">
                
             </div> --}}
        </div>
        {{-- <div class="col-sm-4">
            <div class="form-check" style="padding-top: 17px;">
               <input class="form-check-input" type="checkbox" name="checkAll" id="checkAll">
                 <label class="form-check-label" for="gridCheck">
                    Select All
                </label>
            </div>
        </div> --}}
        <div class="col-sm-6 col-md-6 col-xl-6 col-xs-6" style="padding-left: 1px !important; padding-top: 17px;">
            <span style="float: right;">
                <span id='loader' style='display: none;'>
                    <img src="{{asset('assets/img/gif/ajaxload.gif')}}" width='32px' height='32px' >
                </span>
                <button class="exportbtn" id="exportbtn" data-toggle="tooltip" title="" disabled="disabled"><i class="mdi mdi-file-excel"></i><span id="exportcount">Export</span></button>
            </span>
        </div>
    </div>
    @endif
    <table id="district" class="table table-hover responsive district" style="width:100%;font-size:15px">
        <thead>
          <tr>
            @if($Authuser =='District' || $Authuser =='NationalOffice') <th>#</th>  @endif
            <th>Church Name</th>
            <th>Mainkey</th>
            <th>Church Code</th>
            <th>Report Status</th>
            <th>Validate</th>
            {{-- @if($Authuser =='District') <th>Active</th>  @endif --}}
            <th>Mail To</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

                 <br>
                <div class="alert alert-success" id="exportsuccess" style="display:none">
                Exported Successfully.
                <div style="float:right;margin-top: -5px;">
                <button type="button" id="Closesuccess" class="close" data-dismiss="modal" >&times;</button>
                </div>
                </div>
{{--
            @foreach($churchlist as $value)
                <tr id="user_row{{$value->id}}">
                    <td class="chick"><input class="form-check-input" type="checkbox" name="export" id="export" value="{{$value->id}}"></td>
                    <td>
                        <a href="{{url('AnnualReport/ChurchReport/'.base64_encode(($value->Mainkey + 122354125410)).'/'.$reportYear.'') }}" target="_blank">{{ $value->MailingName }}</a>
                    </td>
                    <td>
                        {{ $value->Mainkey }}
                    </td>
                    <td width="100px">
                        {{substr($value->ChurchCode,0,2)}}-{{substr($value->ChurchCode,2,2)}}-{{substr($value->ChurchCode,4,4)}}
                    </td>
                    <td>
                        @if($value->ReportStatus != "")
                        {{ $value->ReportStatus }}
                        @else
                        Not Started
                        @endif
                    </td>
                    <td>
                       &nbsp; <input class="form-check-input validate" name="validate" type="checkbox" id="validate{{ $value->Mainkey }}" onchange="validatecheckbox({{ $value->Mainkey }},this)" data-id="{{ $value->Mainkey }}" value="Y" @if ($value->validate == 'Y') checked @endif @if($value->ReportStatus != 'Completed') disabled @endif>
                    </td>
                    <td><a href="mailto:{{ $value->USAEmail }}">{{ $value->USAEmail }}</a></td>
                    <td><a href="javascript:void(0)" onclick="churchemailedit({{$value->Mainkey}})"><i class="fa fa-edit"></i></a></td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>
</div>

{{-- Model --}}
<div class="container">
    <!-- Delete Modal -->
    <div class="modal" id="church-edit">
    <div class="modal-dialog modal-lg modal-centered">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color:#801214;color: #fff;">
          <h4>Manage Account</h4>
          <button type="button" id="emailEditclose" class="close" data-dismiss="modal" >&times;</button>
        </div>
        <form id="church-edit-form">
            @csrf
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
                    <input type="text" class="form-control" name="email" id="chruchemail" value="" {{ $Authuser =='NationalOffice' ? 'disabled' : '' }}>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-add m-t-15 waves-effect mb-3" id="manageusersupdate" style="background-color: #801214;color:#fff;" >Update</button>
          <button class="btn btn-add m-t-15 waves-effect mb-3" id="emailEditClose" type="button" style="background-color: #801214;color:#fff;" >
          Cancel</button>
        </div>
      </form>
    </div>
    </div>
    </div>
  </div>
   

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- datatables scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<!-- Validate js Files -->  
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>

<script type="text/javascript">

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

    $("#emailEditclose").click(function() {
        $('#church-edit').modal('hide');
    });

    $("#emailEditClose").click(function() {
        $('#church-edit').modal('hide');
    });

    $("#exportallbtn").on('click',function() {
        $disMainkey = $(this).attr('data-val');
        // console.log($disMainkey);
        $.ajax({
            method : "get",
            url:"{{ url('ExportallDistrictchurchlist') }}",
            data : {
                mainkey : $disMainkey
            },
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
    var usertypes ='{{$Authuser}}';
   
    if(usertypes == 'District' || usertypes == 'NationalOffice' ){
    var tableMain = $('table#district').DataTable({
        processing: true,
        serverSide: true,
        bFilter: true, 
        bInfo: true,
        bPaginate: true,
        ajax: "{{ url('churchlistfilter') }}",
        columns: [
            {data: 'actioncheck', name: 'Actioncheck', orderable: false, searchable: true},
            {data: 'mailingname',orderable: true, searchable: true},
            {data: 'Mainkey', orderable: true, searchable: true},
            {data: 'ChurchCode', orderable: true, searchable: true},
            {data: 'status', orderable: true, searchable: true},
            {data: 'validate', orderable: true, searchable: true},
            // {data: 'Active', orderable: true, searchable: true},
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
        aLengthMenu: [
            [10, 25, -1],
            [10, 25, "All"]
        ]
    });
}else{
    var tableMain = $('table#district').DataTable({
        processing: true,
        serverSide: true,
        bFilter: true, 
        bInfo: true,
        bPaginate: true,
        ajax: "{{ url('churchlistfilter') }}",
        columns: [
            {data: 'mailingname',orderable: true, searchable: true},
            {data: 'Mainkey', orderable: true, searchable: true},
            {data: 'ChurchCode', orderable: true, searchable: true},
            {data: 'status', orderable: true, searchable: true},
            {data: 'validate', orderable: true, searchable: true},
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
        aLengthMenu: [
            [10, 25, -1],
            [10, 25, "All"]
        ]
    });
}
$( ".custom-select" ).change(function() {
      $('#checkAll').prop('checked',false); 
      $('#exportbtn').removeClass('active').attr('disabled','disabled');
      $("span#exportcount").html("Export"); 
      });
// Active checkbox

// function Activecheckbox(){
//   if ( $('#Activecheckbox').prop('checked')) {
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
    // Loading variant
    $("#submitted").click(function(){
        var labelText = 'Completed';
        triggerAction(labelText);
    });

    $("#notstarted").click(function(){
        var labelText = $("#notstarted").text();
        triggerAction(labelText);
    });

    $("#Inprogres").click(function(){
        var labelText = $("#Inprogres").text();
        triggerAction(labelText);
    });

    function triggerAction(labelText){
        $(".dataTables_filter input").val(labelText);
        tableMain.search(labelText).draw();
    }

    $('.district').on('click','.mainsectionedit',function() {
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
                    // $("#main-section-description").val(response.data.Description);
                
            } 
        });
    }

    // $(document).ready(function() {
    //     $(".district").DataTable({
    //         aaSorting: [],
    //         "iDisplayLength": 10,
    //         "aLengthMenu": [[10, -1], [10, "All"]],
    //         responsive: true,

    //         columnDefs: [
    //           {
    //             responsivePriority: 1,
    //             targets: 0
    //           },
    //           {
    //             responsivePriority: 2,
    //             targets: -1
    //           }
    //         ]
    //     });   

        $(".dataTables_filter input")
         .attr("placeholder", "Search here...")
        
        .css({
          width: "300px",
          display: "inline-block"
        });

        $('[data-toggle="tooltip"]').tooltip();

    // });


    $("#checkAll").click(function () {
        var check = $(this).prop('checked');
        var numberChecked = $('input:checkbox[name="export"]').not(this).prop('checked', this.checked).length;
        if(check == true){
            $('#exportbtn').removeAttr('disabled');
            $("span#exportcount").html("Export (" + numberChecked + ")");
        }else{
            $('#exportbtn').attr('disabled','disabled');
            $("span#exportcount").html("Export");
        }
    });

    $(document).on('click', 'input[name="export"]', function() {

        var check = $(this).prop('checked');
        var data= $("#export:checked").length;

        if(check == true){
            $('#exportbtn').removeAttr('disabled');
            $("span#exportcount").html("Export (" + data + ")");
        }else{
            $('#exportbtn').attr('disabled','disabled');
            $('input:checkbox[name="checkAll"]').removeAttr('checked');
            $("span#exportcount").html("Export");

        }

        i = 0;
        var arr = [];
        $('#export:checked').each(function () {
            arr[i++] = $(this).val();
        });
        if(arr != ''){
            $('#exportbtn').removeAttr('disabled');
            $("span#exportcount").html("Export (" + data + ")");
        }else{
            $('#exportbtn').attr('disabled','disabled');
            $('input:checkbox[name="checkAll"]').removeAttr('checked');
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
        var data ={
            id : arr,
            staff : $("#staffexport:checked").val()
        } 
        var url = "{{ Route('ExportallDistrictchurchlist') }}";
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

function churchemailedit(mainkey){
    $.ajax({
        method : "get",
        data : {'mainkey' : mainkey},
        url:"{{ url('AnnualReport/churchedit') }}",
        success: function(response) {
            $("#church-edit").appendTo("body").modal('toggle');
            data = response.editchurchdata;
            $("#chruchname").val(data['MailingName']);
            $("#churchmainkey").val(data['Mainkey']);
            $("#chruchemail").val(data['USAEmail']);
        }
    });
}

</script>

@endsection
