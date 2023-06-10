@extends('adminbackend.layouts.index')
@section('section')
@php
if(!empty($question)){
    $questionMainsection = $question->Mainsection;
}else{
    $questionMainsection = "";
}

if(!empty($question)){
    $questionQuesType = $question->Questype;
}else{
    $questionQuesType = "";
}

if(!empty($question)){
    $questionDisableheckbox = $question->disableCheckbox;
}else{
    $questionDisableheckbox = "";
}
@endphp
<style>
    .opertators-button{
        font-weight: 600;
        margin-right: 10px;
        border-style: none;
        background: #e0dfdf;
        color: #000;
        border-radius: 3px;
        padding: 2px 10px 2px 10px;
    }
    .opertators-button:hover{
        background: #801214;
        color: #fff;
    }
    .formula-label{
        float: right;
    }
    .formula-label i{
        padding-right:4px;
    }
    .FormulaIndexlabel{
        font-weight: 600;
        margin: 3px 0 3px 16px;
        border-style: none;
        background: #e0dfdf;
        color: #000;
        border-radius: 3px;
        padding: 2px 10px 2px 10px;
    }
    .FormulaIndexlabel i{
        padding-right:4px;
    } 
    .formularow{
        margin-bottom:10px;
    }
    .notetext{
        border: 1px solid #b9c0cf;
        padding: 10px 22px;
        color: #d53434;
        background-color: #e0dfdf;
    }

</style>
<section class="section dashboard">
    <div class="row">
        <!-- Question -->
        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">{{ request()->is('*/Add-Question') ? 'Add' : '' }}{{ request()->is('*/Edit-Question/*') ? 'Edit' : '' }} Questions Form</h5>
                    @if(request()->is('*/Edit-Question/*'))
                        <input type="text" id="route" value="edit" hidden>
                    @else
                        <input type="text" id="route" value="add" hidden>
                    @endif
                    <!-- Add Questions Form -->
                    <form id="questions-form" class="row g-3">
                        @csrf
                        <input type="text" name="id" id="id" value="{{ $question->id ?? '' }}" hidden>
                        <div class="col-md-6">
                            <label class="form-label">Main section <span class="mandatory">*</span></label>
                            <select id="main-section" class="form-select" name="Mainsection">
                                <option value="">Select Option</option>
                                @foreach($mainsection as $value)
                                <option value="{{$value->Name}}" @if($questionMainsection == $value->Name) selected @endif>{{$value->Name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sub Section <span class="mandatory">*</span></label>
                            <select id="sub-section" class="form-select" name="Subsection">
                                <option value="">Select Option</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Page Section <span class="mandatory">*</span></label>
                            <select id="page-section" class="form-select" name="Pagesection">
                                <option value="">Select Option</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Question Type <span class="mandatory">*</span></label>
                            <select id="ques-type" class="form-select" name="Questype">
                                <option value="">Select Option</option>
                                @foreach($questiontype as $value)
                                    <option value="{{ $value->QuestionType }}" @if($questionQuesType == $value->QuestionType) selected @endif>{{ $value->QuestionType }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <div>
                                <label  class="form-label">Question Text <span class="mandatory">*</span></label>
                                <textarea class="form-control" name="QuestionText" id="questiontext">{!! $question->QuestionText ?? '' !!}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div>
                                <label  class="form-label">Question Label <span class="mandatory">*</span></label>
                                <input type="text" class="form-control" name="QuestionLabel" value="{{$question->QuestionLabel ?? ''}}">
                            </div>
                        </div>
                        <div class="col-12">
                            <label  class="form-label">Question Code <span class="mandatory">*</span></label>
                            @if($question ?? '' != "")
                            <input type="hidden" class="form-control" name="Questioncode" id="Questioncode" value="{{ $question->Questioncode ?? '' }}">
                            @endif
                            <input type="text" class="form-control" name="Questioncode" id="Questioncode" value="{{ $question->Questioncode ?? '' }}" @if($question->Questioncode ?? '' != "") disabled @endif>
                            <input type="text" name="Questioncodeold" hidden value="{{ $question->Questioncode ?? '' }}">
                        </div>
                        <div class="col-12" id="type-formula">
                            <div style="background-color: rgb(240 244 251);border:1px solid rgb(206 212 218);padding:20px">
                                <div class="row">
                                    <div class="col-12">
                                        <label  class="form-label">Formula</label>
                                        <label class="formula-label">
                                            <span class="opertators-button" onclick="formulaenablefield('add')">
                                                <i class="fas fa-plus"></i>Add
                                            </span>
                                            <span class="opertators-button" onclick="formulaenablefield('sub')">
                                                <i class="fas fa-minus"></i>Subtract
                                            </span>
                                            {{-- <span class="opertators-button" onclick="formulaenablefield('Mul')">
                                                <i class="fas fa-xmark"></i>Multiply
                                            </span>
                                            <span class="opertators-button" onclick="formulaenablefield('div')">
                                                <i class="fas fa-divide"></i>Divide
                                            </span> --}}
                                        </label>
                                    </div>
                                    <center>
                                        <div class="col-12 notetext">
                                            <span>
                                                <label>* Note:</label><label>Click on operations button enable the fields of your operations made formula</label>
                                            </span>
                                        </div>
                                    </center>
                                </div>
                                <br>
                                <div class="row formularow" id="formula-add">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-2">
                                                <label class="FormulaIndexlabel"><i class="fas fa-plus"></i>Add</label>
                                            </div>
                                            <div class="col-10">
                                                <select id='formulaAdd' name="formulaAdd[]" class="form-select select" multiple="multiple">
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row formularow" id="formula-substract">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-2">
                                                <label class="FormulaIndexlabel"><i class="fas fa-minus"></i>Subtract</label>
                                            </div>
                                            <div class="col-10">
                                                <select id='formulaSubstract' name="formulaSubstract[]" class="form-select select" multiple="multiple">
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="type-dropdown">
                            <div class="col-12" id="questypedropdownsection">
                                <label  class="form-label">Dropdown Options <span class="mandatory">*</span></label>
                                <table class="table table-bordered questypedropdowntable">
                                    <tr>
                                        <th>Options</th>
                                        <th>Action</th>
                                    </tr>
                                    <tbody id="optionsAddRemove" class="QuesdropdownOptionTable">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <input type="text" name="QuesdropdownOption[]" placeholder="Enter Option" id="QuesdropdownOption" class="form-control QuesdropdownOption" onchange="Addoptionnew(this.id)"/>
                                            </td>
                                            <td>
                                                <button type="button" name="add" id="option-ar" class="btn btn-outline-primary">Add Option</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-12" id="checkboxfield">
                            <div id="questypecheckboxsection">
                                <label  class="form-label">Checkbox <span class="mandatory">*</span></label>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Action</th>
                                    </tr>
                                    <tbody id="checkboxAddRemove">
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <input type="text" name="QuesCheckboxName[]" id="QuesCheckboxName" placeholder="Enter Name" class="form-control QuesCheckboxName" />
                                            </td>
                                            <td>
                                                <input type="text" name="QuesCheckboxCode[]" id="QuesCheckboxCode" placeholder="Enter Code" class="form-control QuesCheckboxCode" />
                                            </td>
                                            <td>
                                                <button type="button" name="add" id="checkbox-ar" class="btn btn-outline-primary">Add Checkbox</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-12" id="percentfield">
                            <div id="questypepercentsection">
                                <label class="form-label">Add Dropdown Name<span class="mandatory">*</span></label>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                    <tbody id="percentAddRemove">
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <input type="text" name="QuespercentName[]" id="QuespercentName" placeholder="Enter Name" class="form-control QuespercentName" />
                                            </td>
                                            <td>
                                                <button type="button" name="add" id="percent-ar" class="btn btn-outline-primary">Add Dropdown</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-12" id="multidropdownfield">
                            <div id="questypemultidropdownsection">
                                <label class="form-label">Add Dropdown Name<span class="mandatory">*</span></label>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                    <tbody id="multidropdownAddRemove">
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <input type="text" name="QuesmultidropdownName[]" id="QuesmultidropdownName" placeholder="Enter Name" class="form-control QuesmultidropdownName" />
                                            </td>
                                            <td>
                                                <button type="button" name="add" id="multidropdown-ar" class="btn btn-outline-primary">Add Dropdown</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-12">
                                <label  class="form-label">Button Name <span class="mandatory">*</span></label>
                                <input type="text" class="form-control" name="QuestioncodeName" value="{{ $question->QuestioncodeName ?? ''}}">
                            </div>
                        </div>
                        <div class="col-6">
                            <label  class="form-label">Parent Question </label>
                            <select name="ParentQuestion" id="parent-question" class="form-select">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-6 ParentQuestionAns" style="display: none">
                            <label  class="form-label">Parent Answer </label>
                            <select name="ParentQuestionAns" id="parent-question-ans" class="form-select" style="display: none">
                                <option value=""></option>
                            </select>
                            <input class="form-control" type="text" name="ParentQuestionAns" id="parent-question-ans" value="{{ $question->ParentQuestionAns ?? ''}}" style="display: none">
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                            <input class="form-check-input"  name="disableCheckbox" type="checkbox" id="gridCheck" value="Y" @if($questionDisableheckbox == "Y") checked @endif>
                            <label class="form-check-label" for="gridCheck">
                                Disable the Field
                            </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="inputAddress2" class="form-label">Question Assistant Text <span class="mandatory">*</span></label>
                            <Textarea class="form-control" name="QuesAsstext" id="quesasstext">{!! $question->QuesAsstext ?? '' !!}</Textarea>
                        </div>
                        <div class="col-12">
                            <label for="inputAddress2" class="form-label">Question Help Text <span class="mandatory">*</span></label>
                            <Textarea class="form-control" name="Queshelptext" id="queshelptext">{!! $question->Queshelptext ?? '' !!}</Textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                            <input class="form-check-input" name="Quescheckbox" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Active / Inactive
                            </label>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary-question">Submit</button>
                            <button class="btn btn-secondary" id="Close-add-question">Close</button>
                        </div>
                    </form>
                    <!-- End Add Questions Form -->
                </div>
            </div>
        </div>
        <!-- End Questions -->
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script>


// Enable Ckeditor
ClassicEditor.create( document.querySelector( '#questiontext' ),{
    toolbar: [ 'heading','bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList']
});
ClassicEditor.create( document.querySelector( '#quesasstext' ),{
    toolbar: [ 'heading','bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList']
});
ClassicEditor.create( document.querySelector( '#queshelptext' ),{
    toolbar: [ 'heading','bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList']
});

// dropdown draging here..

    $( "#optionsAddRemove" ).sortable({

         items: "tr",
         cursor: 'move',
         opacity: 0.6,
         update: function() {
            console.log('draging');
         }
    });

    $( "#checkboxAddRemove" ).sortable({

         items: "tr",
         cursor: 'move',
         opacity: 0.6,
         update: function() {
            console.log('draging');
         }
     });

     $( "#percentAddRemove" ).sortable({

         items: "tr",
         cursor: 'move',
         opacity: 0.6,
         update: function() {
            console.log('draging');
         }
     });
     
    $( "#multidropdownAddRemove" ).sortable({

         items: "tr",
         cursor: 'move',
         opacity: 0.6,
         update: function() {
            console.log('draging');
         }
     });


        $("#formulaAdd").select2();
        $("#formulaSubstract").select2();
        $("#multiply").select2();
        $("#divide").select2();

        $("#formula-add").attr('style',"display:none");
        $("#formula-substract").attr('style',"display:none");
        $("#formula-multiply").attr('style',"display:none");
        $("#formula-divide").attr('style',"display:none");

        // Edit Question dynamic dropdown select
        var mainsection = $('#main-section').val();
        if(mainsection != ""){
            $('#sub-section').empty();
            var val = mainsection;
            var type = "sub";
            getSections(val,type);
        }

        var subsection = "{{ $question->Subsection ?? '' }}";
        if(subsection != ""){
            $('#page-section').empty();
            var val = subsection;
            var type = "page";
            getSections(val,type);
        }

        var Pagesection = "{{ $question->Pagesection ?? '' }}";
        if(Pagesection != ""){
            $('#page-section').empty();
            var val = Pagesection;
            var type = "parent-question";
            getSections(val,type);
            formulaenableQuestions(Pagesection);
        }

        var ParentQuestion = "{{ $question->ParentQuestion ?? '' }}";
        if(ParentQuestion != ""){
            $('#parent-question').empty();
            var val = ParentQuestion;
            var type = "parent-answer";
            getSections(val,type);
        }

        var Questype = "{{ $question->Questype ?? '' }}";

        if(Questype != "Dropdown"){
            $("#type-dropdown").attr('style','display:none');
            $("#QuesdropdownOption").prop('disabled', true);
        }
        if(Questype != "Checkbox"){
            $("#checkboxfield").attr('style','display:none');
            $("#QuesCheckboxCode").prop('disabled', true);
            $("#QuesCheckboxName").prop('disabled', true);
        }
        if(Questype != "Percent"){
            $("#percentfield").attr('style','display:none');
            $("#QuespercentName").prop('disabled', true);
        }
        if(Questype != "Multi Dropdown"){
            $("#multidropdownfield").attr('style','display:none');
            $("#QuesmultidropdownName").prop('disabled', true);
        }

        if(Questype != "Formula"){
            $("#type-formula").attr('style','display:none');
        }

        var QuesdropdownOption = "{{ $question->QuesdropdownOption ?? '' }}";
        if(QuesdropdownOption != ""){
            $("#subQuestionCheck").removeAttr('disabled');
            const myArray = QuesdropdownOption.split(", ");
            $.each( myArray, function( key, value ) {
                $("#optionsAddRemove").append('<tr><td><input type="text" name="QuesdropdownOption[]" id="QuesdropdownOption" placeholder="Enter Option" class="form-control QuesdropdownOption" onchange="Addoptionnew(this.id)" value="'+value+'"/></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>');
            });
            Addoptionnew($("#QuesdropdownOption").attr('id'));
        }

        var QuesCheckbox = "{{ $question->QuesCheckbox ?? '' }}";
        if(QuesCheckbox != ""){
            const myArray = QuesCheckbox.split(", ");
            $.each( myArray, function( key, value ) {
                const val = value.split(":");
                $("#checkboxAddRemove").append('<tr><td><input type="text" name="QuesCheckboxName[]" id="QuesCheckboxName" placeholder="Enter Name" class="form-control" value="'+val[0]+'"/></td><td><input type="text" name="QuesCheckboxCode[]" id="QuesCheckboxCode" placeholder="Enter Code" class="form-control" value="'+val[1]+'"/></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>');
            });
        }

        var QuespercentName = "{{ $question->QuesPercent ?? '' }}";
        if(QuespercentName != ""){
            
            const myArray = QuespercentName.split(", ");
            $.each( myArray, function( key, value ) {
                $("#percentAddRemove").append('<tr><td><input type="text" name="QuespercentName[]" id="QuespercentName" placeholder="Enter Option" class="form-control QuesdropdownOption" onchange="Addoptionnew(this.id)" value="'+value+'"/></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>');
            });
        }

        var Quesmultidropdown = "{{ $question->Quesmultidropdown ?? '' }}";
        if(Quesmultidropdown != ""){
            const myArray = Quesmultidropdown.split(", ");
            $.each( myArray, function( key, value ) {
                $("#multidropdownAddRemove").append('<tr><td><input type="text" name="QuesmultidropdownName[]" id="QuesmultidropdownName" placeholder="Enter Option" class="form-control QuesdropdownOption" onchange="Addoptionnew(this.id)" value="'+value+'"/></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>');
            });
        }

        jQuery.validator.addMethod("noSpace", function(value, element) { 
        return value.indexOf(" ") < 0 && value != ""; 
        }, "No space please and don't leave it empty");
        
        jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
        }, "please enter only Letters"); 

        $("#questions-form").validate({
            ignore: [":disabled"],
            rules: {
                Mainsection : {
                    required: true,
                },
                Subsection : {
                    required: true,
                },
                Pagesection : {
                    required: true,
                },
                Questype : {
                    required: true,
                },
                QuestionLabel : {
                    required: true,
                },
                QuestionText : {
                    required: true,
                },
                Questioncode : {
                    required: true,
                    noSpace: true,
                    remote:{
                        data : {
                            route : $("#route").val()
                        },
                        url:"{{ url('checkQuestioncode') }}",
                        type:"get",
                     },
                },
                QuesAsstext : {
                    required: true,
                },
                Queshelptext : {
                    required: true,
                },
                QuespercentName:{
                    required: true,
                },
                "QuesdropdownOption[]" : {
                    required: true,
                },
                "QuespercentName[]" : {
                    required: true,
                },
                "QuesCheckboxName[]" : {
                    required: true
                },
                "QuesCheckboxCode[]" : {
                    required: true,
                    noSpace: true
                },
                "QuesmultidropdownName[]" : {
                    required: true
                }  
            },
            messages : {
                Mainsection : {
                    required: "Please select Main Section",
                },
                Subsection : {
                    required: "Please select Sub Section",
                },
                Pagesection : {
                    required: "Please select Page Section",
                },
                Questype : {
                    required: "Please select Question Type",
                },
                QuestionText : {
                    required: "Please enter Question Text",
                },
                QuestionLabel:{
                    required: "Please enter Question Label",
                },
                Questioncode : {
                    required: "Please enter Question Code",
                    remote:"Question code has already been taken."
                },
                QuesAsstext : {
                    required: "Please enter Question Assitant Text",
                },
                Queshelptext : {
                    required: "Please enter Question Help Text",
                },
                QuespercentName:{
                    required: "Please enter Options",
                },
                "QuesdropdownOption[]" : {
                    required: "Please enter Dropdown Option",
                },
                "QuespercentName[]" : {
                    required: "Please enter Percent Name",
                },
                "QuesCheckboxName[]" : {
                    required: "Please enter Checkbox Name",
                },
                "QuesCheckboxCode[]" : {
                    required: "Please enter Checkbox Code",
                },
                "QuesmultidropdownName[]" : {
                    required: "Please enter Multi Dropdown Name",
                }
            },
            submitHandler: function(form) {
                var thisForm = $(form);
                var formId = thisForm.attr("id");
                var formData = $("#"+formId+"").serializeArray();
                var route = $('#route').val();
                if(route == "edit"){
                    url = "{{ url('QuestionUpdate') }}";
                }else{
                    url = "{{ url('QuestionStore') }}";
                }
                $.ajax({
                    type: "post",
                    url: url,
                    data: formData,
                    success: function(response) {
                        swal("Success!", ""+response.Success+"", "success").then(okay => {
                            if (okay) {
                                window.location.href = "{{url('/AnnualReport/Admin-Dashboard/Questions')}}";
                            }
                        });
                    }
                });
            }
        });

        

        
        $("#Close-add-question").on('click',function(){
            window.location.href = "{{url('/AnnualReport/Admin-Dashboard/Questions')}}";
        });

        $("#main-section").on('change',function(){
            $('#sub-section').empty();
            var val = $(this).val();
            var type = "sub";
            getSections(val,type);
        });

        $("#sub-section").on('change',function(){
            $('#page-section').empty();
            var val = $(this).val();
            var type = "page";
            getSections(val,type);
        });

        $("#page-section").on('change',function(){
            $('#parent-question').empty();
            var val = $(this).val();
            var type = "parent-question";
            getSections(val,type);
            formulaenableQuestions(val);
        });

        $("#parent-question").on('change',function(){
            $('#parent-question-ans').empty();
            var val = $(this).val();
            var type = "parent-answer";
            getSections(val,type);
        });


        $("#ques-type").on('change',function(){
            
            var type = $(this).val();

            $("#type-dropdown").attr('style','display:none');
            $("#checkboxfield").attr('style','display:none');
            $("#percentfield").attr('style','display:none');
            $("#multidropdownfield").attr('style','display:none');

            $("#QuesmultidropdownName").prop('disabled', true);
            $("#QuespercentName").prop('disabled', true);
            $("#QuesCheckboxCode").prop('disabled', true);
            $("#QuesCheckboxName").prop('disabled', true);
            $("#QuesdropdownOption").prop('disabled', true);

            if(type == "Dropdown"){
                $("#type-dropdown").removeAttr('style');
                $("#QuesdropdownOption").prop('disabled', false);
            }
            if(type == "Checkbox"){
                $("#checkboxfield").removeAttr('style');
                $("#QuesCheckboxCode").prop('disabled', false);
                $("#QuesCheckboxName").prop('disabled', false);
            }
            if(type == "Percent"){
                $("#percentfield").removeAttr('style');
                $("#QuespercentName").prop('disabled', false);
            }

            if(type == "Multi Dropdown"){
                $("#multidropdownfield").removeAttr('style');
                $("#QuesmultidropdownName").prop('disabled', false);
            }

            if(type == "Formula"){
                $("#type-formula").removeAttr('style');
            }
            
        });

        $("#option-ar").click(function () {
            var dataget = $("tfoot #QuesdropdownOption").val();
            if(dataget != ""){
                data = dataget;
            }else{
                data = "";
            }
            $("tfoot #QuesdropdownOption").val('');
            $("#optionsAddRemove").append('<tr><td><input type="text" name="QuesdropdownOption[]" id="QuesdropdownOption" placeholder="Enter Option" class="form-control QuesdropdownOption" value="'+data+'" onchange="Addoptionnew(this.id)"/></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>');
        });

        $("#checkbox-ar").click(function () {
            var dataget = $("tfoot #QuesCheckboxName").val();
            var datacode = $("tfoot #QuesCheckboxCode").val();
            if(dataget != ""){
                data = dataget;
            }else{
                data = "";
            }
            if(dataget != ""){
                dataC = datacode;
            }else{
                dataC = "";
            }
            $("tfoot #QuesCheckboxName").val('');
            $("tfoot #QuesCheckboxCode").val('');

            $("#checkboxAddRemove").append('<tr><td><input type="text" name="QuesCheckboxName[]" id="QuesCheckboxName" placeholder="Enter Name" class="form-control" value="'+data+'"/></td><td><input type="text" name="QuesCheckboxCode[]" id="QuesCheckboxCode" placeholder="Enter Code" class="form-control" value="'+dataC+'"/></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>');
        });

        $("#percent-ar").click(function () {
            var dataget = $("tfoot #QuespercentName").val();
            if(dataget != ""){
                data = dataget;
            }else{
                data = "";
            }
            $("tfoot #QuespercentName").val('');
            $("#percentAddRemove").append('<tr><td><input type="text" name="QuespercentName[]" id="QuespercentName" placeholder="Enter Name" class="form-control" value="'+data+'"/></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>');
        });

        $("#multidropdown-ar").click(function () {
            var dataget = $("tfoot #QuesmultidropdownName").val();
            if(dataget != ""){
                data = dataget;
            }else{
                data = "";
            }
            $("tfoot #QuesmultidropdownName").val('');
            $("#multidropdownAddRemove").append('<tr><td><input type="text" name="QuesmultidropdownName[]" id="QuesmultidropdownName" placeholder="Enter Name" class="form-control" value="'+data+'"/></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>');
        });

        $(document).on('click', '.remove-input-field', function () {
            $(this).parents('tr').remove();
            $("#QuesdropdownOption").attr('id');
            Addoptionnew($("#QuesdropdownOption").attr('id'));
        });

        function getSections(val,type){
            $.ajax({
                type: "get",
                url: "{{ url('getsection') }}",
                data:{
                    val : val,
                    type : type
                },
                success: function(response) {
                    var options = $("#"+response.sectionId+"");
                    options.append($("<option />").val('').text('Select Option'));
                    $.each(response.data, function () {
                        if(response.name == 'QuestionLabel'){
                            options.append($("<option />").val(this.id).text(this.QuestionLabel));
                        }else if(response.name == 'ParentAnswer'){
                            if(this.Questype == "Text"){
                                $('.ParentQuestionAns').removeAttr('style');
                                $("select#"+response.sectionId+"").attr('style','display:none').attr('disabled','disabled');
                                $("input#"+response.sectionId+"").removeAttr('style').removeAttr('disabled');
                            }   $("input#"+response.sectionId+"").removeAttr('onkeypress')
                            if(this.Questype == "Numeric"){
                                $('.ParentQuestionAns').removeAttr('style');
                                $("select#"+response.sectionId+"").attr('style','display:none').attr('disabled','disabled');
                                $("input#"+response.sectionId+"").removeAttr('style').removeAttr('disabled');
                            }
                            if(this.Questype == "Dropdown"){
                                $('.ParentQuestionAns').removeAttr('style');
                                $("input#"+response.sectionId+"").attr('style','display:none').attr('disabled','disabled');
                                $("select#"+response.sectionId+"").removeAttr('style').removeAttr('disabled');
                                var data = this.QuesdropdownOption.split(", ");
                                $.each(data, function () {
                                    options.append($("<option />").val(this).text(this));
                                });
                            }
                        }else{
                            options.append($("<option />").val(this.Name).text(this.Name));
                        }
                    });
                    let valSubsection = streplace("{{$question->Subsection ?? ''}}");
                    let valPagesection = streplace("{{$question->Pagesection ?? ''}}");
                    $('#sub-section option[value="'+valSubsection+'"]').attr('selected','selected');
                    $('#page-section option[value="'+valPagesection+'"]').attr('selected','selected');
                    $('#parent-question option[value="{{$question->ParentQuestion ?? ''}}"]').attr('selected','selected');
                    $('#parent-question-ans option[value="{{$question->ParentQuestionAns ?? ''}}"]').attr('selected','selected');
                }
    
            });
        }

        function streplace(data){
            let result = data.replace("&amp;", "&");
            return result;
        }

        // function isNumberKey(){
        //     if(event.keyCode > 31 && (event.keyCode < 48 || event.keyCode > 57)){
        //         alert('Please enter only numbers');
        //         return false;
        //     }
        // }

        function Addoptionnew(i){
            data = $("input[name='"+i+"[]']").map(function(){
                return $(this).val();
            }).get();
            var specialoptions = $("#sub-option-question");
            if(data != ""){
                specialoptions.empty();
                specialoptions.append( $("<option />").val('').text('Select Option'));
                $.each(data, function () {
                    if(this != ""){
                        specialoptions.append($("<option />").val(this).text(this));
                    }
                });
                $("#subQuestionCheck").removeAttr('disabled');
                $('#sub-option-question option[value="{{$question->SuboptionQuestion ?? ''}}"]').attr('selected','selected');
            }else{
                $("#subQuestionCheck").attr('disabled','disabled');
                $("#add-sub-question").attr('style','display:none');
            }
        }

        function formulaenablefield(data){

            var operator = data;
            if(operator == 'add'){
                $("#formula-add").removeAttr('style');
            }else if(operator == 'sub'){
                $("#formula-substract").removeAttr('style');
            }
            // else if(operator == 'Mul'){
            //     $("#formula-multiply").removeAttr('style');
            // }else if(operator == 'div'){
            //     $("#formula-divide").removeAttr('style');
            // }

        }

        function formulaenableQuestions(Pagesection){
            $.ajax({
                type: "get",
                url: "{{ url('formulaenableQuestions') }}",
                data:{
                    val : Pagesection
                },
                success: function(response) {
                    data = response.Questions;
                    var Add = $("#formulaAdd");
                    var Sub = $("#formulaSubstract");
                    $.each(data, function () {
                        Add.append("<option value='"+this.Questioncode+"'>"+this.QuestionLabel+"</option>");
                        Sub.append("<option value='"+this.Questioncode+"'>"+this.QuestionLabel+"</option>");
                    });
                    var QuesFormula = "{{ $question->Formula ?? '' }}";
                    if(QuesFormula != ""){
                        arrdata = [];
                        const myArray = QuesFormula.split(";");
                        $.each( myArray, function(key, value) {
                            const  Array = value.split(":");
                        arOperation = Array[0];
                            if(arOperation == "Add"){
                                $("#formula-add").removeAttr('style');
                            }
                            if(arOperation == "Sub"){
                                $("#formula-substract").removeAttr('style');
                            }
                            ar = Array[1];
                            const  arrCode = ar.split(",");
                            $.each( arrCode , function(keyval , val) {
                                if(arOperation == "Add"){
                                    $("#formulaAdd option[value="+val+"]").attr('selected','selected');
                                    $("#formulaSubstract option[value="+val+"]").remove();
                                }
                                if(arOperation == "Sub"){
                                    $("#formulaSubstract option[value="+val+"]").attr('selected','selected');
                                    $("#formulaAdd option[value="+val+"]").remove();
                                }
                            });
                        });
                    }
                }
            });
        }
        

        $("#formulaAdd").on('change',function(){
        $rmdata = $(this).val();
            $.each($rmdata, function () {
                $("#formulaSubstract option[value='"+this+"']").remove();
            });
        });

        $("#formulaSubstract").on('change',function(){
        $rmdata = $(this).val();
            $.each($rmdata, function () {
                $("#formulaAdd option[value='"+this+"']").remove();
            });
        });

    
</script>
@endsection
