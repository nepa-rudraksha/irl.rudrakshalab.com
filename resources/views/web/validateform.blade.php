@extends('web.layouts.master')


@section('content')

<section class="report-form w-50 mx-auto p-tb-60">
    <h2 class="m-b-20">Validate Your IRL Report</h2>
    @if ($errors->any())
    <div class="alert alert-warning alert-dismissible">    
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="/generate-report" method="POST">
        @honeypot
        @csrf
        <div class="form-inner">
            <input type="number" required class="form-control" name="irl_no" placeholder="Enter IRL no" id="irl_no">
            <input type="text" required class="form-control" name="email_phone" placeholder="Email Address / Phone Number" id="email_phone">
            <button type="submit" class="btn btn--primary btn--large">Validate</button>
        </div>
        <small id="" class="form-text text-muted text-style-italic"> <i class="fas fa-info-circle fa-info-circle--custom"></i>Reports Generated Prior to 2022 might not be
            tracable in the system, Please email IRl for verification
        </small>
    </form>
</section>
@endsection