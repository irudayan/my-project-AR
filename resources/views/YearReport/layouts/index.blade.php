@extends('backend.layouts.main')
@section('content')
@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;            
@endphp

<div class="col-md-12" id="bri_ind_container">
    <div class="php-email-form" >  
        @include('YearReport.includes.annual')
        @yield('contents')
    </div>
</div>
@endsection