@extends('web.layouts.master')

@section('content')
<div class="content-section" style="flex:5;">
<section class="main p-tb-60">
    <div class="container">
        <div class="col-md-10 col-lg-10 mx-auto">

            <div class="d-flex justify-content-between">
                <div class="qr-head">
                    <h2 class="m-b-10 text-center"> IRL Report Available</h2>
                    <p class=" align-items-end mb-3 text-center small font-weight-bold">IRL Report number {{ $irlReport->reference_no}}

                    </p>
                </div>
                <div class="qr-code d-flex  justify-content-end">
                    {{QrCode::size(200)->generate(App\Models\IrlReport::generateURL($irlReport->reference_no, $irlReport->email))}}
                </div>
            </div>
            <table class="table table-bordered table--report m-b-40" >
                <!-- <thead class="thead-light">
                        <tr>
                            <th scope="col" width="40%">Ite</th>
                            <th scope="col" width="60%"></th>
                        </tr>
                    </thead> -->
                <tbody>
                    <tr>
                        <th scope="row">IRL NO.</th>
                        <td>{{$irlReport->reference_no }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Report Date</th>
                        <td>{{$irlReport->created_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name</th>
                        <td> {{$irlReport->name }}</td>
                    </tr>
                    <tr style="display:none;">
                        <th scope="row">Registered Email</th>
                        <td>{{$irlReport->email}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Registered Number</th>
                        <td>{{$irlReport->phone}}</td>
                    </tr>

                    <tr>
                        <th scope="row">Download IRL Report</th>
                        <td>

                        <a style="background-color:#488CD3;" href="{{$irlReport->report_pdf_url}}" target="_blank" class="btn btn--primary" download=""><i class="fas fa-download"></i> Download</a>
                        </td>
                    </tr>


                </tbody>
            </table>
            <iframe src="{{$irlReport->report_pdf_url}}" width="100%" height="500px" class="pdf1"></iframe>
            <div class="btn-wrap text-right m-t-10">
                <a style="background-color:#488CD3;" href="{{$irlReport->report_pdf_url}}" target="_blank" class="btn btn--primary" download=""><i class="fas fa-download"></i> Download</a>
            </div>
        </div>


    </div>
</div>

</section>
@endsection
