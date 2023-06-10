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
                <h5 class="sub-section-head">C&MA Missions</h5>
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
                            <td>Total # People to C&MA Foreign Sites</td>
                            <td><input type="text" class="form-control" name="STMCMAForeign" value="{{ $annualreportdata->STMCMAForeign }}"></td>
                            <td>{{ $lastyear->STMCMAForeign }}</td>
                        </tr>
                        <tr>
                            <td>Total # People to C&MA Domestic Sites</td>
                            <td><input type="text" class="form-control" name="STMCMADomestic" value="{{ $annualreportdata->STMCMADomestic }}"></td>
                            <td>{{ $lastyear->STMCMADomestic }}</td>
                        </tr>
                        <tr>
                            <td>Total Amount Contributed for C&MA Trips</td>
                            <td><input type="text" class="form-control" name="STMCMAContributions" value="{{ $annualreportdata->STMCMAContributions }}"></td>
                            <td>{{ $lastyear->STMCMAContributions }}</td>
                        </tr>
                        <tr>
                            @php
                                $smtevent = $annualreportdata->STMEvent;
                            @endphp
                            
                            <td>Did you hold an Alliance Missions Emphasis event in {{$year}}?</td>
                            <td>
                            <select class="form-select" name="STMEvent" id="STMEvent">
                                <option value=""></option>
                                <option value="Y" {{ $smtevent == 'Y' ? 'selected' : '' }}>Yes</option>
                                <option value="N" {{ $smtevent == 'N' ? 'selected' : '' }}>No</option>
                            </select>
                            </td>
                            <td>{{ $lastyear->STMEvent }}</td>
                        </tr>
                        <tr>
                            <td>Alliance International Financial Partnerships</td>
                            <td><input type="text" class="form-control" name="AllianceWorkersSupported" value="{{ $annualreportdata->AllianceWorkersSupported }}"></td>
                            <td>{{ $lastyear->AllianceWorkersSupported }}</td>
                        </tr>
                    </tbody>
                </table>
            </section>
            <section class="sub-section">
                <h5 class="sub-section-head">Partnerships</h5>
                <p>If your church has a partnership with Alliance International Ministries field(s), team(s), or International Worker(s), please list them here.</p>
                <p>For each partnership, click on 'Add Field' then select the correct field name.</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-head">Question</th>
                            <th class="col-head"><center><button  title="Add Field" data-toogle="tooltip"><i class="fas fa-add"></i> Add Field</button></center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dominican Republic Field</td>
                            <td><center><button title="Edit" data-toogle="tooltip"><i class="fas fa-edit"></i></button></center></td>
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