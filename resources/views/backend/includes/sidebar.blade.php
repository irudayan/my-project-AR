@php
use App\Helpers\ATMNHelper;
use Illuminate\Support\Facades\Auth;

$user = Auth::user()->usertype;
@endphp
<div class="col-md-3">
  <div class="php-email-form">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="font-size:15px">
      @if ($user == 'Admin') 
      <a class="nav-link {{ request()->is('*/Dashboard') ? 'active' : '' }} {{ request()->is('login/*') ? 'active' : '' }} {{ request()->is('Impersonate/*') ? 'active' : '' }}" id="v-pills-home-tab" data-toggle="pill" href="{{url('AnnualReport/Admin-Dashboard')}}" role="tab" aria-controls="v-pills-home" aria-selected="true">Dashboard</a>
      @else
      <a class="nav-link {{ request()->is('*/Dashboard') ? 'active' : '' }} {{ request()->is('login/*') ? 'active' : '' }} {{ request()->is('Impersonate/*') ? 'active' : '' }}" id="v-pills-home-tab" data-toggle="pill" href="{{Route('dashboard')}}" role="tab" aria-controls="v-pills-home" aria-selected="true">Dashboard</a>
      @endif
      </div>
    @if ($user == 'Admin')
    <!-- <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="font-size:15px">
      <a class="nav-link {{ request()->is('*/Churchlist') ? 'active' : '' }}" id="v-pills-home-tab" data-toggle="pill" href="{{Route('churchlist')}}" role="tab" aria-controls="v-pills-home" aria-selected="true">Churchlist</a>
    </div> -->
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="font-size:15px">
        <a class="nav-link {{ request()->is('*/Manage-Users') ? 'active' : '' }}" id="v-pills-home-tab" data-toggle="pill" href="{{url('AnnualReport/Manage-Users')}}" role="tab" aria-controls="v-pills-home" aria-selected="true">Manage Users</a>
    </div>
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="font-size:15px">
      <a class="nav-link {{ request()->is('*/Church-Export') ? 'active' : '' }}" id="v-pills-home-tab" data-toggle="pill" href="{{url('AnnualReport/Church-Export')}}" role="tab" aria-controls="v-pills-home" aria-selected="true">Church Export</a>
  </div>
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="font-size:15px">
      <a class="nav-link {{ request()->is('*/Manage-Documents') ? 'active' : '' }}" id="v-pills-home-tab" data-toggle="pill" href="{{url('AnnualReport/Manage-Documents')}}" role="tab" aria-controls="v-pills-home" aria-selected="true">Manage Documents</a>

  </div>
  {{-- <a class="nav-link {{ request()->is('*/resourceindex') ? 'active' : '' }}" id="v-pills-home-tab" data-toggle="pill" href="{{Route('resourceindex')}}" role="tab" aria-controls="v-pills-home" aria-selected="true">Resource Uploads</a> --}}

    {{-- <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="font-size:15px">
      <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="{{url('AnnualReport/Admin-Dashboard')}}" role="tab" aria-controls="v-pills-home" aria-selected="true">Admin Dashboard</a>
    </div> --}}
    @elseif ($user != 'Users' && $user != 'Pastor' )
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="font-size:15px">
      <a class="nav-link {{ request()->is('*/Church-Export') ? 'active' : '' }}" id="v-pills-home-tab" data-toggle="pill" href="{{url('AnnualReport/Church-Export')}}" role="tab" aria-controls="v-pills-home" aria-selected="true">Church Export</a>
  </div>
    @endif
   
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

