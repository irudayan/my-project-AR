@extends('adminbackend.layouts.index')
@section('section')
@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;
@endphp
<!--Churches Active Dates  -->
<section class="section dashboard">
  <div class="row">
        <!-- Churchlist Section -->
        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                 <div class="filter">
                    <button id="add-staff-role" data-bs-toggle="modal" data-bs-target="#staff_role"><i class="fas fa-add"></i> Add</button>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Staff Roles <span>| Manage Roles</span></h5>
                    <table class="table table-borderless managestaffrole" id="main-role-table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Role Name</th>
                                {{-- <th scope="col">Description</th> --}}
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Churchlist Section -->
    </div>
    <!-- Add Section Modal -->
    <div class="modal fade staff_role" id="staff_role" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="staff_role_form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Staff Roles</h5>
                        <button type="button" class="btn-close" id="modalcloseicon" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="name" class="form-label">Role Name<span class="mandatory">*</span></label>
                                <input type="text" id="role_name" name="role_name" class="form-control" id="main-section-name" value="">
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="active-date-comments"
                                name="description" value=""></textarea>
                            </div>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="submit" id="add-active_date-btn" class="btn btn-primary-report">Add</button>
                            <button type="button" class="btn btn-secondary" id="modalclose">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Section Modal -->
    <div class="modal fade staff_role" id="edit_staffrole" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="editstaff_role_form" id="editstaff_role_form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Update Staff Roles</h5>
                        <button type="button" class="btn-close" id="editmodalcloseicon" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="name" class="form-label">Role Name<span class="mandatory">*</span></label>
                                <input type="text" id="edit_role_name" name="role_name" class="form-control" value="">
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="edit_description"
                                name="description" value=""></textarea>
                            </div>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="submit" id="update-active_date-btn" class="btn btn-primary-report">Update</button>
                            <button type="button" class="btn btn-secondary" id="editmodalclose">Close</button>
                        </div>
                        <input type="hidden" name="id" id="updatestaff" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Section Modal -->
    <div class="modal fade section delete_staffrole" id="delete_staffrole" tabindex="-1">
        <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="delete-staff-role-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"> <span id="delete-header"></span> Delete</h5>
                    <button type="button" id="modalcloseicon" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="active-date-id" value="">
                    <div class="col-12">
                    <label for="name" class="form-label">Do you really want to delete this <span id="section-name"></span>?</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="delete-section-btn" class="btn btn-primary-report">Delete</button>
                    <button type="button" class="btn btn-secondary" id="delmodelcls" data-bs-dismiss="modalclose">Close</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    <!-- End Delete Section Modal-->

</section>
<script>
// Add Staff Role
   var validator =  $("#staff_role_form").validate({
        rules: {
            role_name : {
                required: true,
                maxlength: 50,
                remote:{
                        url:"{{ url('checkrolename') }}",
                        type:"get",
                     },
            },
        },
        messages : {
            role_name : {
                required: "Please enter the Role Name.",
                maxlength: "role name should be below 50 characters",
                remote:"Role name has already been taken."
            },
        },
        submitHandler: function(form) {
        var data = $("#staff_role_form").serializeArray();
        var method = 'POST';
        var url = "{{ url('AnnualReport/Admin-Dashboard/Add-Staff-Roles') }}";
        Churchstaffrole(data,method,url);
      }
    });

    // Edit Staff Role

    $('.managestaffrole').on('click','.staffroleedit',function() {
        $('#updatestaff').val($(this).attr('data-id'));
        var data = $(this).attr('data-id');
        var section = "ActiveSection";
        var url = "{{url('AnnualReport/Admin-Dashboard/Edit-Staff-Roles')}}";
        showsection(url,data);
    });

    function showsection(url,data){
        $.ajax({
            type: "get",
            url: url,
            data: {
                id : data
            },
            success: function(response) {
                console.log(response.data.role_name);
                $("#edit_role_name").val(response.data.role_name);
                $("#edit_description").val(response.data.description);
            }
        })
    };

    var validator =  $("#editstaff_role_form").validate({
        rules: {
            role_name : {
                required: true,
                maxlength: 50,
                // remote:{
                //         url:"{{ url('checkrolename') }}",
                //         type:"get",
                //      },
            },
        },
        messages : {
            role_name : {
                required: "Please enter the Role Name.",
                maxlength: "role name should be below 50 characters",
                // remote:"Role name has already been taken."
            },
        },
        submitHandler: function(form) {
        var data = $("#editstaff_role_form").serializeArray();
        var method = 'POST';
        var url = "{{ url('AnnualReport/Admin-Dashboard/Update-Staff-Roles') }}";
        Churchstaffrole(data,method,url);
      }
    });

// Delete Staff Role
    $('.managestaffrole').on('click','.staffroledel',function() {
        $('#active-date-id').val($(this).attr('data-id'));
    });

    $("#delete-section-btn").on('click',function (event) {
        event.preventDefault();
        var id = $('#active-date-id').val();
        var data = {'id' : id};
        var method = 'get';
        var url = "{{ url('AnnualReport/Admin-Dashboard/Delete-Staff-Roles') }}";
        Churchstaffrole(data,method,url);
    });


    $("#modalcloseicon").click(function() {
        $('#staff_role').modal('hide');
    });

    $("#modalclose").click(function() {
        $('#staff_role').modal('hide');
    });

    $("#delmodelcls").click(function() {
        $('#delete_staffrole').modal('hide');
    });

    $("#editmodalcloseicon").click(function() {
        $('#edit_staffrole').modal('hide');
    });
    $("#editmodalclose").click(function() {
        $('#edit_staffrole').modal('hide');
    });


    function Churchstaffrole(data,method,url){
    $.ajax({
        type: method,
        url: url,
        data: data,
        success: function(response) {
            if(response.action == "Add"){
                $("#staff_role").modal("hide");
                    swal("Success!", ""+response.success+"", "success").then(function(){
                        window.location.reload();
                     });
            }else if(response.action == 'Delete'){
                $(".delete_staffrole").modal("hide");
                    swal("Success!", ""+response.success+"", "success").then(function(){
                        window.location.reload();
                     });

            }else{
                $(".edit_staffrole").modal("hide");
                    swal("Success!", ""+response.success+"", "success").then(function(){
                        window.location.reload();
                        //staffsroles.draw();
                     });
            }
        }
    });
    }

// Datatable for Active Dates

 var staffsroles = $('table#main-role-table').DataTable({
        processing: true,
        serverSide: true,
        bFilter: true,
        bInfo: true,
        bPaginate: true,
        ajax: "{{ url('showstaffroles') }}",
        columns: [
            {data: "id", render: function (data, type, row, meta) {return meta.row + meta.settings._iDisplayStart + 1;}},
            {data: 'role_name', orderable: true, searchable: true},
            // {data: 'description', orderable: false, searchable: true},
            {data: 'Action', name: 'Action', orderable: true, searchable: true},
        ]
    });
</script>
@endsection
