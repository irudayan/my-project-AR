@extends('backend.layouts.main')
@section('content')
@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;

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
    .form-select {
        border-radius: 4px;
    }
    .block {
        display: none;
    }
    .chick{
        position: relative !important;
        padding-left: 50px !important;
        cursor: pointer !important;
        padding-top: 7px !important;
    }
    .align{
            margin: 5px 0px 0px 4px !important;
    }
    .rotate {
        color: #801214;
        -moz-transition: all .5s linear;
        -webkit-transition: all .5s linear;
        transition: all .5s linear;
    }
    .rotate.down {
         color: #801214;
           transition: 0.9s;
    transform: rotate(180deg);
    }
.firstcheck{
    width: 36.75px !important;
}
.check-icon {s
  color: #2eca6a !important;
  background: #e0f8e9;
font-size: 22px !important;
    border-radius: 50%!important;
}
.church-icon {
  color:#183153;
  background:#f6f6fe ;
font-size: 20px !important;
    border-radius: 50%!important;
    padding: 13px 0 0 0;
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
    cursor: pointer !important;
    font-size : 14px!important;
}
.count-size{
    font-size : 14px!important;
    cursor: pointer !important;
}
.status{
    padding-top: 10px !important;

}
#usertypes{
    background-color: #f6f9ff;
    border: none;
    padding:14px 7px 0px 3px;
    cursor: pointer;
    width: 53%;
    color: #801214;
    font-weight: 1000;
}
#usercountspan{
    font-size: 18px;
    color: #012970;
    font-weight: 700;
    margin: 0;
    padding: 9px 0 0 0;
}
.form-style {
    position: relative !important;
    display: flex !important;
    padding-left: 0.25rem !important;
}

</style>

<div class="col-md-9" id="bri_ind_container">
<div class="php-email-form" >
    <!-- Navbar -->
    <nav id="navbar" class="flexbox profile-nav">
      <!-- Navbar Inner -->
      <div class="navbar-inner view-width flexbox-space-bet">
        <div class="row bar">
            <label><h4 class="align-middle">Users List</h4></label>
        </div>
        <br>
      </div>
    </nav>
    <div class="row" style="    padding: 0px 0px 22px 0px;">
        <div class="col-sm-4" style="background-color: #f6f9ff;">
            <div class="form-check">
                <i style="color: #2eca6a" class="bx bx-list-check check-icon"></i>

                <label class="form-check-label status" for="gridCheck">
                <span class="countlable" id="Approved">Approved</span> <b>:</b> <span class="count count-size">{{ $Approved ?? '00' }}</span>  <span style="color: #2eca6a " class=" small pt-1 fw-bold">({{ $ApprovedPercent ?? '0'}}%)</span>
                </label>
            </div>
        </div>
        <div class="col-sm-4" style="background-color: #f6f9ff;">
            <div class="form-check" style="padding-left: 0.25rem !important;">
                {{-- <i class="bx bxs-report report-icon"></i> --}}
                <i class="bi bi-file-x report-icon"></i>
                <label class="form-check-label status" for="gridCheck">
                    <span class="countlable" id="Inprogres">Not Approved</span> <b>:</b> <span class="count count-size">{{$notapproved ?? '00'}}</span> <span style="color: #ff7f2a" class="small pt-1 fw-bold">({{$notapprovedPercent??'0'}}%)</span>
                </label>
            </div>
        </div>
        <div class="col-sm-4" style="background-color: #f6f9ff;">
            {{-- <div class="form-check">
                 <i class="fa-solid fa-users church-icon"></i>
                <label class="form-check-label status" for="gridCheck">
                 <span class="countlable" id="notstarted">Distrct staff's</span> <b>:</b> <span class="count">{{$distrctstaff ?? '00'}}</span>

                </label>
            </div> --}}

            {{-- <label for="description" class="form-label">Website Role</label> --}}
            <div class="form-style">
            <i class="fa-solid fa-users church-icon"></i>
            <select class="form-select countlable" name="usertype" id="usertypes" style="font-size : 14px">
                <option value="">Select User</option>
                <option value="Users">Editor</option>
                <option value="Pastor">Pastor</option>
                <option value="District">District Staff</option>
                <option value="Admin">Admin</option>
            </select>
            <span id="usercountspan" class="count-size"></span>
        </div>
  </div>
    </div>
    <div class="row">
    <div class="col-sm-4 col-md-4 col-xl-4 col-xs-4">
        <input class="form-check-input align" type="checkbox" name="checkAll" id="checkAll">
<label class="form-check-label" for="gridCheck" style="padding: 0px 31px 0px 23px;">
    Select All
</label>
    </div>
    <div class="col-sm-4 col-md-4 col-xl-4 col-xs-4" id="usercounts">
<span class="form-check-label" for="gridCheck" style="padding: 0px 31px 0px 23px;" id="usercountlabel">

</span>

    </div>
<div class="col-sm-4 col-md-4 col-xl-4 col-xs-4" align="right" style="padding-left: 1px !important">
<span id='loader' style='display: none;'>
        <img src="{{asset('assets/img/gif/ajaxload.gif')}}" width='32px' height='32px' >
</span>
<button class="exportbtn" id="exportbtn" data-toggle="tooltip" title="Export to CSV" disabled="disabled"><i class="mdi mdi-file-excel"></i><span id="exportcount">Export</span></button>
  </div>
</div>
    <table id="manage-users" class="table table-hover responsive data-table" style="width:100%;font-size:15px">
        <thead>
          <tr>
            <th>#</th>
            <th>Users Name</th>
            <th>District</th>
            <th>Church</th>
            <th>Role</th>
            <th>Email</th>
            <th>Approved Status</th>
            <th>Impersonate</th>
            <th>Status</th>
            <th>Delete User</th>
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
           @foreach($users as $value)

              {{--    <tr id="user_row{{$value->id}}">
                    <td class="chick"><input class="form-check-input" type="checkbox" name="export" id="export" value="{{$value->id}}"></td>
                    <td>
                     <a href="javascript:void(0)" class="mainsectionedit" id="mainsectionedit{{$value->id}}" data-id="{{$value->id}}" data-original-title="view">{{ $value->username }}</a>
                    </td>
                    <td>
                        {{ ARHelper::getdistrict($value->district) ?? '' }}
                    </td>
                    <td>
                        {{ ARHelper::getchurch($value->churchdistrict) ?? '' }}
                    </td>
                    <td>
                        @php
                            $editor = 'Editor';
                            $distrctstaff = 'District Staff';
                        @endphp
                        @if ($value->usertype == 'Users')
                            {{$editor }}
                        @elseif($value->usertype == 'District')
                            {{ $distrctstaff }}
                        @else
                            {{ $value->usertype }}
                        @endif
                    </td>
                    <td>
                        <a href="mailto:{{ $value->email }}">{{ $value->email }}</a>
                    </td>
                    <td>
                        @if($value->approvestatus =='Approved')
                        {{ $value->approvestatus }}
                        @else()
                            Not Approved

                        @endif
                    </td>
                    @php
                        $ConsrtucturlData = ['email' => $value->email];
                        $encodedata = base64_encode(http_build_query($ConsrtucturlData));
                        $CurPageURL = "/Impersonate/".$encodedata;
                    @endphp

                    <td style="color: #801214" id="Impersonate" value="">
                        <a href="<?= $CurPageURL ?>" target="_blank"> Impersonate</a>
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="mainsectiondelete" onclick="deleteuser()"id="mainsectiondelete{{$value->id}}" data-id="{{$value->id}}" data-original-title="view"><i class="fa fa-trash"></i>
                        </a>
                    </td>
                    <td>
                        {{ $value->status }}
                    </td> --}}

                    {{-- <td>
                        <div class="row">
                        <div class="col-sm-8">

                            <button style="background:none;color:#801214;padding:0 0 0 0">
                                <a href="javascript:void(0)" class="mainsectionedit" id="mainsectionedit{{$value->id}}" data-id="{{$value->id}}" data-original-title="view"><i class="fa fa-edit"></i></a>
                            </button>

                            </div>
                        </div>
                    </td> --}}
                {{-- </tr>--}}
            @endforeach
        </tbody>
    </table>
</div>
 <!-- Delete Section Modal -->
 <div class="modal fade section" id="delete-section" tabindex="-1">
    <div class="modal-dialog modal-md">
    <div class="modal-content">
        <form id="delete-section-form">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"><span id="delete-header"></span>User Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="section-id" value="{{$value->id}}">
                <input type="hidden" name="section-route" id="section-route" value="">
                <div class="col-12">
                    <label for="name" class="form-label">Do you really want to delete this User <span id="section-name"></span>?</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="delete-section-btn" class="btn btn-primary-report">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
    </div>
</div>
<!-- End Delete Section Modal-->
{{-- Model --}}
<div class="container">
    <!-- Delete Modal -->
    <div class="modal" id="myModal" >
    <div class="modal-dialog modal-md modal-centered">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color:#801214;color: #fff;">
          <h4>Manage Account</h4>
          <button type="button" id="CloseModal" class="close" data-dismiss="modal" >&times;</button>
        </div>
        <form id="manageusers">
            @csrf
        <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <label for="name" class="form-label">User Name </label>
                <input type="text" id="username" name="username" class="form-control" id="main-section-name" value="" disabled>
            </div>
                <div class="col-12">
                    <label for="name" class="form-label">District </label>
                    <select class="form-select" name="district" id="district">
                        @foreach($district as $dis)
                        <option value="{{$dis->Mainkey}}">{{ $dis->Name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label for="name" class="form-label">Church </label>
                    <select class="form-select" name="churchdistrict" id="churchdistrict">
                        <option value=""></option>
                    </select>
                </div>
            <div class="col-12">
                <label for="description" class="form-label">Email</label>
                <input type="text" id="email" name="email" class="form-control" id="main-section-name" value="" >
            </div>
            <div class="col-12">
                <label for="description" class="form-label">Website Role</label>
                <select class="form-select" name="usertype" id="usertype">
                    <option value="Users">Editor</option>
                    <option value="Pastor">Pastor</option>
                    <option value="District">District Staff</option>
                    <option value="Admin">Admin</option>
                    <option value="NationalOffice">National Office</option>
                </select>
            </div>

            <div class="col-12">
                <label for="description" class="form-label">Staff Role</label>
                <select id='staffroles' name="roles[]" class="form-select select" multiple="multiple">
                    <option value='Admin Assistant'>Admin Asst</option>
                    <option value='Alliance Women Leader'>Alliance Women Leader</option>
                    <option value='Annual Report'>Annual Report</option>
                    <option value='Associate Pastor'>Associate Pastor</option>
                    <option value='Board Chairman'>Board Chairman</option>
                    <option value='Care'>Care</option>
                    <option value='Children Leader'>Children Leader</option>
                    <option value='Missions Leader'>Missions Leader</option>
                    <option value='Secretary of Board'>Secretary of Board</option>
                    <option value='Small Groups'>Small Groups</option>
                    <option value='Treasurer'>Treasurer</option>
                    <option value='Vice Chair of Board'>Vice Chair of Board</option>
                    <option value='Young Adult Leader'>Young Adult Leader</option>
                    <option value='Youth Leader'>Youth Leader</option>
                  </select>
            </div>
            <div class="col-12">
                <label for="description" class="form-label">Status</label>
                <select class="form-select" name="status" id="user_status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <div class="col-12">
            <div class="row comment-section" style="display: none;">
              <div class="form-group col-md-12">
                <label for="description" class="form-label">Comments</label>
                <textarea class="form-control" name="comments" id="comment" value="" maxlength="255"></textarea>
                <span class="error-comment" id="error-comment" style="display: none;">Please Enter Comment</span>
              </div>
            </div>
        </div>
         <div class="col-12">
                <label for="description" class="form-label">Generate OTP</label> <span class="btn" id="btn" style="margin-left: -12px;"><i class="fa-solid fa-rotate rotate"></i></span> <span class="copy-clipboard pointer" onclick="copyToClipboard()" ><i class="bi bi-clipboard-check"></i> <span id="copy-label">Copy link</span></span>
            <input type="text" id="otpdata" name="otp" class="form-control" id="main-section-name" value="" required="true" readonly>
            <input type="hidden" id="urldata" value="">
        </div>
            <input type="hidden" value="" name="id" id="id">
            <input type="hidden" value="" name="otp" id="linkdata">
        </div>
        <br>
        <div class="col-12">
            <span style="margin-left: 5px">
            <input class="form-check-input" name="approvestatus" type="checkbox" id="approvestatus" value="Approved">
            <label class="form-label" for="gridCheck">
               Approved
            </label>
            </span>
        </div>

        <br>
        <div class="modal-footer">
          <button class="btn btn-add m-t-15 waves-effect mb-3" id="manageusersupdate" style="background-color: #801214;color:#fff;" >Update</button>
          <button class="btn btn-add m-t-15 waves-effect mb-3" id="closeModal" type="button" style="background-color: #801214;color:#fff;" >
          Cancel</button>
        </div>
        </div>
      </form>
    </div>
    </div>
    </div>
  </div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<!-- datatables scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

<script type="text/javascript">


    // otp generation

$(".rotate").click(function () {
    $(this).toggleClass("down");
})

$(".rotate").on('click',function(){
    var data = {
        'id' : $("#id").val(),
        'findUser' : "Exsisting"
    };
    var url = "{{ url('otpgenerate') }}";
    $.ajax({
        method : "get",
        url: url,
        data : data,
        aysnc:false,
        success: function(response) {
            $("#urldata").val(response.urldata);
            $("#otpdata").val(response.otp);
            $("#linkdata").val(response.otp);
        }
    });
});


// end otp generation
//roll change count

// $("#usertypes").change(function(){
//         var labelText = $("#usertypes option:selected").text();
//         if(labelText != "Select User"){
//         $("span#usercountlabel").html(labelText);

//         console.log(labelText);
//         }
        // triggerAction(labelText);
    // });


$( "#usertypes" ).change(function() {

    var otpdata =  $("#usertypes option:selected").val();
         $.ajax({
            method : "get",
            url: "{{url('getusertypecount')}}",
            data : {
                val : otpdata
            },
            async: false,
            success: function(response) {
             console.log(response);
              $("#usercountspan").text(response);
            }
        });
    });
//roll change count end


function copyToClipboard(element) {

data = $("#urldata").val();
linkdata = $("#linkdata").val(data);
dataencrypt = encryptdata(data);
link = window.location.origin+"/login/"+dataencrypt;
$("#otpdata").val(link).select();
document.execCommand('copy');
var otpdata = {
        'id' : $("#id").val(),
        'otp': data
    };

$.ajax({
        method : "GET",
        url: "{{ url('AnnualReport/Update-otp') }}",
        data : otpdata,
          success: function(response) {
        }
        });
}

function encryptdata(data) {
     urldata = "";

        $.ajax({
            method : "get",
            url: "{{url('encryptdata')}}",
            data : {
                val : data
            },
            async: false,
            success: function(response) {
              urldata = response.urldata;
            }
        });
        return  urldata;
    }

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
        var data = id = {arr};
        var url = "{{ Route('exportXlxs') }}";
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
                var url = "{{asset('files/AnnualReportUserlist.csv')}}";
                a.href = url;
                a.download = 'AnnualReportUserlist.csv';
                document.body.append(a);
                a.click();
                a.remove();
                $("#exportsuccess").removeAttr('style');
            }
        });
    }
     $("#Closesuccess").click(function() {
        $('#exportsuccess').attr('style','display:none');
    });

 // end export

$('.select[multiple]').select2({
        width: '100%',
        closeOnSelect: false
    });

    $("#manageusersupdate").click(function(e) {
        e.preventDefault();
        var formId = 'manageusers';
        var method = 'POST';
        var data = $("#"+formId+"").serializeArray();
        var url = "{{ url('AnnualReport/Update-Users') }}";
        manageusers(data,method,url);
    });
    function deleteuser(id) {
        $('#delete-section').appendTo("body").modal('toggle');
        

    $("#delete-section-btn").click(function(event) {
        event.preventDefault();
     var route = $('#section-route').val();
        // var id = $('#section-id').val();
        var userid = id;
        var method = 'GET';
        var url = "{{ url('AnnualReport/delete-Users') }}";
        deleteusers(method,url,userid);
    });

    }
    $("#closeModal").click(function() {
        $('#myModal').modal('hide');
        $('#manageusers').trigger('reset');
    });

    $(".modal").on("hidden.bs.modal", function() {
      $('#staffroles option[selected="selected"]').removeAttr('selected');
      $('#usertype option[selected="selected"]').removeAttr('selected');
      $('#district option[selected="selected"]').removeAttr('selected');
      $('#churchdistrict option[selected="selected"]').removeAttr('selected');
      $('.comment-section').attr('style','display:none');
    });



    $("#CloseModal").click(function() {
      $('#myModal').modal('hide');
     });

    $('#user_status').on('change',function() {
        let user_status = $('#user_status').val();
        if(user_status == "Inactive"){
            $('#pastorActiveBtn').removeAttr('style');
            $('.comment-section').removeAttr('style');
        }else{
            $('#pastorActiveBtn').removeAttr('style');
            $('.comment-section').attr('style','display:none');
        }
    });

    function deleteusers(method,url,userid){

        $.ajax({
        method : method,
        url: url,
        data : {
                id : userid
            },
          success: function(response) {
            $("#delete-section").modal("hide");
            swal("Success!", ""+response.success+"", "success").then(function(){
                window.location.reload();
            });
        }
        });
    }
    function manageusers(data,method,url){
      $.ajax({
        method : method,
        url: url,
        data : data,
          success: function(response) {

            if(method == 'GET'){

                data = response.data;
                getdismainkey(data["district"],data['churchdistrict']);
                var test = document.getElementById(churchdistrict);
                $('#id').empty().val(data['id']);
                $('#username').empty().val(data['username']);
                $('#district option[value="'+data["district"]+'"]').attr('selected','selected');

                $('#email').empty().val(data['email']);
                $('#usertype option[value="'+data["usertype"]+'"]').attr('selected','selected');
                $('#user_status option[value="'+data["status"]+'"]').attr('selected','selected');
                approved = data['approvestatus'];
                if(approved == 'Approved'){

                    $('#approvestatus').empty().attr('checked', true);
                }else{
                    $('#approvestatus').empty().attr('checked', false);
                }
                $('.rotate').trigger('click');
                const myArray = response.data.roles.split(", ");
                $.each( myArray, function( key, value ) {
                       $('#staffroles option[value="'+value+'"]').attr('selected','selected');
                    });
                    $("#staffroles").select2();
                    $('#otpdata').empty().val(data['otp']);

                if( response.data['status'] == "Inactive")
                {
                    $('.comment-section').removeAttr('style');
                    $('#comment').empty().val(response.data['comments']);
                }
            }else{

                $("#myModal").modal("hide");
                swal("Success!", ""+response.success+"", "success").then(function(){
                window.location.reload();
            });
            }
          }
       });
    }

    $(document).ready(function() {

        // $("#manage-users").DataTable({
        //     aaSorting: [],
        //     "iDisplayLength": 10,
        //     "aLengthMenu": [[10, -1], [10, "All"]],
        //     responsive: true,

        //     columnDefs: [
        //       {
        //         responsivePriority: 1,
        //         targets: 0
        //       },
        //       {
        //         responsivePriority: 2,
        //         targets: -1
        //       }
        //     ]
        // });

    //     $(".dataTables_filter input")
    //     .attr("placeholder", "Search here...")
    //     .css({
    //       width: "300px",
    //       display: "inline-block"
    //     });

    //     $('[data-toggle="tooltip"]').tooltip();
    // });



    var tableMain = $('table#manage-users').DataTable({
        processing: true,
        serverSide: true,
        bFilter: true,
        bInfo: true,
        bPaginate: true,
        ajax: "{{ url('ManageUserslist') }}",
        columns: [
            {data: 'actioncheck', name: 'Actioncheck', orderable: false, searchable: true},
            {data: 'username',orderable: true, searchable: true},
            {data: 'district', orderable: true, searchable: true},
            {data: 'churchdistrict', orderable: true, searchable: true},
            {data: 'usertype', orderable: true, searchable: true},
            {data: 'email', orderable: true, searchable: true},
            {data: 'approvestatus', orderable: true, searchable: true},
            {data: 'Impersonate', orderable: true, searchable: true},
            {data: 'status', orderable: true, searchable: true},
            {data: 'action', name: 'Action', orderable: false, searchable: true},
        ],
        aLengthMenu: [
            [10, 25, -1],
            [10, 25, "All"]
        ],

    });
    $('#manage-users').on('click','.mainsectionedit',function() {
        var data = {'id' : $(this).attr('data-id')};
        var method = 'GET';
        var url = "{{ url('AnnualReport/Get-Users') }}";
        manageusers(data,method,url);
        $('#myModal').appendTo("body").modal('toggle');
    });

    // $("#Approved").click(function(){
    //     var labelText = "Approved";
    //     triggerAction(labelText);
    // });
    
    // $("#usertypes").change(function()
    // {  
    //     var labelText = $("#usertypes option:selected").text(); 
    //     if(labelText != "Select User"){
    //     triggerAction(labelText);
    // }else{
    //     triggerAction('');
 
    // }
    // });

    // $("#Inprogres").click(function(){
    //     var labelText = $("#Inprogres").text();
    //     triggerAction(labelText);
    // });

    // function triggerAction(labelText,){
    //     $(".dataTables_filter input").val(labelText);
    //     tableMain.search(labelText).draw();
    // }

});


    function getdismainkey(value,churchdistrict){

        $.ajax({
            type:"get",
            url:"{{ url('AnnualReport/getdistrict') }}",
            data:{
                'district' : value
            },
            success:function(response){
                 var options = $("#churchdistrict");
                $.each(response, function () {
                    var text = ''+this.ChurchName+', '+this.MailingCity;
                    options.append($("<option />").val(this.ChurchMainkey).text(text));
                });
                $('#churchdistrict option[value="'+churchdistrict+'"]').attr('selected','selected');

            }
        });
    }

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
