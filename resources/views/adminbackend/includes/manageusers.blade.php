@extends('adminbackend.layouts.index')
@section('section')
@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;
@endphp
<section class="section dashboard">

    <div class="row">
        <!-- Churchlist Section -->
        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                {{-- <div class="filter">
                    <button id="add-main-section" data-bs-toggle="modal" data-bs-target="#main-section"><i class="fas fa-add"></i> Add</button>
                </div> --}}
                <div class="card-body">
                    <h5 class="card-title">Manage Users <span>| Church Report</span></h5>
                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th scope="col">Church Name</th>
                                <th scope="col">Mainkey</th>
                                <th scope="col" style="width: 100px;">Church Code</th>
                                <th scope="col">Church Mail To</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $value)
                            <tr id="user_row{{$value->id}}">
                                <td>{{ $value->MailingName }}</td>
                                <td>{{ $value->Mainkey }}</td>
                                <td>{{substr($value->ChurchCode,0,2)}}-{{substr($value->ChurchCode,2,2)}}-{{substr($value->ChurchCode,4,4)}}</td>
                                <td><a href="mailto:{{ $value->USAEmail }}">{{ $value->USAEmail }}</a></td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <a href="{{url('AnnualReport/ChurchReport/'.ARHelper::encryptUrl($value->Mainkey).'/2021') }}"><i class="fa fa-eye" data-toggle="tooltip" title="View Church Summary"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Churchlist Section -->
    </div>
</section>
@endsection