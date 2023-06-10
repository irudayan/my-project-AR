@extends('backend.layouts.main')
@section('content')
@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;
use App\Models\District;
use App\Models\Mainsection;
use App\Models\Questions;
use Carbon\Carbon;

if(!empty($question)){
    $questionMainsection = $question->Mainsection;
}else{
    $questionMainsection = "";
}
$usertype = Auth::user()->usertype ??'';
$district = District::all();
$districtnameexport = Auth::user()->district ??'';
$mainsection = Mainsection::all();
$year = Carbon::now()->year-1;
if ($usertype == "District") {
    $Getdisname = District::where('Mainkey',$districtnameexport)->first();
    $DSname = $Getdisname['Name']; 
   
    // $DSname = str_replace('&amp;', '&', $DSnameget);
   
}else {
    $DSname = "District All";  
}


@endphp
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
 
    label {
    margin-bottom: 0;
    }
    .row.bar{
        background-color:#801214;
        color:#fff;
    } .align{
            margin: 5px 0px 0px 4px !important;
    }
    .hidedata{
        display:none;
    }
    .minus,
    .add
    { 
        cursor: pointer;
        -webkit-user-select: none; /* Safari */
        -ms-user-select: none; /* IE 10 and IE 11 */
        user-select: none; /* Standard syntax */
    }
</style>
<div class="col-md-12" id="bri_ind_container">
    <div class="php-email-form" >
        <!-- Navbar -->
        <nav id="navbar" class="flexbox profile-nav">
            <!-- Navbar Inner -->
            <div class="navbar-inner view-width flexbox-space-bet">
                <div class="row bar">
                    <label><h4 class="align-middle">Church Export</h4></label>
                </div>
                {{-- input data part --}}
                <form id="churchanswersdata">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12">
                            <div class=" recent-sales overflow-auto">
                            <div class="card-body">
								<div class="alert alert-success " id="exportsuccess" style="display:none">
									Exported Successfully.
									<div style="float:right;margin-top: -5px;">
									<button type="button" id="Closesuccess" class="close" data-dismiss="modal" >&times;</button>
									</div>
									</div>
                                <div class="row">
									<input type="hidden" value="{{ $districtnameexport ?? '' }}" name="Authdistrict" id="Authdistrict">
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12 col-xs-12"><label for="" class="form-label"><b>From Year</b></label>
                                        <select class="form-select startyear"  name="startyear" id="startyear">

                                        </select>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                        <label for="" class="form-label"><b>To Year</b></label>
                                        <select class="form-select endyear"  name="endyear" id="endyear" >
                                    
                                        </select>
                                    </div>
                                   
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                        <label for="" class="form-label"><b>Choose the District</b>  <span style="color:red">*</span></label>
                                        <select class="form-select District" @if($usertype == 'District') disabled @endif  name="District[]" id="District" multiple="multiple" >
                                        <option value="All" @if($usertype != 'District') selected @endif>Select All</option>
                                       
                                            @foreach($district as $value) 
                                        <option value="{{$value->Mainkey}}" dataid="{{$value->Name}}" @if($usertype == 'District')
                                       @if($value->Mainkey == $districtnameexport) selected  @endif  @endif >{{ $value->Name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                        <label for="" class="form-label"><b>Name of the Report</b>  <span style="color:red">*</span></label>
                                        <input type="text" id="Reportname" name="Reportname" class="form-control" id="Reportname" value="" >

                                    </div>
                                    <br><br>   
                                    <table class="table table-borderless research">
                                        <tbody>
                                            @foreach($Mainsection as $value)
                                                @php
                                                    $questions = Questions::where('Mainsection',$value->Name)->get();
                                                @endphp
                                            <tr class="maincontent">
                                                <td>
                                                    <table class="table {{$value->MainSectionCode}}">
                                                        <thead style="background-color:#dce5f7;">
                                                            <tr>    
                                                                <th colspan="2">
                                                                <label  class="add" id="{{$value->MainSectionCode}}" onclick="accortionadd(this)"><i class="fa-solid fa-plus" ></i>  {{ $value->Name }}</label>
                                                                <label  class="minus" onclick="accortionminus(this)" id="{{$value->MainSectionCode}}"><i class="fa-solid fa-minus"></i>  {{ $value->Name }}</label>
                                                                <span style="float:right;padding-top:4px"> 
                                                                <input value ="{!! $value->Name !!}" class="form-check-input {{$value->MainSectionCode}} sectionclass"  checked type="checkbox">
                                                                </span> 
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($questions as $val)
                                                                <tr class="border accordion {{$value->MainSectionCode}}">
                                                                    <td><label>{!! $val->QuestionText !!} </label> - <span id="Quescode" style="color:#a85b5d">( {!! $val->Questioncode !!} )</span> 
                    
                                                                    </td>
                                                                    <td style="width:100px;"><span  style="float:right;padding-bottom:10px"><input class="form-check-input" id="export" data-id="{{$value->MainSectionCode}}" name="questions[]" value="{!!$val->Questioncode !!}" checked type="checkbox" {{-- onchange="exportcheck(this)" --}} > 
                                                                    </span></td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <script>
                                                $(document).ready(function(){
                                                    var $value = "{{$value->MainSectionCode}}";
                                                    autohide($value);
													// var data= $("#export:checked").length;
    												// $("span#exportcount").html("Export (" + data + ")");
                                                }); 

                                                function autohide($research){
                                                    var $search = $('.accordion.'+ $research);
                                                    $search.not('.hidedata').addClass('hidedata');
                                                    $('.add#'+$research).removeClass('hidedata'); 
                                                    $('.minus#'+$research).addClass('hidedata'); 
                                                }
                                            </script>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="text-align: center; display: block;" >  
                            <span id='loader' style='display: none;'>
                            <img src="{{asset('assets/img/gif/ajaxload.gif')}}" width='32px' height='32px' >
                            </span>
                            <button class="btn btn-add m-t-15 waves-effect " id="exportbtn" style="background-color: #801214;color:#fff;" ><i class="mdi mdi-file-excel"> </i> <span id="exportcount">Generate Report</span></button>
                            <a href="/"><button class="btn btn-add m-t-15 waves-effect" id="exportcloseModal" type="button" style="background-color: #801214;color:#fff;" >
                               Cancel</button></a>
                        </div>
                    </div>
                </form>
            </div>
        </nav>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- Validate js Files -->

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
 <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
<script>

   
    $('.District').on("select2:select", function (e) {
        var data = e.params.data.text;
        if(data == 'Select All'){
            $(".District").val('').change();
            $(".District > option[value='All']").prop("selected",true).change();
            $(".District > option").prop("disabled",true);
            $(".District > option[value='All']").prop("disabled",false);
        }
    });

    function districtdata(){ 
        
        var diname ="{{ $DSname }}";
        var districtname = diname.replace("&amp;", "&");
        var startyear= $('#startyear').val();
        var endyear= $('#endyear').val();
      
        $("#Reportname").val(districtname+" "+startyear+"-"+ endyear);
    }

    $("#District").on('change', function(){
        var value = $(this).val();
        var startyear= $('#startyear').val();
        var endyear= $('#endyear').val();
        if(value == ''){
            $("#Reportname").val('');
        }
        if(value[0] == undefined){    
            $(".District > option").prop("disabled",false);
        }
        if(value[0] == 'All'){ 
            $("#Reportname").val("District All"+" "+startyear+"-"+ endyear); 
         }
        var Mainkey = value[0];
       
        $.ajax({
            type:"get",
            url:"{{ url('AnnualReport/getdisname/reportname') }}",
            data:{
            'Mainkey' : Mainkey
            },
            success:function(response){
            $("#Reportname").val(response+" "+startyear+"-"+ endyear);    
            }

         });  
    });

    $("#churchanswersdata").validate({
    rules: {
        'District[]' : {
            required: true,
        },
        'Reportname' : {
            required: true,
        },

    },
    messages : {
        'District[]' : {
            required: "Please Select the District..",
        },
        'Reportname' : {
            required: "Name of the Report is required",
        }
    },
    submitHandler: function(form,e) {
        e.preventDefault();
        var formId = 'churchanswersdata';
        var data = $("#"+formId+"").serializeArray();
        exportCSV(data); 
        
    }
    });
 
    $('#endyear').on('change', function(){
        var startyear= $('#startyear').val();
        var endyear= $('#endyear').val();
        var District= $("#District").val();
        var Districtname= $("#District option[value='"+District[0]+"']").text();
        if (Districtname !='Select All') {
                   $("#Reportname").val(Districtname+" "+startyear+"-"+ endyear);
                }else{
                $("#Reportname").val("District All"+" "+startyear+"-"+ endyear);
                }
     });

    $("#startyear").change(function(){
        var startyear = $(this).val();

        $.ajax({
            type:"get",
            url:"{{ url('AnnualReport/getendyears/export') }}",
            data:{
                'startyear' : startyear
                },
            success:function(response){
                var endyearval = $(".endyear").val();

                var options = $(".endyear");
                options.empty();
                $.each(response, function () {
                    options.append($("<option />").val(this.YearReported).text(this.YearReported));

                });

                var startyearval = $("#startyear").val();
                if (startyearval < endyearval) {
                    $('#endyear option[value="'+endyearval+'"]').attr('selected','selected');   
                }

                var startyear= $('#startyear').val();
                var endyear= $('#endyear').val();
                var District= $("#District").val();
                var Districtname= $("#District option[value='"+District[0]+"']").text();
                
                if (Districtname !='Select All') {
                   $("#Reportname").val(Districtname+" "+startyear+"-"+ endyear);
                }else{
                $("#Reportname").val("District All"+" "+startyear+"-"+ endyear);
                }
            }
        });
    });


    $('.District[multiple]').select2({
        width: '100%',
        closeOnSelect: true, 
    });

    function accortionadd(data){
        $research = $(data).attr('id');
        var $search = $('.accordion.'+ $research);
        $search.removeClass('hidedata');
        $(data).addClass('hidedata');
        $('.minus#'+data.id).removeClass('hidedata');
    }

    function accortionminus(data){
        var $id = data.id;
        var $search = $('.accordion.'+ $id);
            $search.addClass('hidedata');
            $(data).addClass('hidedata');
            $('.add#'+$id).removeClass('hidedata');
    }

    // $('#exportbtn').click(function(e) {
	// 	 e.preventDefault();
    //     var formId = 'churchanswersdata';
    //     var data = $("#"+formId+"").serializeArray();
	
    //     exportCSV(data); 
		
    // });
 

    function exportCSV(data){

        var churchdata = data;

        var url = "{{ Route('churchexportalldataXlxs') }}";
        $.ajax({
            method : "get",
            url: url,
            data : churchdata,
            beforeSend: function(){
                // Show image container
                $("#loader").show();
            },
            success: function(response) {
                $("#loader").hide();
                var start = $("#startyear").val();
                var end = $("#endyear").val();
                var reportname = $("#Reportname").val();
                var districtname ="{{ $DSname }}";
                var Reportdynamic =districtname +' AnnualReport '+start+'-'+end;
                var a = document.createElement('a');
            
                if(reportname !=''){
                    var url = "{{asset('files')}}/"+reportname+'.csv';
                    a.href = url;
                    a.download = reportname+'.csv';
                }else{
                    var url = "{{asset('files')}}/"+Reportdynamic+'.csv';	
                    a.href = url;
                    a.download = Reportdynamic+'.csv';
                }
                
                document.body.append(a);
                a.click();
                a.remove();
                $("#exportsuccess").removeAttr('style').delay(2000).fadeOut();
            }
        });
    }
 
    // year display
    var usertype = "{{$usertype}}";
    var year ="{{ $year }}";
    var curryear ="{{ $year }}";
    $.ajax({
        type:"get",
        url:"{{ url('AnnualReport/getyear/export') }}",
        data:{
            'usertype' : usertype,
            'churchdistrict':churchdistrict
        },
        success:function(response){
            var options = $(".startyear");
            $.each(response, function () {
                options.append($("<option />").val(this.YearReported).text(this.YearReported));
            });

            var endoptions = $(".endyear");
           
            endoptions.append($("<option />").val(curryear).text(curryear));
           
            $('#startyear option[value="'+year+'"]').attr('selected','selected');
            $('#endyear option[value="'+year+'"]').attr('selected','selected');
            districtdata();
        }
    });
    // end year display

    var mainsection = "{{$value->Name}}";
    $(".sectionclass").click(function () {
        
        var check = $(this).prop('checked');
        var val = $(this).val();            
        var numberChecked = $('input:checkbox[data-id="'+val+'"]').not(this).prop('checked', this.checked).length;
        var data= $("#export:checked").length;
        // if(check == true){

        //     $("span#exportcount").html("Export (" + data + ")");
        // }else if(data !=0){
        //     $("span#exportcount").html("Export (" + data + ")");
        // }else{
        // 	$("span#exportcount").html("Export");
        // }

    });

    // function exportcheck(val){
    //     var data= $("#export:checked").length;
    //     if(val.checked){
    //         $("span#exportcount").html("Export (" + data + ")");
    //     }else{
    //     i = 0;
    //     var arr = [];
    //     $('input#export:checked').each(function () {
    //         arr[i++] = $(this).val();
    //         $("span#exportcount").html("Export (" + data + ")");
    //     });
    //         if(arr != 0){
    //             $("span#exportcount").html("Export (" + data + ")");
    //         }else{
    //             $("span#exportcount").html("Export");
    //         }
    //     }
    // }

 </script>  

@endsection
