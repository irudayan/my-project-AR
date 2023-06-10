@extends('adminbackend.layouts.index')
@section('section')
@php
use App\Helpers\ARHelper;
@endphp

<section class="section dashboard">
    @if(Session::has('successMsg'))
        <div class="alert alert-success"> {{ Session::get('successMsg') }}</div>
    @endif
    <div class="row">
        <!-- Question -->
        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                <div class="filter">
                    <button id="add-question"><i class="fas fa-add"></i> Add</button>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Questions <span>| Church Report</span></h5>
                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th scope="col">Mainsection</th>
                                <th scope="col">Subsection</th>
                                <th scope="col">Pagesection</th>
                                 <th scope="col">Question Code</th>
                                <th scope="col">Question Text</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Questions as $value)
                            <tr id="row{{ $value->id }}">
                                <td>{{$value->Mainsection}}</td>
                                <td>{{$value->Subsection}}</td>
                                <td>{{$value->Pagesection}}</td>
                                <td>{{$value->Questioncode}}</td>
                                <td>{!! $value->QuestionText !!}</td>
                                <td>
                                    <a href="{{url('/AnnualReport/Admin-Dashboard/Edit-Question/'.ARHelper::encryptUrl($value->id))}}"><i class="fas fa-edit"></i></a>&nbsp;
                                    {{-- <a href=""><i class="fas fa-eye"></i></a> --}}
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#main-section" data-toggle="tooltip" class="Quesdel"  id="Quesdel{{ $value->id }}"  data-id="{{ $value->id }}" data-original-title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Vertically centered Modal Delete -->
            <div class="modal fade" id="main-section" tabindex="-1">
                <div class="modal-dialog">
                <div class="modal-content">
                    <form id="delete-question-form">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Question</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="deleteQuesId" id="deleteQuesId" value="">
                            <div class="col-12">
                                <label for="" class="form-label">Do you really want to delete this Question?</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="delete-question" class="btn btn-primary-report">Delete</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        <!-- End Vertically centered Modal Delete-->
        <!-- End Questions -->
    </div>
</section>
<script> 
$( document ).ready(function() {
    $(".dataTable-selector").append($('<option>', { value : 50 }).text(50));
    $(".dataTable-selector").append($('<option>', { value : 100 }).text(100));
   $(".dataTable-selector").append($('<option>', { value : -1 }).text('All'));

});

    $("#add-question").on('click',function(){
        window.location.assign("{{url('/AnnualReport/Admin-Dashboard/Add-Question')}}");
    });

    $('.table').on('click','.Quesdel',function() {
        dataID = $(this).attr('data-id');
        $("#deleteQuesId").val(dataID);
    });

    $("#delete-question").on('click',function (event) {
        var formData = {
            id: $("#deleteQuesId").val()
        };

        $.ajax({
        type: "get",
        url: "{{url('deleteQuestion')}}",
        data: formData,
        dataType: "json",
        encode: true,
        }).done(function (response) {
            $("#main-section").modal("hide");
            $("#row"+response.rowid).remove();
            swal("Success!", ""+response.data+"", "success");
        });
    });

</script>
@endsection