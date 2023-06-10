@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;
use Carbon\Carbon;

@endphp
<style>
  .main-nav-bg {
    background-color: #fff;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #fff;
  }
  .sub-nav-bg {
    background-color: #801214;
  }
  .subnav > a, .navbar a:focus {
    padding: 0 15px;
  }
  .main-nav > a, .navbar a:focus {
    padding: 0 15px;
  }
  .main-nav > a.nav-menu.active{
    /* background-color: #801214; */
    color: #000;
    font-weight: 1000;
    border-bottom: 4px solid #801214;
  }
  .main-nav > a.nav-menu{
    background-color: #fff;
    font-weight: 100;
  }
  .empty-bg{
    background-color: #801214;
    height: 5px;
  }
  .subnav >a.nav-link{
    font-weight: 100;
    color: #fff;
  }
  .subnav>.nav-link.active{
    font-weight: 700;
    background-color: #eee;
    color: black;
  }
  .subnav >.nav-link.active:hover{
    background-color: #eee;
    color: black;
  }
  .subnav > a.nav-link:hover{
    color: #fff;
  }
  .question-name-label{
    padding:14px 0 0 10px;
  }
  .perstyle {
    color: red;
  }
  .perstyle-in {
    color: rgb(4, 163, 17);
  }
  .percent-button{
    background-color: #801214;
    color: #fff;
    padding: 2px 6px;
    border-radius: 4px;
  }
  .multidropdown-button{
    background-color: #801214;
    color: #fff;
    padding: 2px 6px;
    border-radius: 4px;
  }
  .staff-title {
    font-size: .9em;
    color: #888;
}
.rolenames{
    font-size: 0.8em;
}
.staffnames{
    font-size: 0.9em;
}
.staffemail{
    font-size: 0.9em;
}
.tooltip > .tooltip-inner {
  background-color: #dddded !important;
  position: top;
  padding: 1rem;
}
.tooltip-inner{
  color:#000 !important;
  font-size: 11px;
  font-weight: bold;
}
th.columnwidth{
  width:100px;
}
.sticky-sidebar-css {
position: sticky;
position: -webkit-sticky;
top: 2rem;
}
.mandatory{
color: red;
}
</style>
@php
$svg =<<<HERE

HERE;
@endphp
<div class="row" >
  <div class="col-md-7">
    {{$year}} Annual Report
  </div>
  <div class="col-md-5" style="font-style: italic;font-size:13px;">
    @if($annualreportdata != null)
    <span style="float: right;padding-top:6px;">Last Updated {{ date('m/d/Y h:i A', strtotime($annualreportdata->updated_at)) ?? '' }} mst</span>
    @endif
  </div>
</div>
<h3 style="margin-bottom: 0px">{{$churchdata->MailingName}}</h3>
<h6 style="color: #801214;margin-bottom: 0px">{{$churchdata->MailingCity}}&nbsp;{{$churchdata->MailingState}}</h6>
<span style="font-size: 13px;">Mainkey&nbsp;&nbsp;<strong>{{$churchdata->Mainkey}}</strong>&nbsp;&nbsp;&nbsp;Church Code&nbsp;&nbsp;<strong>{{substr($churchdata->ChurchCode,0,2)}}-{{substr($churchdata->ChurchCode,2,2)}}-{{substr($churchdata->ChurchCode,4,3)}}</strong></span>
<br><br>
<div class="main-nav-bg">
  <nav class="navbar navbar-light main-nav">

        @php
          $segments = Request::segments();
          $subsectionurl  = $segments[3];
          $Currentyear = Carbon::now()->year-1;
        @endphp

        @foreach($mainsection as $value)

          @php
            $activemainsection = ARHelper::subsection($value->Name);
            $datamain = ARHelper::mainsectionstatus($churchdata->Mainkey,$year,ARHelper::rmvsplcharcter($value->Name));

            $datasuballstatus = ARHelper::datasuballstatus($churchdata->Mainkey,$year,ARHelper::rmvsplcharcter($value->Name));
            if($datasuballstatus['inColumn'] == $datasuballstatus['totalcount']){
              $in = 0;
            }else{
              if( $datasuballstatus['inColumn'] != 0 && $datasuballstatus['inColumn'] <= $datasuballstatus['totalcount']){
                $in = 1;
              }else{
                $in = 0;
              }
            }
          @endphp

          <a class="nav-menu @foreach($activemainsection as $values){{ request()->is('*/'.ARHelper::rmvsplcharcter($values->Name).'/*') ? 'active' : '' }} @endforeach"
          href="{{url('AnnualReport/ChurchReport/'.ARHelper::rmvsplcharcter($value->Name).'/'.ARHelper::findsection($value->Name).'/'.ARHelper::encryptUrl($churchdata->Mainkey).'/'.$year)}}" style="padding: 4px 15px;">{{ $value->Name }}
          @if($year != $Currentyear)
          &nbsp;<img src="{{asset('assets/png/checkmark.png')}}" width="21px">
          @else
            @if($annualreportdata != null)
              @php
                $sectioncomplete = ARHelper::sectioncomplete($value->Name,$churchdata->Mainkey,$year);
              @endphp
              @if($sectioncomplete == 1)
                &nbsp;<img src="{{asset('assets/png/checkmark.png')}}" width="21px"> 
              @endif 
              @if($sectioncomplete == 0)
                <i class="fas fa-warning" data-toggle="tooltip" data-placement="top" data-html="true" title="Please fill out this section" style="font-size: 15px;color:#ce1417"></i> 
              @endif
            @endif
          @endif
          </a>
        @endforeach

        @php
          $reviewsectionstatus = ARHelper::reviewsectionstatus($churchdata->Mainkey,$year,'Review');

          $reviewdatastatus = "";

          if($reviewsectionstatus != 0){
            $reviewin = 1;
          }else{
            $reviewin = 0;
          }
        @endphp

          <a class="nav-menu {{ request()->is('*/Review/*') ? 'active' : '' }}" href="{{url('AnnualReport/ChurchReport/Review/Review/'.ARHelper::encryptUrl($churchdata->Mainkey).'/'.$year)}}" style="padding: 4px 15px;">
            Review/Submit
            @if($year != $Currentyear)
              &nbsp;<img src="{{asset('assets/png/checkmark.png')}}" width="21px">
            @else
              @if($reviewin == 1)
              &nbsp;<img src="{{asset('assets/png/checkmark.png')}}" width="21px">
              @endif
            @endif
          </a>

  </nav>
</div>
<div class="empty-bg"></div>

<div class="sub-nav-bg">

  <nav class="navbar navbar-expand-lg subnav">
  @php
    $segments = Request::segments();
    $listsubsection  = ARHelper::subsectioncode($segments[2]);
  @endphp

  @if($segments[2] != 'Review')

    @foreach($listsubsection as $value)
      @php
      $datasub = ARHelper::subsectionstatus($churchdata->Mainkey,$year,ARHelper::rmvsplcharcter($value->Name));
      @endphp
      <a class="nav-link {{ request()->is('*/'.ARHelper::rmvsplcharcter($value->MainsectionName).
        '/'.ARHelper::rmvsplcharcter($value->Name).'/*') ? 'active' : '' }}"  href="{{url('AnnualReport/ChurchReport/'.ARHelper::rmvsplcharcter($value->MainsectionName).'/'.ARHelper::rmvsplcharcter($value->Name).'/'.ARHelper::encryptUrl($churchdata->Mainkey).'/'.$year)}}" style="padding: 4px 30px;">{{ $value->Name }}
          @if($year != $Currentyear)
            <img src="{{asset('assets/png/checkmark.png')}}" width="21px">
          @else
            @if($datasub == 1)<img src="{{asset('assets/png/checkmark.png')}}" width="21px"> @endif
          @endif
      </a>
    @endforeach
  @else
    @php
    $datasub1 = ARHelper::subsectionstatus($churchdata->Mainkey,$year,"Review");
    @endphp
    <a class="nav-link {{ request()->is('*/Review/Review/*') ? 'active' : '' }}"  href="{{url('AnnualReport/ChurchReport/Review/Review/'.ARHelper::encryptUrl($churchdata->Mainkey).'/'.$year)}}" style="padding: 4px 30px;"> Review
      @if($year != $Currentyear)
            <img src="{{asset('assets/png/checkmark.png')}}" width="21px">
      @else
        @if($datasub1 == 1)<img src="{{asset('assets/png/checkmark.png')}}" width="21px"> @endif
      @endif
    </a>
  @endif


  </nav>
</div>
<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
