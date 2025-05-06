@extends('web.layouts.master')
@section('content')
    <div class="content-section" style="margin-top:50px;flex:5;align-items:center;justify-content:center;">
        <section>
            <div style="display:flex;flex-direction:column;">
                <h1 style="flex:1;text-align:center;margin-bottom:50px;">How to count the Mukhi</h1>
                <div style="display:flex;flex-direction:column;">
                    <h2 style="text-align: center;margin-bottom:50px;">Steps to count mukhi</h2>
                    <div style="display:flex;flex-direction:column;justify-content:center;align-items:center">
                        <div style="width:600px">
                            <p><b>Step 1 : </b>Clean the Rudraksha bead to remove dirt.</p>
                            <p><b>Step 2 : </b>Examine the bead under good lighting or with a magnifying glass.</p>
                            <p><b>Step 3 : </b>Identify the starting groove where Mukhi lines begin.</p>
                            <p><b>Step 4 : </b>Rotate the bead and count each vertical Mukhi line.</p>
                        </div>
                    </div>
                </div>
                <div style="display:flex;flex:1;justify-content:center;"><img style="width:500px;"
                        src="{{ asset('/web/images/label-19.png') }}" alt="not found"></div>
            </div>

        </section>
    </div>
@endsection
