@extends('adminbackend.layouts.index')
@section('section')
@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;
@endphp
<section class="section dashboard">
    <div class="row">
        <!-- Main Section -->
        <div class="col-lg-8 col-md-8 col-xs-8">
            <div class="card recent-sales overflow-auto">
                <div class="filter">
                    <button id="add-main-section" data-bs-toggle="modal" data-bs-target="#main-section"><i class="fas fa-add"></i> Add</button>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Main Section<span>| Church Report</span></h5>
                    <table class="table table-borderless mainsectiontable" id="main-section-table" style="width: 100%">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Section Title</th>
                                {{-- <th scope="col">Description</th> --}}
                                <th scope="col">Action</th>
                            </tr>
                        </thead >
                        <tbody>
                        </tbody> 
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-xs-4">
            <div class="card recent-sales overflow-auto">
                <div class="filter">
                  <!--   <button id="subadd-main-section" data-bs-toggle="modal" data-bs-target="#main-section"><i class="fas fa-add"></i> Add</button> -->
                </div>
                <div class="card-body">
                    <h5 class="card-title">Main Section <span>|  Position</span>&nbsp;<span data-toggle="tooltip" data-placement="top" data-html="true" title="You can drag the Main Section"><i class="fas fa-circle-info"></i></span>
                       </h5>
                    <table class="table table-borderless mainsectionsubtable" id="main-section-tables" style="width: 100%">
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Section Title</th>
                                
                            </tr>
                        </thead >
                        <tbody id="maincontent">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Main Section Modal -->
            <div class="modal fade main-section" id="main-section" tabindex="-1">
                <div class="modal-dialog">
                <div class="modal-content">
                    <form id="main-section-form">
                        @csrf
                        <input type="hidden" name="id" id="main-section-id">
                        <input type="hidden" name="oldName" id="main-section-oldName">
                        <input type="hidden" name="main-section-route" id="main-section-route" value="add">
                        <div class="modal-header">
                            <h5 class="modal-title"><span class="update-main" style="display:none;">Update</span> Main Section</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">
                                <label for="name" class="form-label">Section Name <span class="mandatory">*</span></label>
                                <input type="text" name="Name" class="form-control" id="main-section-name" value="">
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="main-section-description" name="Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="add-main-section-btn" class="btn btn-primary-report">Add</button>
                            <button type="submit" id="update-main-section-btn" class="btn btn-primary-report" style="display:none">Update</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        <!-- End Main Section Modal-->
        <!-- End Main Section -->
        <!-- Sub Section -->
        <div class="col-lg-8 col-md-8 col-xs-8">
            <div class="card recent-sales overflow-auto">
                <div class="filter">
                    <button id="add-sub-section" data-bs-toggle="modal" data-bs-target="#sub-section"><i class="fas fa-add"></i> Add</button>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Sub Section <span>| Church Report</span></h5>
                    <table class="table table-borderless subsectiontable" id="sub-section-table" style="width: 100%">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Main section</th>
                            <th scope="col">Name</th>
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
<!-- drag sub section -->
        <div class="col-lg-4 col-md-4 col-xs-4">
            <div class="card recent-sales overflow-auto">
                <div class="filter">
                   
                </div>
                <div class="card-body">
                    <h5 class="card-title">Sub Section <span>|  Position</span>&nbsp;<span data-toggle="tooltip" data-placement="top" data-html="true" title="You can drag the Sub Section"  ><i class="fas fa-circle-info"></i></span></h5>
                    <table class="table table-borderless" id="subsectionposition" style="width: 100%">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Main Section</th>
                            <th scope="col">Name</th>
                        </tr>
                    </thead>
                    <tbody id="subcontent">
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Vertically centered Modal -->
            <div class="modal fade sub-section" id="sub-section" tabindex="-1">
                <div class="modal-dialog">
                <div class="modal-content">
                    <form id="sub-section-form">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title"><span class="update-sub" style="display: none;">Update</span></span> Sub Section</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="sub-section-id">
                            <input type="hidden" name="oldName" id="sub-section-oldName">
                            <input type="hidden" name="sub-section-route" id="sub-section-route" value="add">
                            <div class="col-12">
                                <label for="main-section" class="form-label">Main Section <span class="mandatory">*</span></label>
                                <select class="form-select" name="MainsectionName" id="sub-section-main-section-name">
                                    <option value="">Select Main Section</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="name" class="form-label">Sub Section Name <span class="mandatory">*</span></label>
                                <input type="text" name="Name" class="form-control" id="sub-section-name" value="">
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="Description" id="sub-section-description">
                                </textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="add-sub-section-btn" class="btn btn-primary-report">Add</button>
                            <button type="submit" id="update-sub-section-btn" class="btn btn-primary-report" style="display:none">Update</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        <!-- End Sub Section Modal-->
        <!-- End Sub Section -->
        <!-- Page Section -->
        <div class="col-lg-12 col-md-12 col-xs-8">
            <div class="card recent-sales overflow-auto">
                <div class="filter">
                    <button id="add-page-section" data-bs-toggle="modal" data-bs-target="#page-section"><i class="fas fa-add"></i> Add</button>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Page Section <span>| Church Report</span></h5>
                    <table class="table table-borderless pagesectiontable" id="page-section-table" style="width: 100%">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Main Section</th>
                            <th scope="col">Sub Section</th>
                            <th scope="col">Name</th>
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
        <!-- Page Section Modal -->
            <div class="modal fade page-section" id="page-section" tabindex="-1">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="page-section-form">
                        @csrf
                        <input type="hidden" name="oldName" id="page-section-oldName">
                        <div class="modal-header">
                            <h5 class="modal-title"><span class="update-page" style="display: none;">Update</span></span> Page Section</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="page-section-id">
                            <input type="hidden" name="page-section-route" id="page-section-route" value="add">
                            <div class="row">
                                <div class="col-6">
                                    <label for="main-section" class="form-label">Main Section <span class="mandatory">*</span></label>
                                    <select class="form-select" name="MainsectionName" id="page-section-main-section-name">
                                        <option value="">Select Main Section</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="main-section" class="form-label">Sub Section <span class="mandatory">*</span></label>
                                    <select class="form-select" name="SubsectionName" id="page-section-sub-section-name">
                                        <option value="">Select Sub Section</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="name" class="form-label">Page Section Name <span class="mandatory">*</span></label>
                                <input type="text" name="Name" class="form-control" id="page-section-name" value="">
                            </div>
                            <div class="col-12">
                                <div id="addColumnPageSection">
                                    <label  class="form-label">Add Columns</label>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Columns</th>
                                            <th>Action</th>
                                        </tr>
                                        <tbody id="ColumnAddRemove">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>
                                                    <input type="text" name="PagesectionColumn[]" placeholder="Enter Column Name" id="lastrowpageoption" class="form-control" />
                                                </td>
                                                <td>
                                                    <button type="button" name="add" id="column-ar" class="btn btn-outline-primary">Add Column</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="Description" id="page-section-description">
                                </textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="add-page-section-btn" class="btn btn-primary-report">Add</button>
                            <button type="submit" id="update-page-section-btn" class="btn btn-primary-report" style="display:none">Update</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        <!-- End Page Section Modal-->
        <!-- End Page Section -->
        <!-- Delete Section Modal -->
        <div class="modal fade section" id="delete-section" tabindex="-1">
            <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form id="delete-section-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="delete-header"></span> Section Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="section-id" value="">
                        <input type="hidden" name="section-route" id="section-route" value="">
                        <div class="col-12">
                            <label for="name" class="form-label">Do you really want to delete this <span id="section-name"></span>?</label>
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
    </div>
</section>

<script>
    // Main section Positionset
    var mainsectionposition = $('table.mainsectionsubtable').DataTable({
        processing: true,
        serverSide: true,
        bFilter: false,
        bInfo: false,
        bPaginate: false,
        ajax: "{{ url('Mainsectionposition') }}",
        columns: [
             {data: "Id", render: function (data, type, row, meta) {return meta.row + meta.settings._iDisplayStart + 1;}},
           {data: 'Name', orderable: true, searchable: true},
        ],
        createdRow: function (row, data) {
            $(row).addClass('row1');
            $(row).attr('data-id', data.id);
            $(row).attr('data-row-id', data.Position);
        }
    });  
 // sub section Positionset
    var subsectionposition = $('table#subsectionposition').DataTable({
        processing: true,
        serverSide: true,
        bFilter: false,
        bInfo: false,
        bPaginate: false,
        ajax: "{{ url('subsectionposition') }}",
        columns: [
           {data: "Id", render: function (data, type, row, meta) {return meta.row + meta.settings._iDisplayStart + 1;}},
           {data: 'MainsectionName', orderable: true, searchable: true},
           {data: 'Name', orderable: true, searchable: true},
        ],
        createdRow: function (row, data) {
            $(row).addClass('row2');
            $(row).attr('data-id', data.id);
            $(row).attr('data-row-id', data.Position);
        }
    });  

    $( "#ColumnAddRemove" ).sortable({

         items: "tr",
        cursor: 'move',
         opacity: 0.6,
         update: function() {
            // console.log('draging');
         }
     });
 
    var i = 0;
    $("#column-ar").click(function () {
        ++i;
        var dataget = $("#lastrowpageoption").val();
        if(dataget != ""){
            data = dataget;
        }else{
            data = "";
        }
        $("#lastrowpageoption").val('');
        $("#ColumnAddRemove").append('<tr><td><input type="text" name="PagesectionColumn[]" value="'+data+'" placeholder="Enter Column Name" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">3</button></td></tr>');
    });

    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });
    
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });

    $('.mainsectiontable').on('click','.mainsectionedit',function() {
        $("#main-section-route").val('Update');
        $(".update-main").removeAttr('style');
        $("#add-main-section-btn").attr('style','display:none');
        $("#update-main-section-btn").removeAttr('style');
        var id = $(this).attr('id');
        var data = $(this).attr('data-id');
        var section = "MainSection";
        var url = "{{url('mainsectionedit')}}";
        showsection(url,data,section);
    });

    $('.mainsectiontable').on('click','.mainsectiondel',function() {
        $('#section-route').val($(this).attr('section-id'));
        $('#section-id').val($(this).attr('data-id'));
        $("#delete-header").text('Main');
        $("#section-name").text('Main Section');
    });

    $('.subsectiontable').on('click','.subsectiondel',function() {
        $('#section-route').val($(this).attr('section-id'));
        $('#section-id').val($(this).attr('data-id'));
        $("#delete-header").text('Sub');
        $("#section-name").text('Sub Section')
    });

    $('.pagesectiontable').on('click','.Pagesectiondel',function() {
        $('#section-route').val($(this).attr('section-id'));
        $('#section-id').val($(this).attr('data-id'));
        $("#delete-header").text('Page');
        $("#section-name").text('Page Section');
    });


    $("#delete-section-btn").on('click',function (event) {
        
        event.preventDefault();
        var route = $('#section-route').val();
        var id = $('#section-id').val();

        if(route == "main"){
            url="{{url('mainsectiondelete')}}";
        }
        if(route == "sub"){
            url="{{url('subsectiondelete')}}";
        }
        if(route == "page"){
            url="{{url('pagesectiondelete')}}";
        }

        deleteSection(id,url);
    });

    $( "tbody#maincontent" ).sortable({
        items: "tr",
        cursor: 'move',
        opacity: 0.6,
        update: function() {
            url = "{{ url('update-order') }}";
            updatePostOrder(url,'row1');
        }
    });

    $( "tbody#subcontent").sortable({
        items: "tr",
        cursor: 'move',
        opacity: 0.6,
        update: function() {
            url = "{{ url('updatesubsection') }}";
            updatePostOrder(url,'row2');
        }
    });


    $('.subsectiontable').on('click','.subsectionedit',function() {
        $("#sub-section-route").val('Update');
        $(".update-sub").removeAttr('style');
        $("#add-sub-section-btn").attr('style','display:none'); 
        $("#update-sub-section-btn").removeAttr('style');
        var id = $(this).attr('id');
        var data = $(this).attr('data-id');
        var url = "{{url('subsectionedit')}}";
        var section = "SubSection";
        showsection(url,data,section);
    });

    $("#page-section-main-section-name").on('change',function(){
        $('#page-section-sub-section-name').empty().append($("<option />").val('').text('Select Sub Section'));
        var val = $(this).val();
        getsubpagesection(val);
    });

    $('.pagesectiontable').on('click','.pagesectionedit',function() {
        $("#page-section-route").val('Update');
        $(".update-page").removeAttr('style');
        $("#add-page-section-btn").attr('style','display:none'); 
        $("#update-page-section-btn").removeAttr('style');
        var id = $(this).attr('id');
        var data = $(this).attr('data-id');
        getsubpagesection(data);
        var url = "{{url('pagesectionedit')}}";
        var section = "PageSection";
        showsection(url,data,section);
    });

    function showsection(url,data,section){
        $.ajax({
            type: "get",
            url: url,
            data: {
                id : data
            },
            success: function(response) {
                if(section == "MainSection"){
                    $("#main-section-id").val(response.data.id);
                    $("#main-section-name").val(response.data.Name);
                    $("#main-section-oldName").val(response.data.Name);
                    $("#main-section-description").val(response.data.Description);
                }
                if(section == "SubSection"){
                    $("#sub-section-id").val(response.data.id);
                    $("#sub-section-name").val(response.data.Name);
                    $("#sub-section-oldName").val(response.data.Name);
                    $("#sub-section-main-section-name").val(response.data.MainsectionName);
                    $("#sub-section-description").val(response.data.Description);
                }
                if(section == "PageSection"){
                    $("#page-section-id").val(response.data.id);
                    $("#page-section-name").val(response.data.Name);
                    $("#page-section-oldName").val(response.data.Name);
                    $("#page-section-main-section-name").val(response.data.MainsectionName);
                    $("#page-section-sub-section-name").val(response.data.SubsectionName);
                    const myArray = response.data.PagesectionColumn.split(", ");
                    $.each( myArray, function( key, value ) {
                        if(value !=""){
                            $("#ColumnAddRemove").append('<tr class="extra"><td><input type="text" name="PagesectionColumn[]" placeholder="Enter Column Name" class="form-control" value="'+value+'"/></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>');
                        }
                        });
                    $("#").val(response.data.PagesectionColumn);
                    $("#page-section-description").val(response.data.Description);

                }
            }
        });
    }

    $('document').ready(function(){
        
        $('#sub-section').on('show.bs.modal', function(e) {
            var val ="";
            var type = "submain";
            getSection(val,type);
        });

        $('#page-section').on('show.bs.modal', function(e) {
            var val ="";
            var type = "pagemain";
            getSection(val,type);
        });

        $('#page-section-main-section-name').on('change', function() {
            var val = $(this).val();
            var type = "pagesub";
            getSection(val,type);
        });

        $(".modal").on("hidden.bs.modal", function() {

            $("#main-section-route").val('add');
            $("#sub-section-route").val('add');
            $("#page-section-route").val('add');
            
            $("#update-main-section-btn").attr('style','display:none');
            $("#add-main-section-btn").removeAttr('style');

            $("#update-sub-section-btn").attr('style','display:none');
            $("#add-sub-section-btn").removeAttr('style');

            $("#update-page-section-btn").attr('style','display:none');
            $("#add-page-section-btn").removeAttr('style');

            $(".update-main").attr('style','display:none');
            $(".update-sub").attr('style','display:none');
            $(".update-page").attr('style','display:none');

            $('#sub-section-main-section-name').empty().append($("<option />").val('').text('Select Main Section'));
            $('#page-section-main-section-name').empty().append($("<option />").val('').text('Select Main Section'));
            $('#page-section-sub-section-name').empty().append($("<option />").val('').text('Select Sub Section'));

            $('#main-section-form')[0].reset();
            $('#sub-section-form')[0].reset();
            $('#page-section-form')[0].reset();

            $('#main-section-id').val('');
            $('#sub-section-id').val('');
            $('#page-section-id').val('');
            
            $('.extra').remove();
            $("#ColumnAddRemove").empty();
            
        });
        
        $("#main-section-form").validate({
            rules: {
                Name : {
                    required: true,
                }
            },
            messages : {
                Name : {
                    required: "Please enter the Section Name",
                }
            },
            submitHandler: function(form) {
                var thisForm = $(form);
                var formId = thisForm.attr("id");
                var route = $('#main-section-route').val();
                if(route == "Update"){
                    url = "{{url('mainsectionupdate')}}";
                }else{
                    url = "{{url('mainsectionstore')}}";
                }  
                SectionModifier(formId,url);
            }
        });

        $("#sub-section-form").validate({
            rules: {
                Name : {
                    required: true,
                },
                MainsectionName : {
                    required: true,
                }
            },
            messages : {
                Name : {
                    required: "Please enter Sub Section Name",
                },
                MainsectionName : {
                    required: "Please select the Main Section",
                }
            },
            submitHandler: function(form) {
                var thisForm = $(form);
                var formId = thisForm.attr("id");
                var route = $('#sub-section-route').val();
            
                if(route == "Update"){
                    url = "{{url('subsectionupdate')}}";
                }else{
                    url = "{{url('subsectionstore')}}";
                } 
                
                SectionModifier(formId,url);
            }
        });

        $("#page-section-form").validate({
            rules: {
                Name : {
                    required: true,
                },
                MainsectionName : {
                    required: true,
                },
                SubsectionName : {
                    required: true,
                },
                PagesectionColumn:{
                    required: true,
                }
            },
            messages : {
                Name : {
                    required: "Please enter the Page Section Name",
                },
                MainsectionName : {
                    required: "Please select Main Section",
                },
                SubsectionName : {
                    required: "Please select Sub Section",
                },
                PagesectionColumn:{
                    required: "Please add Column Names",
                }
            },
            submitHandler: function(form) {
                var thisForm = $(form);
                var formId = thisForm.attr("id");
                var route = $('#page-section-route').val();
            
                if(route == "Update"){
                    url = "{{url('pagesectionupdate')}}";
                }else{
                    url = "{{url('pagesectionstore')}}";
                } 
                
                SectionModifier(formId,url);
            }
        });
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

                tableMain.draw();
                tableSub.draw();
                tablePage.draw();
                mainsectionposition.draw();
                subsectionposition.draw();
                if(response.success){
                    swal("Success!", ""+response.success+"", "success");
                }else{
                    swal("Warning!", ""+response.failed+"", "warning");
                }
            }
        });
    }

    function updatePostOrder(url,row) {
        var Position = [];
        var token = $('meta[name="csrf-token"]').attr('content');
            $('tr.'+row).each(function(index, element) {
            Position.push({
                id: $(this).attr('data-id'),
                Position: index
            });
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: url,
            data: {
                Position: Position,
                _token: token
            }
        });
    }

    function getSection(val,type){
        $.ajax({
            type: "get",
            url: "{{ url('getsectiondata') }}",
            data : {
                type :  type,
                val : val
            },
            success: function(response) {
                var options = $("#"+response.sectionId+"");
                $.each(response.data, function () {
                    options.append($("<option />").val(this.Name).text(this.Name));
                });
            }
        });
    }

    function getsubpagesection(val){
        $.ajax({
            type: "get",
            url: "{{ url('getpagesubsection') }}",
            data : {
                val : val
            },
            success: function(response) {
                var options = $("#page-section-sub-section-name");
                $.each(response.data, function () {
                    options.append($("<option />").val(this.Name).text(this.Name));
                });
            }
        });
    }

    function SectionModifier(formId,url){
        var formData = $("#"+formId+"").serializeArray();
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            success: function(response) {
                $("#main-section").modal("hide");
                $("#sub-section").modal("hide");
                $("#page-section").modal("hide");
                $('#'+formId+'')[0].reset();
                tableMain.draw();
                tableSub.draw();
                tablePage.draw();
                mainsectionposition.draw();
                subsectionposition.draw();
                swal("Success!", ""+response.success+"", "success");
               
            }
        });
    }

    var tableMain = $('table#main-section-table').DataTable({
        processing: true,
        serverSide: true,
        bFilter: false, 
        bInfo: false,
        bPaginate: false,
        ajax: "{{ url('mainsectiondata') }}",
        columns: [
            {data: "id", render: function (data, type, row, meta) {return meta.row + meta.settings._iDisplayStart + 1;}},
            {data: 'Name', name: 'Section Title',orderable: true, searchable: true},
            // {data: 'Description', name: 'Description',orderable: true, searchable: true},
            {data: 'action', name: 'Action', orderable: false, searchable: true},
        ]
    });


    var tableSub = $('table#sub-section-table').DataTable({
        processing: true,
        serverSide: true,
        bFilter: false, 
        bInfo: false,
        bPaginate: false,
        ajax: "{{ url('subsectiondata') }}",
        columns: [
            {data: "id", render: function (data, type, row, meta) {return meta.row + meta.settings._iDisplayStart + 1;}},
            {data: 'MainsectionName', name: 'Main Section',orderable: true, searchable: true},
            {data: 'Name', name: 'Name',orderable: true, searchable: true},
            // {data: 'Description', name: 'Description',orderable: true, searchable: true},
            {data: 'action', name: 'Action', orderable: false, searchable: true},
        ]
    });

    var tablePage = $('table#page-section-table').DataTable({
        processing: true,
        serverSide: true,
        bFilter: false, 
        bInfo: false,
        bPaginate: false,
        ajax: "{{ url('pagesectiondata') }}",
        columns: [
            {data: "Position", render: function (data, type, row, meta) {return meta.row + meta.settings._iDisplayStart + 1;}},
            {data: 'MainsectionName', name: 'Main Section',orderable: true, searchable: true},
            {data: 'SubsectionName', name: 'Sub Section',orderable: true, searchable: true},
            {data: 'Name', name: 'Name',orderable: true, searchable: true},
            // {data: 'Description', name: 'Description',orderable: true, searchable: true},
            {data: 'action', name: 'Action', orderable: true, searchable: true},
        ],
    });

</script>

@endsection