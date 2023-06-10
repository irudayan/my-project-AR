@extends('adminbackend.layouts.index')
@section('section')
@php
use App\Helpers\ARHelper;
use App\Models\Questions;

$i=0;
$j=0;
@endphp

<section class="section dashboard">
    @if(Session::has('successMsg'))
        <div class="alert alert-success"> {{ Session::get('successMsg') }}</div>
    @endif
    <div class="row">
        <!-- Question -->
        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                {{-- <div class="filter">
                    <button id="add-question"><i class="fas fa-add"></i> Add</button>
                </div> --}}
                <div class="card-body">
                    <h5 class="card-title">Questions <span>| Rearrange Position</span></h5>
                    <table class="table table-borderless maincontenttable">
                        <tbody style="background-color:#f5f5f5">
                            @foreach($Pagesection as $value)
                                @php
                                    $i++;
                                    $questions = Questions::where('Pagesection',$value->Name)->orderBy('Position','ASC')->get();
                                @endphp
                                <tr class="maincontent" style="border:1px solid #c4c4c4" data-id="{{$value->id}}" data-row-id="{{$i}}">
                                    <td>
                                        <table class="table subcontenttable">
                                            <thead style="background-color:#dce5f7;">
                                                <th colspan="2">{{ $value->Name }} <i class="fas fa-up-down-left-right orederby" id="table1" style="float:right;padding-top:4px"></i></th>
                                            </thead>
                                            <tbody style="background-color:#fff;">
                                                @foreach($questions as $val)
                                                    @php $j++; @endphp
                                                    <tr class="subcontent" data-id="{{$val->id}}" data-row-id="{{$j}}">
                                                        <td>{!! $val->QuestionText !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
                    <form id="delete-question-fz`orm">
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
  
    $(".maincontenttable").sortable({
        items : "tr.maincontent",
        cursor : 'move',
        opacity : 0.6,
        update : function() {
            url = "{{ url('updatepagesectionposition') }}";
            updatePostOrder(url,'maincontent');
        }
    });

    $(".subcontenttable").sortable({
        items: "tr.subcontent",
        cursor: 'move',
        opacity: 0.6,
        update : function() {
            url = "{{ url('updateQuestionposition') }}";
            updatePostOrder(url,'subcontent');
        }
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


    function updatePostOrder(url,row){
        var Position = [];
        var token = $('meta[name="csrf-token"]').attr('content');
        $('tr.'+row).each(function(index, element) {
            Position.push({
                id: $(this).attr('data-id'),
                Position: index
            });
        });
        console.log(Position);
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

</script>
@endsection