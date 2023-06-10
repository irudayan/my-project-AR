
 <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">

        <title>ANNUAL REPORT - SIGN IN</title>
        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('assets/img/favicon.png')}}" rel="icon">
        <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
       



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
         .h-6 {
        height: 1rem !important;
        }
          .leading-5{
            top:16px !important;
        }
        .hicon{
            margin-left: -98px;
            padding-top: 13px;
            
        }
        .rhome{
            padding-left: 18px;
             margin-top: -15px;
        }
        
    </style>
    <body>
        <nav class="bg-[#d8d9e1] border-gray-200 px-2 sm:px-4 py-2.5 dark:bg-gray-800">
          <div class="container flex flex-wrap justify-between items-center mx-auto">
              <img src="{{ asset('assets/img/cmalliance/Annualreportlogo.png')}}" alt="" width="250" style="max-width: 80%;">
          </div>
        </nav>
        <div class="md:flex" style="height: 556px;">
            <div class="hidden lg:flex items-center justify-center bg-indigo-100 flex-1">
                <div class="max-w-xs transform duration-200 hover:scale-110 cursor-pointer">
                    <a href="{!! URL::to('/') !!}"><img src="{{asset('assets/img/alliance-logo.png')}}">
                    <img src="{{asset('assets/img/Annualreport.png')}}"></a>
                </div>
            </div>
            <div class="lg:w-1/2 xl:max-w-screen-sm" style="padding-top: 30px;">
<!--                 <div class="py-4 bg-indigo-100 lg:bg-white flex justify-center lg:justify-start lg:px-12">
                    <div class="cursor-pointer flex items-center">
                        <div class="text-2xl text-indigo-800 tracking-wide ml-2 font-semibold"><img src="{{ asset('assets/img/cmalliance/logo.png')}}"></div>
                    </div>
                </div> -->
                <div class="mt-10 px-12 sm:px-24 md:px-48 lg:px-12 lg:mt-8 xl:px-24 xl:max-w-2xl">
                    <h2 class="text-center text-4xl font-display font-semibold lg:text-left xl:text-5xl
                    xl:text-bold text-color">Log in</h2>
                    <div class="mt-8">
                        <form  method="POST" action="{{ route('login') }}">
                             @csrf
                            <div class="mt-8">
                                <div class="text-sm font-bold text-gray-700 tracking-wide">Username</div>
                                <input class="w-full text-lg py-2 border-b border-gray-300 focus:outline-none focus:border-indigo-500 @error('username') is-invalid @enderror" type="text" value="{{ old('username') }}" name="username"  required autocomplete="username" >
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color:Red">{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                            <div class="mt-6" id="show_hide_password">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm font-bold text-gray-700 tracking-wide">
                                        Password
                                    </div>
                                    <div>
                                        @if (Route::has('password.request'))
                                        <a class="text-xs font-display font-semibold text-color" href="{{ route('password.request') }}">
                                            Forgot Password?
                                        </a>
                                        @endif
                                         
                                    </div>
                                    
                                </div>
                         
                                <div class="relative">
                                <input class="w-full text-lg py-2 border-b border-gray-300 focus:outline-none focus:border-indigo-500 @error('password') is-invalid @enderror" type="password"  id="password" type="password"  name="password" required autocomplete="current-password">
                                <div class="absolute inset-y-0 right-0 pr-3 flex text-sm leading-5">
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


                            <div class="mt-8">
                                <button class="signin-button text-gray-100 p-4 w-full rounded-full tracking-wide
                                font-semibold font-display focus:outline-none focus:shadow-outline
                                shadow-lg" type="submit">
                                    Log In
                                </button>
                            </div>
                        </form>
                        <div class="mt-8 text-sm font-display font-semibold text-gray-700 text-center">
                            Don't have an account ? <a class="text-color" href="{{ route('register') }}">Sign up </a>                         
                        </div>
                        <div class="mt-8 text-sm font-display font-semibold text-gray-700 text-center"><a class="text-color" href="{!! URL::to('/') !!}">
                            <center><img src="{{ asset('assets/img/home.png')}}" class="hicon" alt="" width="20"><p class="rhome">Return Home</p></a></center>
                                                     
                        </div>
                        
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
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
    
</script>
