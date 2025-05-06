@extends('web.layouts.master')


@section('content')


    <div class="content-section" style="flex:5;">
        <section class="report-form w-50 mx-auto p-tb-60" style="display:flex;flex-direction:column;align-items:center;">
            {{-- <h2 class="m-b-20">Validate Your IRL Report</h2> --}}
            <h1 style="text-align:center;">Welcome <img style="max-width:11%;height:auto;margin-top:-5px;" src="{{ asset('web/images/hand.png') }}" alt="not found">
            </h1>
            <img src="http://irl.rudrakshalab.com/web/images/logo.png" alt="" style="width:100px;">
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
                <div class="form-inner" style="display:flex;flex-direction:column;margin-top:20px;gap:20px;">
                    <div class="field" style="display:flex;">
                    <input type="number" required class="form-control" name="irl_no" placeholder="Enter IRL no"
                        id="irl_no">
                    <input type="text" required class="form-control" name="email_phone"
                        placeholder="Email Address / Phone Number" id="email_phone">
                    </div>
                    <div class="form-button" style="display:flex;justify-content:center;">
                    <button type="submit" class="btn btn--primary btn--large" style="background-color:#488CD3; ">Validate</button>
                    </div>
                </div>
                <small id="" class="form-text text-muted text-style-italic"> <i
                        class="fas fa-info-circle fa-info-circle--custom"></i>Reports Generated Prior to 2022 might not be
                    traceable in the system, Please email IRl for verification
                </small>
            </form>
        </section>
        <!--
    <section class="tests tests--bg p-tb-60">
        <div class="container">
            <div class="heading text-center m-b-60">
                <h2 class="d-inline-block m-b-0">Our Tests</h2>
            </div>
            <div class="row">
                <div class="col-md-3 col-lg-3">
                    <a href="">
                        <div class="card">
                            <img src="web/images/img1.jpg" alt="">
                            <div class="card-body">
                                <h3> 13 Mukhi Gauri Shankar</h3>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-md-3 col-lg-3">
                    <a href="">
                        <div class="card">
                            <img src="web/images/img2.jpg" alt="">
                            <div class="card-body">
                                <h3> 13 Mukhi Rudraksha</h3>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-md-3 col-lg-3">
                    <a href="">
                        <div class="card">
                            <img src="web/images/img3.jpg" alt="">
                            <div class="card-body">
                                <h3> 13 Mukhi Collector</h3>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-md-3 col-lg-3">
                    <a href="">
                        <div class="card">
                            <img src="web/images/img4.jpg" alt="">
                            <div class="card-body">
                                <h3> 13 Mukhi Medium</h3>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </section> -->

        <section class="announcement p-tb-60">
            <div class="container">
                <div class="heading text-center m-b-60">
                    <h2 class="d-inline-block m-b-0">Important Announcement</h2>
                </div>
                <div class="announcement__text">
                    IRL customers are advised to be extra cautious of fake reports generated using IRL's Name.
                    Please validate your report through our website or email us.
                </div>

            </div>
        </section>
    </div>
</div>
@endsection
