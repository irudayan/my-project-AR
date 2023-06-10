@php
use Illuminate\Support\Facades\Auth;
$user = Auth::user()->usertype ?? '';
use App\Models\QuestionTypedropdown;
use App\Models\Mainsection;
use App\Models\District;
use App\Models\DistrictChurch;
use Carbon\Carbon;


$mainsection = Mainsection::all();
 $questiontype = QuestionTypedropdown::all();
 $district = District::all();

 
if(!empty($question)){
    $questionMainsection = $question->Mainsection;
}else{
    $questionMainsection = "";
}

$districtnameexport = Auth::user()->district ??'';
$usertype = Auth::user()->usertype ??'';


    $getdistrictexport =  District::select('Name')->where('Mainkey',$districtnameexport)->first();
    $district = District::all();
    $churchdistrictnameexport = Auth::user()->churchdistrict ??'';
    $getchurchdistrictexport = DistrictChurch::select('ChurchName')->where('ChurchMainkey',$churchdistrictnameexport)->first();
    $year = Carbon::now()->year-1;
    
   
@endphp
<header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="{{url('/')}}"><img src="{{asset('assets\img\Annualreportlogo.png')}}" alt=""></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt=""></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto {{ request()->is('/') ? 'active' : '' }}" href="{{url('/')}}">Home</a></li>
          {{-- <li><a class="nav-link scrollto" href="#hero">About</a></li> --}}
          {{-- <li><a class="nav-link scrollto" href="#faq">FAQ</a></li> --}}

          <li><a class="nav-link scrollto {{ request()->is('*/Church-Export/*') ? 'active' : '' }} {{ request()->is('login/*') ? 'active' : '' }}" href="{{url('AnnualReport/Dashboard')}}">Report</a></li>
          @if (Route::has('login'))
          @auth
          @if($usertype == 'Admin' || $usertype == 'District' || $usertype == 'NationalOffice')  
          <li style=" cursor: pointer;"> <a class="a-link {{ request()->is('*/Church-Export') ? 'active' : '' }}" href="{{url('AnnualReport/Church-Export')}}"> Church Export</a>
          </li>
          @endif
          @endauth
          @endif
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
           @if (Route::has('login'))
          @auth
            <a href="{{ url('/logout') }}" class="linkedin rsignout">Sign Out</a>
          @else
            <a href="{{ route('login') }}" class="linkedin rsignin">Sign In</a>
          @endauth
        @endif
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header>
