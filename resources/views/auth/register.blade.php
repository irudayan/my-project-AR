@php
use App\Models\District;
use App\Models\DistrictChurch;

$dis = District::all();
$churchdis = DistrictChurch::all();

@endphp
 <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">

        <title>ANNUAL REPORT - REGISTER</title>
        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('assets/img/favicon.png')}}" rel="icon">
        <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/font-awesome.min.css')}}" rel="stylesheet">
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    </head>
    <style type="text/css">
        .login-page-title{
            font-family:"Avenir Next Georgian W03 Heavy";
            src:url("./fonts/6125010/5190e196-e58e-40ef-86db-2128109549d7.woff2") format("woff2"),url("./fonts/6125010/b0849c74-ea4d-49c2-9c55-b82427f87838.woff") format("woff");
            color: #939598;
            font-size:50px;
            margin: -20px;
        }
        .login-page-title-large{
            font-weight: bold;
        }
        .signin-button{
            background-color: #801214!important;
        }
        .signin-button: hover{
            border-color: none;
            background-color: #801214;
        }
        .text-color{
            color: #801214;
        }
        .mandatory{
            color: red;
        }
        .text-color: hover{
            color: #801214!important;
        }
        .footer{
           background-color: #801214;
           color: #fff;
           font-size: 12px;
        }
        a: hover{
            color: #fff;
        }
        a.footer-hover:hover {
            color: #fff;
            text-decoration: none;
        }
        ion-icon {
         pointer-events: none;
        }
       .h-6 {
        height: 1rem !important;
        }
        .leading-5{
            top:16px !important;
        }
        .border-gray {

            border-color: #801214 !important;
        }
        .form-check-input:checked[type=checkbox] {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e");
        }
        .rounded-sm{
            border-radius: 0.25em !important;
        }
        input[type=checkbox][disabled] {
               border-color: #9d9d9d;
           background-color: #d8d9e1;
           background-image:none !important;
     }


    </style>
    <body>
        <nav class="bg-[#d8d9e1] border-gray-200 px-2 sm:px-4 py-2.5 dark:bg-gray-800">
          <div class="container flex flex-wrap justify-between items-center mx-auto">
              <a href="{!! URL::to('/') !!}" class="flex">
                <img src="{{ asset('assets/img/cmalliance/Annualreportlogo.png')}}" alt="" width="250" style="max-width: 80%;">
              </a>
          </div>
        </nav>
        <div class="md:flex" >
            <div class="hidden lg:flex items-center justify-center bg-indigo-100 flex-1 ">
                <div class="max-w-xs transform duration-200 hover:scale-110 cursor-pointer">
                    <a href="{!! URL::to('/') !!}">
                        <img src="{{asset('assets/img/alliance-logo.png')}}">
                        <img src="{{asset('assets/img/Annualreport.png')}}">
                    </a>
                </div>
            </div>
            <div class="lg:w-1/2 xl:max-w-screen-sm" >
                <div class="mt-5 px-12 sm:px-24 md:px-48 lg:px-12 lg:mt-8 xl:px-24 xl:max-w-2xl">
                    <h2 class="text-center text-4xl font-display font-semibold lg:text-left xl:text-5xl
                    xl:text-bold text-color">{{ __('Register') }}</h2>
                    <div class="mt-12">
                        <form  id="registerform" method="POST" action="{{ route('register') }}">
                             @csrf

                            <div class="mt-3">
                                  <div class="text-sm font-bold text-gray-700 tracking-wide">Username
                                    &nbsp;<span class="mandatory">*</span><span data-tooltip-target="tooltip-default1"><ion-icon name="information-circle"></ion-icon></span>
                                    <div id="tooltip-default1" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                                        At least 8 characters, no spaces.
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                                <input class="w-full text-lg py-2 border-b border-gray-300 focus:outline-none focus:border-indigo-500 @error('username') is-invalid @enderror" id="username" type="text" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                @error('username')
                                    <span class="invalid-feedback" role="alert" style="font-size: 14px;">
                                        <strong style="color:Red">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <div class="text-sm font-bold text-gray-700 tracking-wide">Email Address&nbsp;<span class="mandatory">*</span></div>
                                <input id="email" type="email" class="w-full text-lg py-2 border-b border-gray-300 focus:outline-none focus:border-indigo-500 @error('email') is-invalid @enderror"  name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert" style="font-size: 14px;">
                                        <strong style="color:Red">{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                            <div class="mt-3">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm font-bold text-gray-700 tracking-wide">
                                        {{ __('Password') }}&nbsp;<span class="mandatory">*</span>
                                    </div>
                                </div>
                               <div class="relative">
                                    <input id="password" type="password" class="w-full text-lg py-2 border-b border-gray-300 focus:outline-none focus:border-indigo-500 @error('password') is-invalid @enderror" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required autocomplete="new-password">

                                    <div class="absolute inset-y-0 right-0 pr-3 flex  text-sm leading-5">
                                      <svg class="h-6 text-gray-700" fill="none" id="view" xmlns="http://www.w3.org/2000/svg"
                                        viewbox="0 0 576 512">
                                        <path fill="currentColor"
                                          d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                        </path>
                                      </svg>

                                      <svg class="h-6 text-gray-700" fill="none" id="hide" style="display:none"  xmlns="http://www.w3.org/2000/svg"
                                        viewbox="0 0 640 512">
                                        <path fill="currentColor"
                                          d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                                        </path>
                                      </svg>
                                  </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color:Red">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm font-bold text-gray-700 tracking-wide">
                                        {{ __('Confirm Password') }}&nbsp;<span class="mandatory">*</span>
                                    </div>
                                </div>
                                  <div class="relative">
                                    <input id="password-confirm" type="password" class="w-full text-lg py-2 border-b border-gray-300 focus:outline-none focus:border-indigo-500" name="password_confirmation" required autocomplete="new-password">

                                    <div class="absolute inset-y-0 right-0 pr-3 flex  text-sm leading-5">
                                    <svg class="h-6 text-gray-700" fill="none" id="rview" xmlns="http://www.w3.org/2000/svg"
                                    viewbox="0 0 576 512">
                                    <path fill="currentColor"
                                    d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                    </path>
                                    </svg>

                                    <svg class="h-6 text-gray-700" fill="none" id="rhide" style="display:none"  xmlns="http://www.w3.org/2000/svg"
                                    viewbox="0 0 640 512">
                                    <path fill="currentColor"
                                    d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                                    </path>
                                    </svg>
                                    </div>
                                    </div>

                                 @error('password')
                                    <span class="invalid-feedback" role="alert" style="font-size: 14px;">
                                        <strong style="color:Red">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="mt-3" >
                                <div class="flex justify-between items-center">
                                    <div class="text-sm font-bold text-gray-700 tracking-wide"  id="districtdropdown">
                                        {{ __('District') }}&nbsp;<span class="mandatory">*</span>
                                    </div>
                                </div>

                                <select id="district" type="text" class="w-full text-lg py-2 border-b border-gray-300 focus:outline-none focus:border-indigo-500 @error('district') is-invalid @enderror" name="district" required autocomplete="district" style="background-color: #fff;font-size: 14px">
                                    <option value="">---Select District---</option>
                                    <option value="NationalOffice">CMA National Office</option>
                                    @foreach($dis as $value)
                                    <option value="{{$value->Mainkey}}">{{$value->Name}}</option>
                                    @endforeach

                                </select>

                                @error('district')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                             <div class="mt-3" id ="chuchdropdown">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm font-bold text-gray-700 tracking-wide chuchdropdown">
                                        {{ __('Church') }}&nbsp;<span class="mandatory">*</span>
                                    </div>
                                </div>

                                <select id="districtchurch" type="text" class="w-full text-lg py-2 border-b border-gray-300 focus:outline-none focus:border-indigo-500 @error('district') is-invalid @enderror" name="districtchurch" required autocomplete="district" style="    background-color: #fff;font-size: 14px">
                                    <option value=""></option>
                                </select>

                                @error('district')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <input type="hidden" id="checkboxvalue" name="checkboxvalue" value="">
                            <div class="mt-3">

                                <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-red-800 checked:border-gray focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" name="districtcheck" id="districtcheck" value="District">
                                 <span id= "labelchange" class="text-sm font-bold text-gray-700 tracking-wide">CMA District staff </span>

                                 <span data-tooltip-target="tooltip-default3"><ion-icon name="information-circle"></ion-icon></span>
                                    <div id="tooltip-default3" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                                       Please select the District.
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                            <div class="mt-4">
                                <button class="signin-button text-gray-100 p-4 w-full rounded-full tracking-wide
                                font-semibold font-display focus:outline-none focus:shadow-outline
                                shadow-lg" type="submit">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </form>
                        <div class="mt-4 text-sm font-display font-semibold text-gray-700 text-center">
                            Do you have an account ? <a class="text-color" href="{{ route('login') }}">Sign In</a>
                        </div>
                        <br>
                    </div>
                </div>
            </div>

        </div>
        <footer>
            <div class="p-3 footer">
            © 2022
            <a class="footer-hover" href="https://cmalliance.org/">The Christian and Missionary Alliance</span></strong>. All Rights Reserved</a>
            <a class="footer-hover" href="#" style="Float: right;">Some material used by permission.</a>
           </div>

        </footer>
    </body>
</html>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://unpkg.com/flowbite@1.5.1/dist/flowbite.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
 <!--  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> -->
<script type="text/javascript">



    $(document).ready(function() {
        $("#view").on('click', function(event) {
            event.preventDefault();
            $('#password').removeAttr('type', 'password');
            $('#password input').attr('type', 'text');
            $('#hide').removeAttr('style');
            $('#view').attr('style','display:none');
        });
        $("#hide").on('click', function(event) {
            event.preventDefault();
            $('#password').removeAttr('type', 'text');
            $('#password').attr('type', 'password');
            $('#view').removeAttr('style');
            $('#hide').attr('style','display:none');
        });
    });

    $(document).ready(function() {
        $("#rview").on('click', function(event) {
            event.preventDefault();
            $('#password-confirm').removeAttr('type', 'password');
            $('#password-confirm input').attr('type', 'text');
            $('#rhide').removeAttr('style');
            $('#rview').attr('style','display:none');
        });
        $("#rhide").on('click', function(event) {
            event.preventDefault();
            $('#password-confirm').removeAttr('type', 'text');
            $('#password-confirm').attr('type', 'password');
            $('#rview').removeAttr('style');
            $('#rhide').attr('style','display:none');
        });
    });


  $(document).ready(function(){

    jQuery.validator.addMethod("accept", function(value, element, param) {
        return value.match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,8})$/);
    },'The email should be in the format: abc@gmail.com');

     jQuery.validator.addMethod("noSpace", function(value, element) { //Code used for blank space Validation
            return value.indexOf(" ") < 0 && value != "";
        }, "No space please and don't leave it empty");

     $("#registerform").validate({
            rules: {
                username: {

                        required: true,
                        maxlength: 50,
                        minlength:8,
                        noSpace: true,
                        remote:{
                            url:"{{ url('checkusername') }}",
                            type:"get",
                     }
                      },
                email: {
                       required:true,
                        email:true,
                        accept: true,
                        required: true,
                        maxlength:100,
                        remote:{
                            url:"{{ url('checkemail') }}",
                            type:"get",
                     }
                },
                password: {
                        required: true,
                         minlength: 5,
                         maxlength: 50,

                 },
                password_confirmation: {
                        required: true,
                        minlength: 5,
                         maxlength: 50,
                        equalTo: "#password"
                 },
                district:{
                        required: true,
                },
                districtchurch:{
                       required: true,
                }
            },
            messages: {
                username: {
                    required: "Please enter a valid Username.",
                    remote:"Username has already been taken."
                },
                email: {
                    required: "Please enter a valid Email",
                     remote:"Email has been already taken",
                     regex:"Please enter a valid Email"
                },
                password: {
                        required: "Please enter a valid Password.",
                        regex:"Please enter a valid Password.",
                },
                password_confirmation:{
                        required: "Please enter a valid Password. ",
                        equalTo: "Password must be same.",
                },
                district:{
                    required: "Please Choose a District. ",
                },
                districtchurch:{
                       required: "Please Choose a Church.",
                },
            },

        });

        $("#districtcheck").prop("disabled", true);
        $("div#chuchdropdown").hide();

        $("#district").change(function(){
            var districtdata = $(this).val();
     
            if (districtdata =='NationalOffice') {
                $("#districtcheck").prop("disabled", false).attr("checked",true);
                $('#labelchange').text('CMA District / National Office Staff');
                $('div#chuchdropdown').hide();
                $("#checkboxvalue").val('NationalOffice');

            }else{
                $("#districtcheck").prop("disabled", true);
                $('div#chuchdropdown').hide();
                $('#labelchange').text('CMA District staff');

                $('#' + $(this).val()).show();
                $("#districtcheck").prop("disabled", false).attr("checked",false);
               
             var district = $("#district").val();
                $(document).on('change', '#districtcheck', function() {
                    var check = $("#districtcheck").prop('checked');
                    if(check == true){
                        $(".chuchdropdown").hide();
                        $("#districtchurch").hide();
                        $("#checkboxvalue").val('districtstaff');
                    }
                    if(check == false){
                        $("#districtchurch").show();
                        $(".chuchdropdown").show();
                    }
                    
                });
                

                $('#districtchurch').empty();
                    $.ajax({
                        type:"get",
                        url:"{{ url('districtchurch') }}",
                        data:{'district':district},
                        success:function(response){
                            console.log(response);
                            $("div#chuchdropdown").show();
                            var options = $("#districtchurch");
                            options.append($("<option />").val('').text('--Select Church--'));
                            $.each(response, function () {
                                var text = ''+this.ChurchName+', '+this.MailingCity;
                                options.append($("<option />").val(this.ChurchMainkey).text(text));
                            });

                        }
                        });
            }
           
            
        });
    });
</script>
