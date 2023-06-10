@extends('YearReport.layouts.index')

@php
use Illuminate\Support\Facades\Session;
use App\Helpers\ARHelper;
$year = request()->segment(count(request()->segments()));        
@endphp

@section('contents')
<div class="tab-section">
    <br>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <section class="sub-section">
            <h5 class="sub-section-head">Non-C&MA Missions</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th class="col-head">Question</th>
                        <th class="col-head">This Year</th>
                        <th class="col-head stat">Last Year</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total # People to Non-C&MA Foreign Sites</td>
                        <td><input type="text" class="form-control" name="STMNonCMAForeign" value="{{ $annualreportdata->STMNonCMAForeign }}"></td>
                        <td>{{ $lastyear->STMNonCMAForeign }}</td>
                    </tr>
                    <tr>
                        <td>Total # People to Non-C&MA Domestic Sites</td>
                        <td><input type="text" class="form-control" name="STMNonCMADomestic" value="{{ $annualreportdata->STMNonCMADomestic }}"></td>
                        <td>{{ $lastyear->STMNonCMADomestic }}</td>
                    </tr>
                    <tr>
                        <td>Total Amount Contributed to Non-C&MA Missions & Trips</td>
                        <td><input type="text" class="form-control" name="STMNonCMAContributions" value="{{ $annualreportdata->STMNonCMAContributions }}"></td>
                        <td>{{ $lastyear->STMNonCMAContributions }}</td>
                    </tr>
                </tbody>
            </table>
            </section>
            <center><button>Continue</button></center>
            <br>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <section>
            <div class="question">
                <div class="QA">
                <h6><center>Question Assistant</center></h6>
                <p>The question assistant displays tips and information regarding every question on the Annual Report.</p>
                </div>
                <div class="help">
                <h6><center>How This Helps</center></h6>
                <p>The question assistant displays tips and information regarding every question on the Annual Report.</p>
                </div>
                <div class="have-questions">
                <label><strong>Have Questions?</strong></label><br>
                <label><i class="fas fa-envelope"></i>&nbsp;dmomail@cmalliance.org</label><br>
                <label><i class="fas fa-phone"></i>&nbsp;1-877-284-3262 opt 4</label>
                </div>
            </div>
            </section>
        </div>
        </div>
    </div>
</div>
@endsection