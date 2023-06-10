<!DOCTYPE html>
@php
    use App\Helpers\ARHelper;
    use App\Models\Annualreport;
    use App\Models\District;
    use App\Models\DistrictChurch;
    use Carbon\Carbon;

    $now = Carbon::now();
    $reportYear = $now->year-1;
    $otp = Auth::user()->otp ?? '';
    $otpStatus = Auth::user()->otp_status ??'';
    $segmentlast =last(request()->segments());

    $segments = url()->current();
    $url = explode("/",$segments);
    $segurl = $url[4];
    $urlData = base64_decode($segurl);
    parse_str($urlData, $params);

    $districtname = Auth::user()->district ??'';
    $getuserdistrict =  District::select('Name')->where('Mainkey',$districtname)->first();
   
    $district = District::all();
    $churchdistrictname = Auth::user()->churchdistrict ??'';
    $getuserchurchdistrict = DistrictChurch::select('ChurchName')->where('ChurchMainkey',$churchdistrictname)->first();

@endphp
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Annual Report - Admin Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords"> 
  <!-- Favicons -->
  <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('assets/img/favicon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('backend/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('backend/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('backend/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('backend/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('backend/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('backend/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('backend/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('backend/assets/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
  <!-- Font Awesome File -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.1.96/css/materialdesignicons.min.css" />

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  
  <!-- Datatable js Files -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


  <!-- Validate js Files -->
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>

  <!-- drag drop -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <!-- Tooltip -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

 

  {{-- <script src="https://cdn.quilljs.com/1.3.7/quill.js"></script> --}}
 
  <!-- ckeditor JS  -->
  <script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
 
  <!-- =======================================================
  * Template Name: NiceAdmin - v2.4.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<body>
  <!-- Header -->
  @include('adminbackend.includes.header')
  <!-- End Header -->

  <!-- Sidebar -->
  @include('adminbackend.includes.asidebar')
  <!-- Sidebar -->

  <main id="main" class="main">
    <!-- Page Title -->
    @include('adminbackend.includes.pagetitle')
    <!-- End Page Title -->

    <!-- Section -->
    @yield('section')
    <!-- End Section -->

  </main>
  <!-- End #main -->

  <!-- Footer -->
  @include('adminbackend.includes.footer')
  <!-- End Footer -->
  <!-- < My Profile -->
<div class="container">
    <!-- Delete Modal -->
    <div class="modal" id="myprofile" >
    <div class="modal-dialog modal-md modal-centered">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color:#801214;color: #fff;">
          <h4>My Profile</h4>
          <button type="button" id="Closeprofile" class="close" data-dismiss="modal" >&times;</button>
        </div>
        <form id="myprofileuser">
            @csrf
        <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <label for="name" class="form-label">User Name</label>
                <input type="text" id="username" name="username" class="form-control"  value="{{ Auth::user()->username }}" disabled>
            </div>
            <div class="col-12">
                <label for="name" class="form-label">District <span class="mandatory">*</span></label>
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
                <label for="description" class="form-label">Email <span class="mandatory">*</span></label>
                <input type="text" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}" >
            </div>
            <input type="hidden" value="{{Auth::user()->id}}" name="id" id="id">
        </div>
        <br>
        <div class="modal-footer">
          <button class="btn btn-add m-t-15 waves-effect mb-3" type="submit" style="background-color: #801214;color:#fff;" >Update</button>
          <button class="btn btn-add m-t-15 waves-effect mb-3" id="closeModal" type="button" style="background-color: #801214;color:#fff;" >
          Cancel</button>
        </div>
        </div>
      </form>
    </div>
    </div>
    </div>
  </div>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
  <!-- Vendor JS Files -->
  <script src="{{asset('backend/assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('backend/assets/vendor/chart.js/chart.min.js')}}"></script>
  <script src="{{asset('backend/assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('backend/assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('backend/assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('backend/assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('backend/assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('backend/assets/js/main.js')}}"></script>
 <script>

$("#closeModal").click(function() {
        $('#myprofile').modal('hide');
        $('#manageusers').trigger('reset');
    });
    
    $("#Closeprofile").click(function() {
      $('#myprofile').modal('hide');
     });

     $("#myprofileuser").validate({
  rules: {
      username: {

              required: true,
              maxlength: 50,
              minlength:8,
              
            },
      email: {
             required:true,
              email:true,
              accept: true,
              required: true,
              maxlength:100,        
      },
      district:{
              required: true,
      }
  },
  messages: {
      username: {
          required: "Please enter a valid Username",
          
      },
      email: {
          required: "Please enter a valid Email",
          
           regex:"Please enter a valid Email"
      },
      district:{
          required: "Please Choose a District ",
      }
  },
  submitHandler: function(form) {
    var formId = 'myprofileuser';

    $.ajax({
        method : "POST",
        data : $("#"+formId+"").serializeArray(),
        url:"{{ url('AnnualReport/Update-Users') }}",
        success: function(response) {
            $("#myprofile").modal("hide");

            swal("Success!", ""+response.success+"", "success").then(function(){
                    window.location.reload();
                
            });
        }
    });
  }
});
var value = "{{$districtname}}";
var churchdistrict = "{{$churchdistrictname}}"; 

$.ajax({
    type:"get",
    url:"{{ url('AnnualReport/getdistrict') }}",
    data:{
        'district' : value
    },
    success:function(response){
         var options = $("#churchdistrict");
         options.empty().append("<option>Select Church</option>");
        $.each(response, function () {
            var text = ''+this.ChurchName+', '+this.MailingCity;
            options.append($("<option />").val(this.ChurchMainkey).text(text));
        });
        $('#churchdistrict option[value="'+churchdistrict+'"]').attr('selected','selected');

    }
});


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

</body>

</html>