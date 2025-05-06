<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ mix('web/vendor.css') }}">
    <link rel="stylesheet" href="{{ mix('web/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon-16x16.png') }}">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <title>IRL - International Rudraksha Laboratory</title>
    <style>
        .container-1 {
            display: flex;
            flex-wrap: nowrap;
            justify-content: center;
            align-items: center;
        }

        .header{
            border: 1px solid #c2a718;
        }
        .copyright{
            margin-top:4px;
            border-top:1px solid #c2a718;
        }
        .menu-section{
            border-right:1px solid #c2a718;
        }
@media (max-width: 992px) {
    .col-12 {
        padding-left:0 !important;
    }
}

        .col-12 {
            padding-left: 200px;
        }
        .sidemenu a{
            cursor:pointer;
            color: white;
            padding:20px;
            border-bottom:1px solid gray;
        }
        .sidemenu a:hover{
            background-color: gray;
            font-size:20px;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header__middle">
            <div class="registration">
                <img src="../web/images/nepal.svg" alt="not found">
                {{-- <span>Registration No: 1283720-19283</span> --}}
            </div>
            <div class="container container-1">
                <div class="row  d-flex align-items-center">

                    <div class="col-12 col-md-8 col-lg-8">
                        <a href="{{ url('/') }}" class="logo">

                            {{-- <img src="{{ asset ('web/images/logo.png') }}" alt=""> --}}
                            <div>
                                <span>अन्तर्राष्ट्रिय रुद्राक्ष प्रयोगशाला</span>
                                <span class="logo-text">International Rudraksha Laboratory</span>
                                {{-- <div class="iso">"World's only Rudraksha specific ISO-9001 Certified Rudraksha Laboratory"</div> --}}
                            </div>

                        </a>

                    </div>
                    {{-- <div class="col-12 col-md-4 col-lg-4">
                        <div class="registration justify-content-end d-flex">
                            <img src="web/images/nepal.svg" alt="">
                            <span>Registration No: 1283720-19283</span>
                        </div>
                        <div class="navigation justify-content-end d-flex">
                            <li><a href="/validate-report" class="btn btn-nav">Validate Report</a></li>
                            <li><a href="/contact-us">Contact Us</a></li>


                        </div>
                    </div> --}}

                </div>


            </div>
        </div>

    </header>
    <div class="section-container" style="display:flex;flex-direction:row;">
        <div class="menu-section" style="flex:1;background-color:#488CD3;">
            <section class="sidemenu" style="display:flex;flex-direction:column;">
                <a href="{{ route('web.index') }}"><span>Report Check</span></a>
                <a href="{{ route('web.information') }}"><span>Information</span></a>
                <a href="{{ route('web.contact') }}"><span>Contact Us</span></a>

            </section>
        </div>

        @yield('content')
    </div>

    <div style="background:#488CD3;" class="copyright" style="z-index:2;">
        <div class="container">
            <p>All Rights Reserved | &copy; Copyright {{ date('Y') }} | International Rudraksha Laboratory
            </p>
        </div>
    </div>

    <script src="{{ asset('web/main.js') }}"></script>

</body>

</html>
