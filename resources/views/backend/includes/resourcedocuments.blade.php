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
</style>

<div class="col-md-9" id="bri_ind_container">
<div class="php-email-form" >
    <!-- Navbar -->
    <nav id="navbar" class="flexbox profile-nav">
      <!-- Navbar Inner -->
      <div class="navbar-inner view-width flexbox-space-bet">
        <div class="row bar">
            <label class="align-middle">Resource Uploads</label>
        </div>
        <br>
      </div>
    </nav>
    {{-- <div class="col-sm-12" align="right" style="padding-left: 1px !important">
        <span id='loader' style='display: none;'>
                <img src="{{asset('assets/img/gif/ajaxload.gif')}}" width='32px' height='32px' >
        </span>
        <button class="exportbtn" id="exportbtn" data-toggle="tooltip" title="Export to CSV" disabled="disabled"><i class="mdi mdi-file-excel"></i> Export</button>
    </div> --}}

    <div class="row">
        <div class="col-md-12">
            <br>
            <div class="php-email-form">
                <form id="resourcedocs">
                    @csrf
                    <div class="row">
                        
                            <div class="alert alert-success" id="success" style='display: none;'>
                                File Uploaded Successfully.
                            </div>
                            <div class="alert alert-info" id="updatesuccess" style='display: none;'>
                                Updated Successfully.
                            </div>
                            <div class="alert alert-danger" id="deletesuccess" style='display: none;'>
                                File Deleted Successfully.
                            </div>
                            <br>
                        
                        <div class="col-lg-7">
                            <label>Resource Documents</label>
                            <span class="form-control" style="width: 400px;padding:0px">
                                <input type="file" name="resource" id="resource">
                            </span>
                        </div>
                        <div class="col-lg-1" style="padding-top: 10px;">
                            <!-- Image loader -->
                                <label></label>
                                <div id='loader' style='display: none;'>
                                    <img src="{{asset('assets/img/gif/ajaxload.gif')}}" width='32px' height='32px'>
                                </div>
                            <!-- Image loader -->
                        </div>
                        <div class="col-lg-3" style="padding-top: 10px;">
                            <br>
                            <button class="resource">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <br>
            <div class="php-email-form">
                <table id="resourcedocuments" class="table table-hover responsive manageresourcedocuments data-table" style="width:100%">
                    <thead>
                    <tr>
                        <th width="300px">Name</th>
                        <th>Upload Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    {{-- Model --}}
    <div class="container">
        <!-- Modal -->
        <div class="modal" id="myModal" >
        <div class="modal-dialog modal-md modal-centered">
        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header" style="background-color:#801214;color: #fff;">
            <h4>Resource Documents Edit</h4>
            <button type="button" id="CloseModal" class="close" data-dismiss="modal" >&times;</button>
            </div>
            <form id="resourceFileEdit">                                                     
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label>Resource Document Name</label>
                    <span class="form-control">
                        <label id="resource_name"></label> 
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Resource Document Status</label>
                    <input type="hidden" id="active_status_val" value="">
                    <select class="form-select" name="active_status" id="active_status">
                        <option value="Publish">Publish</option>
                        <option value="Unpublish">Unpublish</option>
                    </select>
                </div>
            </div>
            </div>
            <input type="hidden" id="filedataid" name="id" value="">
            <div class="modal-footer">
            <button class="btn btn-add m-t-15 waves-effect mb-3" id="resourceFilesUpdate" style="background-color: #801214;color:#fff;" >Update</button>
            <button class="btn btn-add m-t-15 waves-effect mb-3" id="closeModal" type="button" style="background-color: #801214;color:#fff;" >Close</button>
            </div>
        </form>
        </div>

        </div>
        </div>
    </div>

    <div class="container">
        <!-- Delete Modal -->
        <div class="modal" id="myModalDel" >
        <div class="modal-dialog modal-md modal-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color:#801214;color: #fff;">
            <h4>Delete</h4>
            <button type="button" id="CloseModalDel" class="close" data-dismiss="modal" >&times;</button>
            </div>
            <form id="resourceFileDel">                                                      
            <div class="modal-body">
            <div class="row">
            <div class="form-group col-md-12">
                <label class="label-name" style="font-size:20px">Are you sure you want to delete?</label>
                <input type="hidden" name="id" id="id" value="">
            </div>
            </div>
            <div class="modal-footer">
            <button class="btn btn-add m-t-15 waves-effect mb-3" id="resourceFilesDel" style="background-color: #801214;color:#fff;" >Yes</button>
            <button class="btn btn-add m-t-15 waves-effect mb-3" id="closeModalDel" type="button" style="background-color: #801214;color:#fff;" >
            No</button>
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

<!-- Validate js Files -->  
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
<script type="text/javascript">

    $(document).ready(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var table = $('#resourcedocuments').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('resourcefilesget') }}",
      columns: [
          {data: 'resource',orderable: true, searchable: true},
          {data: 'created_at',orderable: true, searchable: true,
            "render": function (data) {
                var date = new Date(data);
                var month = date.getMonth() + 1;
                return (month.length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear();
            }
          },
          {data: 'active_status',orderable: true, searchable: true},
          {data: 'action', name: 'action', orderable: false, searchable: false},
      ]
    });

    $(".dataTables_filter input")
    .attr("placeholder", "Search here...")
    .css({
      display: "inline-block"
    }); 

    $('[data-toggle="tooltip"]').tooltip();

    $("#resourcedocs").validate({
        rules: {
            resource : {
                required: true,
                extension: "doc|pdf|docx"
            },    
        },
        messages : {
            resource: {
                required: "Please upload a file.",
                extension: "You can upload only pdf,doc,docx extensions files."
            }
        },
        submitHandler: function(form) {
            var resource = $('#resource')[0].files;
            var _token = '{{ csrf_token() }}';
            fileUpload(resource,_token);
        }
    });

    var $checks1 = $('input[type="checkbox"][name="activestatus"]');
      $checks1.click(function() {
         $checks1.not(this).prop("checked", false);
      });

    $("#myBtn").click(function() {
        $('#myModal').appendTo("body").modal('toggle');
    });
    $("#closeModal").click(function() {
        $('#myModal').modal('hide');
    });
    $("#CloseModal").click(function() {
        $('#myModal').modal('hide');
    });

    /*------- myAvailableDel toggle close -------*/

      $("#Del").click(function() {
          $('#myModalDel').appendTo("body").modal('toggle');
      });
      $("#closeModalDel").click(function() {
          $('#myModalDel').modal('hide');
      });
      $("#CloseModalDel").click(function() {
          $('#myModalDel').modal('hide'); 
      });

    /*------- end myAvailableForm toggle close -------*/

    $('.data-table').on('click','.resourcefilesedit',function() { 
        var id = $(this).attr('id');
        var data = $(this).attr('data-id');
        resourceFileview(id,data);
    });

    $('.data-table').on('click','.resourcefilesdel',function() {
        var id = $(this).attr('id');
        var data = $(this).attr('data-id');
        resourceFilesDel(id,data);
    });

    $('#resourceFilesDel').on('click',function(e) {
      e.preventDefault();
        var id = $("#id").val();
        var token = "{{ csrf_token() }}";
        var data = {
          'id' : id,
          "_token": token,
          };
          console.log(data);
        $.ajax({
        method : "get",
        url: "{{ route('destroyresourcefile') }}",
        data : data,
          success: function(response) {
            console.log(response);
            $('#myModalDel').modal('hide');
            $("#deletesuccess").show();
            table.draw();
          }
       });
    });

    $('#resourceFilesUpdate').on('click',function(e) {
      e.preventDefault();
        var id = $("#filedataid").val();
        var token = "{{ csrf_token() }}";
        var active_status = $("#active_status").val();
        var data = {
          'id' : id,
          "_token": token,
          "active_status" : active_status
          };

          resourceFileUpdate(data);
    });

    function resourceFileview(id,data){
        var id = data; // Address
        var data = {'id' : id};
        $.ajax({
        url : "{{Route('resourcefilesview')}}",
        method : "GET",
        data : data,
            success: function(response) {
                console.log(response);
                $( "#filedataid" ).empty().val(response.fileData['id']);
                $( "#resource_name" ).empty().append("<div><label for='resource_name'>"+response.fileData['resource']+"</label></div>");
                if(response.fileData['active_status'] == 'Publish' ){
                    $('#active_status option[value="Publish"]').attr("selected", "selected");
                }else{
                    $('#active_status option[value="Unpublish"]').attr("selected", "selected");
                }
            }
        });
        $('#myModal').appendTo("body").modal('toggle');
    }

    function resourceFileUpdate(data){
        var data = data;
        $.ajax({
        url : "{{Route('resourcefilesupdate')}}",
        method : "post",
        data : data,
            success: function(response) {
                console.log(response);
                $('#myModal').modal('hide');
                $("#updatesuccess").show();
                table.draw();
            }
        });
        $('#myModal').appendTo("body").modal('toggle');
    }

    function resourceFilesDel(id,data){
      var id = data; // Address
      var data = {'id' : id};
      $.ajax({
        method : "GET",
        url: "{{ route('resourcefilesview') }}",
        data : data,
          success: function(response) {
            console.log(response);
            $('#id').empty().val(response.fileData['id']);
          }
       });
      $('#myModalDel').appendTo("body").modal('toggle');
    }

    function fileUpload(files,token){
      var fd = new FormData();
      fd.append('resource',files[0]);
      fd.append('_token',token);
      $.ajax({
        url: "{{ url('ResourceUploadFile') }}",
        method: 'post',
        data:fd,
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend: function(){
            // Show image container
            $("#loader").show();
           },
        success: function(response){
            console.log(response);
            $('#resource').val('');
            table.draw();
        },
        complete:function(response){
            // Hide image container
            $("#loader").hide();
            $("#success").show();
           },
        error: function(response){
          console.log("error : " + JSON.stringify(response) );
        }

      });
    }
});
// Disable Success Message
  function disabledsuccessmsg() {
    setTimeout(function() {
      document.getElementById("success").style.display = "none";
    }, 100);
    setTimeout(function() {
      document.getElementById("deletesuccess").style.display = "none";
    }, 100);
    setTimeout(function() {
      document.getElementById("updatesuccess").style.display = "none";
    }, 100);
  }
  document.getElementById("bri_ind_container").addEventListener("click", disabledsuccessmsg);

</script>
@endsection
