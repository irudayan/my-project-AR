<!-- ======= Top Bar ======= -->
  
@php
  use App\Helpers\ARHelper;
  use App\Models\District;
  use App\Models\DistrictChurch;
  $districtname = Auth::user()->district ??'';
  $getuserdistrict =  District::select('Name')->where('Mainkey',$districtname)->first();
 
  $district = District::all();
  $churchdistrictname = Auth::user()->churchdistrict ??'';
  $getuserchurchdistrict = DistrictChurch::select('ChurchName')->where('ChurchMainkey',$churchdistrictname)->first();

@endphp
<style>
  
.dropdown-menu {
  display: none;
  position: absolute;
  background-color: #f6f9ff;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-menu a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  margin-left: 0px !important;
}

.dropdown-menu a:hover {
  background-color: #801214;
  color: #fff !important;
}

.dropdown:hover .dropdown-menu {
  display: block;
}

.a-link{
  color: #000 !important;
  font-size: 14px;
  width: 200px;
}
.form-label {
  color: #4c4b4b;
}
.username-profile{
  padding-top: 15px !important;
  padding-bottom: 3px;
}
.dropdown-divider {
  height: 0;
  margin: var(--bs-dropdown-divider-margin-y) 0;
  overflow: hidden;
  border-top: 1px solid var(--bs-dropdown-divider-bg);
  opacity: 1;
  color: #999ea4;
}
</style>
<section id="topbar" class="d-flex align-items-center">
<div class="container d-flex justify-content-center justify-content-md-between">
<div class="contact-info d-flex align-items-center">
@if (Route::has('login'))
@auth
<h5>Welcome,&nbsp;{{ Auth::user()->username }}</h5> 
@endauth
@endif
</div>
<div class="social-links d-md-flex align-items-center">
<a href="https://www.facebook.com/cmalliance" target="_blank" class="facebook"><i class="bi bi-facebook"></i></a>
<a href="https://www.instagram.com/cmalliance" target="_blank" class="instagram"><i class="bi bi-instagram"></i></a>
<a href="https://www.linkedin.com/company/cmalliance" target="_blank" class="linkedin"><i class="bi bi-linkedin"></i></a>


@if (Route::has('login'))
  @auth
  <div class="dropdown">
    <a href="javascript:void(0)" class="linkedin"><i class="bi bi-person-circle"></i></a>
    <div class="dropdown-menu">
      <div>
      <center>
      <h6 class="username-profile">{{ Auth::user()->username }}</h6>
      </center>
      <br>
      </div>
      <hr class="dropdown-divider">
      <a  data-bs-toggle="modal"  data-bs-toggle="modal" data-bs-target="#profileModal" class="a-link"><i class="bi bi-person"></i> My Profile</a>
      <hr class="dropdown-divider">
      <a href="{{ route('change-password',array(ARHelper::encryptUrl(Auth::user()->id))) }}" class="a-link"><i class="bi bi-key"></i> Reset Password</a>
    </div>
  </div>
  <a href="{{ url('/logout') }}" class="linkedin tsignout"> &nbsp;<i class="fa fa-sign-out" aria-hidden="true"></i>Sign Out</a>
  @else
  <a href="{{ route('login') }}" class="linkedin tsignin"><i class="fa fa-sign-in" aria-hidden="true"></i> Sign In</a>
  @endauth
@endif

<div>
<!-- < My Profile -->
@if (Route::has('login'))
  @auth
    <div class="container">
    <!-- Delete Modal -->
    <div class="modal" id="profileModal" >
    <div class="modal-dialog modal-md modal-centered">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color:#801214;color: #fff;">
          <h4>My Profile</h4>
          <button type="button" id="CloseprofileModal" class="close" data-dismiss="modal" >&times;</button>
        </div>
        <form id="profile">
            @csrf
        <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <label for="name" class="form-label">User Name</label>
                <input type="text" id="profileusername" name="username" class="form-control" id="main-section-name" value="{{ Auth::user()->username }}" disabled>
            </div>
            <div class="col-12">
                <label for="name" class="form-label">District <span class="mandatory">*</span></label>
                <select class="form-select" name="district" id="profiledistrict" disabled>
                  <option value="NationalOffice">CMA National Office</option>
                @foreach($district as $dis)
                    <option value="{{$dis->Mainkey}}">{{ $dis->Name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label for="name" class="form-label">Church </label>a
                <select class="form-select" name="churchdistrict" id="profilechurchdistrict" disabled>
                    <option value=""></option>
                </select>
            </div>
            <div class="col-12">
                <label for="description" class="form-label">Email <span class="mandatory">*</span></label>
                <input type="text" id="profileemail" name="email" class="form-control" id="main-section-name" value="{{ Auth::user()->email }}" >
            </div>
            <input type="hidden" value="{{Auth::user()->id}}" name="id" id="profileid">
        </div>
        <br>
        <div class="modal-footer">
          <button class="btn btn-add m-t-15 waves-effect mb-3" type="submit" style="background-color: #801214;color:#fff;" >Update</button>
          <button class="btn btn-add m-t-15 waves-effect mb-3" id="closeprofileModal" type="button" style="background-color: #801214;color:#fff;" >
          Cancel</button>
        </div>
        </div>
    </div>
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>

    </div>

    </div>
   @endauth
  @endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
<script>
  $("#closeprofileModal").click(function() {
      $('#profileModal').modal('hide');
      $('#manageusers').trigger('reset');
  });
  
  $("#CloseprofileModal").click(function() {
    $('#profileModal').modal('hide');
  });
     
  $(document).ready(function () {
    $('.dropdown-toggle').mouseover(function() {
      $('.dropdown-menu').show();
    });

    $('.dropdown-toggle').mouseout(function() {
      t = setTimeout(function() {
      $('.dropdown-menu').hide();
      }, 100);

      $('.dropdown-menu').on('mouseenter', function() {
        $('.dropdown-menu').show();
        clearTimeout(t);
      }).on('mouseleave', function() {  
        $('.dropdown-menu').hide();
      });
    });
  });

@if (Route::has('login'))
@auth

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

@endauth
@endif

 


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
        $('#profilechurchdistrict option[value="'+churchdistrict+'"]').attr('selected','selected');
      }
    });
  });

  jQuery.validator.addMethod("accept", function(value, element, param) {
      return value.match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/);
  },'The email should be in the format: abc@gmail.com');

$("#profile").validate({
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
    var data = $("#profile").serializeArray();
    $.ajax({
        method : 'GET',
        data : $("#profile").serializeArray(),
        url:"{{ url('AnnualReport/Update-Profile') }}",
        success: function(response) {
            $("#profileModal").modal("hide");
            swal("Success!", ""+response.success+"", "success").then(function(){
                    window.location.reload();
            });
        }
    });
  }
});

$("#profiledistrict").change(function(){
  var district = $(this).val();
  $.ajax({
    type:"get",
    url:"{{ url('AnnualReport/getdistrict') }}",
    data:{
    'district' : district
    },
    success:function(response){
      var options = $("#profilechurchdistrict");
      options.empty().append("<option>Select Church</option>");
      $.each(response, function () {
          var text = ''+this.ChurchName+', '+this.MailingCity;
          options.append($("<option />").val(this.ChurchMainkey).text(text));
      });

      $("#profileupdate").click(function(e) {
        e.preventDefault();
        var formId = 'profile';
      })
    }
  });
});

</script>
</section>
