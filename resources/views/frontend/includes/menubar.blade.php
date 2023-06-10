@php
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\Auth;
    use App\Helpers\ARHelper;
    
    $year = request()->segment(count(request()->segments()));
    $usertype = Auth::user()->usertype ?? '';
    
@endphp
<section class="menubar">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <ol>

                <li class="menu-item {{ request()->is('*/Dashboard') ? 'active' : '' }}">
                    @if ($usertype == 'Admin')
                        <a href="{{ url('AnnualReport/Admin-Dashboard') }}">Dashboard</a>
                    @endif
                    @if ($usertype == 'District' || $usertype == 'NationalOffice')
                        <a href="{{ Route('dashboard') }}">Dashboard</a>
                    @endif
                </li>

                @if (request()->is('*/Church-Export') == 'Church-Export')
                    <li class="menu-item {{ request()->is('*/Church-Export') ? 'active' : '' }}">
                        <a href="{{ url('AnnualReport/Church-Export') }}">Church Export</a>
                    </li>
                @endif

                @if (request()->is('*/Church-Export') != 'Church-Export')

                    @if ($usertype == 'Admin')
                        <li class="menu-item {{ request()->is('*/Manage-Users') ? 'active' : '' }}">
                            <a href="{{ url('AnnualReport/Manage-Users') }}">Manage Users</a>
                        </li>
                    @endif

                    <li class="menu-item {{ request()->is('*/ChurchReport/*') ? 'active' : '' }}">
                        <a href="{{url('AnnualReport/ChurchReport/'.ARHelper::encryptUrl($churchdata->Mainkey).'/'.$year)}}">Church Report</a>
                    </li>


                    <li class="dropdown menu-item">
                        <a href="#"><span>Past Report</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            @foreach($reportingyear as $value)
                            <li class="menu-item {{ request()->is('*/'.$value->YearReported) ? 'active' : '' }}"><a href="{{url('AnnualReport/ChurchReport/'.ARHelper::encryptUrl($churchdata->Mainkey).'/'.$value->YearReported)}}">{{$value->YearReported}}</a></li>
                            @endforeach
                        </ul>
                    </li>

                @endif
            </ol>
        </div>
    </div>
</section>
<style type="text/css">
    ol>li a:hover {
        color: #444444;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script>
    $("#reportyear").on('change', function() {
        var year = $(this).val();
        window.location =
            "{{ url('AnnualReport/ChurchReport/Membership/' . ARHelper::encryptUrl($churchdata->Mainkey ?? '')) ?? '' }}/" + year;
    });
</script>
