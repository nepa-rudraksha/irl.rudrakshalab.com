@extends('web.layouts.master')
@section('content')
<style>
    .contact-icons i{
        background:#488CD3;
    }
</style>
<div class="content-section" style="flex:5;">
<section class="main p-tb-60">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="contact-box">
                    <h2>Get In Touch</h2>

                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    <p>Thank you very much for your interest in our company and our services and if you have any questions, please write us a message now!</p>
                    <form class="contact-form m-t-20" method="post" action="/contact-us">
                        @csrf
                        @honeypot
                        <div class="form-row">
                            <div class="form-group col-md-6">

                                <input type="text" class="form-control" required name="first_name" id="first_name" placeholder="First Name">
                            </div>
                            <div class="form-group col-md-6">

                                <input type="text" class="form-control" required name="last_name" id="last_name" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">

                                <input type="email" class="form-control" required name="email" id="email" placeholder="Email Address">
                            </div>
                            <div class="form-group col-md-6">

                                <input type="phone" class="form-control" required name="phone_number" id="phoneNumber" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">

                                <textarea class="form-control" required name="message" id="message" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <button style="background-color:#488CD3;" type="submit" class="btn btn--primary
                                w-100">Message</button>
                    </form>

                </div>
            </div>
            <div class="col-md-6 col-lg-6">

                <div class="contact-icons">
                    <h2 class="m-b-40">Contact Details</h2>
                    {{-- <div class="media">
                        <div class="contact-icon mr-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="media-body">
                            <h3>Office Address</h3>
                            <p>
                                273/14 Kha Bajreshowri Marg, Gaushala, Kathmandu, Nepal
                            </p>
                        </div>
                    </div> --}}
{{-- 
                    <div class="media">
                        <div class="contact-icon mr-3">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="media-body">
                            <h3>Phone Number</h3>
                            <p>01-5241176</p>
                        </div>
                    </div> --}}
                    <div class="media">
                        <div class="contact-icon mr-3">
                            <i class="far fa-envelope"></i>
                        </div>
                        <div class="media-body">
                            <h3>Email Address</h3>
                            <p><a href="mailto:info@rudrakshalab.com">info@rudrakshalab.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="t-map m-t-40">
            <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3531.865911998582!2d85.34401771443474!3d27.721426031481307!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb1965a381634d%3A0xffd4205d0a82a2b!2zQ2hhcnVtYXRpIEJoYXdhbiwgR29waWtyaXNobmEsIOCkmuCkleCljeCksOCkquCkpSwg4KSV4KS-4KSg4KSu4KS-4KSh4KWM4KSBIDQ0NjAw!5e0!3m2!1sne!2snp!4v1631865629010!5m2!1sne!2snp" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
        </section>


    </div>
</div>

</section>
@endsection
