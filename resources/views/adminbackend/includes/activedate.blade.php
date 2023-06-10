@extends('adminbackend.layouts.index')
@section('section')
@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;
@endphp
<style>
    .status-active{
        color:green;
    }.status-inactive{
        color:red;
    }.status-notstart{
        color:#ffe000;
    }
    
</style>
<!--Churches Active Dates  -->
<section class="section dashboard">
  <div class="row">
        <!-- Churchlist Section -->
        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                 <div class="filter">
                    <button id="add-active_date" data-bs-toggle="modal" data-bs-target="#active_date"><i class="fas fa-add"></i> Add</button>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Active Dates <span>| End Dates</span></h5>
                    <table class="table table-borderless activedatestable" id="main-active-table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Role</th>
                                <th scope="col">Active Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Year</th>
                                <th scope="col">Status</th> 
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
           <!-- Main Section Modal -->
       <div class="modal fade active_date" id="active_date" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="active_date-form">
                        @csrf
                        <input type="hidden" name="id" id="active-date-id" value="">
                        <input type="hidden" name="route" id="active-date-update-route" value="add">
                        <div class="modal-header">
                            <h5 class="modal-title"><span class="update-activedate" style="display:none;">Update</span> Active Date</h5>
                            <button type="button" class="btn-close" id="modalcloseicon" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-6">
                                    <label for="activedate" class="form-label">Active Date <span class="mandatory">*</span></label>
                                    <input type="date" name="ActiveDate" id="ActiveDate" value="" class="form-control">
                                </div>

                                <div class="col-6">
                                    <label for="enddate" class="form-label">End Date <span class="mandatory">*</span></label>
                                    <input type="date" name="EndDate" id="EndDate" value="" class="form-control">
                                </div>
                                <div class="col-">
                                    <label class="form-label">Role<span class="mandatory">*</span></label>
                                    <select class="form-select" id="rolestype" name="Rolestype">
                                        <option value="">Select Role</option>
                                        <option value="Pastor">Pastor</option>
                                        <option value="District">District</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="comments" class="form-label">Comments</label>
                                    <textarea class="form-control" id="active-date-comments" 
                                    name="Comments" value=""></textarea>
                                </div>
                            </div>
                        </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="modalclose">Close</button>
                                <button type="submit" id="add-active_date-btn" class="btn btn-primary-report">Add</button>
                                <button type="submit" id="update-active_date-btn" class="btn btn-primary-report" style="display:none">Update</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>

             <!-- Delete Section Modal -->
        <div class="modal fade section" id="delete-section" tabindex="-1">
            <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form id="delete-section-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"> <span id="delete-header"></span> Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="active-date-id" value="">
                    <input type="hidden" name="route" id="active-date-update-route" value="">
                    <div class="col-12">
                    <label for="name" class="form-label">Do you really want to delete this <span id="section-name"></span>?</label>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="submit" id="delete-section-btn" class="btn btn-primary-report">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modalclose">Close</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    <!-- End Delete Section Modal-->
</section>


<script>


// $('#ActiveDate').datepicker({
//     onSelect: function(dateText, inst){
//         $('#EndDate').datepicker('option', 'minDate', new Date(dateText));
//     },
// });

// $('#EndDate').datepicker({
//     onSelect: function(dateText, inst){
//         $('#ActiveDate').datepicker('option', 'maxDate', new Date(dateText));
//     }
// });


 var today = new Date().toISOString().split('T')[0];
  $("#ActiveDate").change(function(){
  $("#EndDate").prop("min", $(this).val());
  $("#EndDate").val(""); //clear end date input when start date changes
});

// date hide validation
    // $(document).ready(function() {
    //     var today = new Date().toISOString().split('T')[0];
    //     $("#ActiveDate").attr('min', today);
    //     $("#EndDate").attr('min', today);
    // });

    $('.activedatestable').on('click','.activeedit',function() {
       
        $("#active-date-update-route").val('Update');
        $(".update-activedate").removeAttr('style');
        $("#add-active_date-btn").attr('style','display:none');
        $("#update-active_date-btn").removeAttr('style');

        var id = $(this).attr('id');
        var data = $(this).attr('data-id');
        var section = "ActiveSection";
        var url = "{{url('activeedit')}}";
        showsection(url,data,section);
    });



   $('.activedatestable').on('click','.activedatedel',function() {
        $('#active-date-update-route').val($(this).attr('section-id'));
        $('#active-date-id').val($(this).attr('data-id'));
        $("#delete-header").text('Active Date');
        $("#section-name").text('Active Date');
    });

    $("#delete-section-btn").on('click',function (event) {      
        event.preventDefault();
        var route = $('#active-date-update-route').val();
        var id = $('#active-date-id').val();

        if(route == "main"){
            url="{{url('activedatedelete')}}";
        }
        
        deleteSection(id,url);
    });

    function deleteSection(id,url){
        $.ajax({
            type: "get",
            url: url,
            data : {
                id : id
            },
            success: function(response) {
                $("#delete-section").modal("hide");
                activedate.draw();
                if(response.success){
                    swal("Success!", ""+response.success+"", "success");
                }else{
                    swal("Warning!", ""+response.failed+"", "warning");
                }
            }
        });
    }

    var validator =  $("#active_date-form").validate({
        rules: {
            ActiveDate : {
                required: true,
            },
            EndDate : {
                required: true,
            },
            Rolestype : {
                required: true,
            },
        },
        messages : {
            ActiveDate : {
                required: "Please enter the Active Date.",
            },
            EndDate : {
                required: "Please enter the End Date.",
            },
            Rolestype : {
                required: "Select Role.",
            },
        },
        submitHandler: function(form) {
            var thisForm = $(form);
            var formId = thisForm.attr("id");
            var route = $('#active-date-update-route').val();

            if(route == "Update"){
                url = "{{url('activedateupdate')}}";
            }else{
                url = "{{url('activedatestore')}}";
            } 
            ActiveDateModifier(formId,url);
        }
    });


    function ActiveDateModifier(formId,url){
    var formData = $("#"+formId+"").serializeArray();
    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        success: function(response) {
            console.log(response);
            $("#active_date").modal("hide");
            $('#'+formId+'')[0].reset();
            activedate.draw();
            if(response.success){
                swal("Success!", ""+response.success+"", "success");
            }else{
                swal("Warning!", ""+response.warning+"", "warning");
            }
            
        }
    });
    }

// Datatable for Active Dates

 var activedate = $('table#main-active-table').DataTable({
        processing: true,
        serverSide: true,
        bFilter: false, 
        bInfo: false,
        bPaginate: false,
        ajax: "{{ url('activedatedata') }}",
        columns: [
            {data: "id", render: function (data, type, row, meta) {return meta.row + meta.settings._iDisplayStart + 1;}},
            {data: 'Rolestype', name: 'Role',orderable: true, searchable: true},
            
            {data: 'ActiveDate', name: 'Active Date',orderable: true, searchable: true,
                "render": function (data) {
                    var date = new Date(data);
                    var dd = String(date.getDate()).padStart(2, '0');
                    var mm = String(date.getMonth() + 1).padStart(2, '0');
                    var yyyy = date.getFullYear();
                    return (date = mm + '/' + dd + '/' + yyyy);
                }
            },
            {data: 'EndDate', name: 'End Date',orderable: true, searchable: true,
                "render": function (data) {
                    var date = new Date(data);
                    var dd = String(date.getDate()).padStart(2, '0');
                    var mm = String(date.getMonth() + 1).padStart(2, '0');
                    var yyyy = date.getFullYear();
                    return (date = mm + '/' + dd + '/' + yyyy);
                }
            },
            {data: 'Year', name: 'Year',orderable: true, searchable: true},
            {data: 'Status', name: 'Status',orderable: true, searchable: true},
            {data: 'Action', name: 'Action', orderable: false, searchable: true},
        ]
    });

 // edit show
function showsection(url,data,section){
    $.ajax({
        type: "get",
        url: url,
        data: {
            id : data
        },
        success: function(response) {
            console.log(response);
            if(section == "ActiveSection"){
                $("#active-date-id").val(response.data.id);
                $("#ActiveDate").val(response.data.ActiveDate);
                $("#EndDate").val(response.data.EndDate);
                $("#rolestype option[value="+response.data.Rolestype+"]").attr('selected','selected');
                $("#active-date-comments").val(response.data.Comments);
                $("active-date-update-route").val('update');
                if(response.data.Rolestype == "District"){
                    $("#rolestype option[value=Pastor]").remove();
                }else{
                    $("#rolestype option[value=District]").remove();
                }
            }
        }
    })
};

// modal hide
$(".modal").on("hidden.bs.modal", function() {
    $("#active-date-update-route").val('add');
    $(".update-activedate").attr('style','display:none');
    $("#update-active_date-btn").attr('style','display:none');
    $("#add-active_date-btn").removeAttr('style');

    $('#active_date-form')[0].reset();

    $('#active-date-id').val('');
    
    $('.extra').remove();  
    
    validator.resetForm();
    
});

$("#modalcloseicon").click(function() {
    var options = $("#rolestype");
        $('#active_date').modal('hide');
        options.empty().append("<option>Select Role</option>");
        options.append($("<option />").val('District').text('District'));
        options.append($("<option />").val('Pastor').text('Pastor'));
        validator.resetForm();
    });
    $("#modalclose").click(function() {
        var options = $("#rolestype");
        $('#active_date').modal('hide');
        options.empty().append("<option>Select Role</option>");
        options.append($("<option />").val('District').text('District'));
        options.append($("<option />").val('Pastor').text('Pastor'));
        validator.resetForm();
    });
    
    // $('#calendar').datepicker();
</script>

@endsection