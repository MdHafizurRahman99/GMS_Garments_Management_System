<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="icon" href=" {{ asset('front-end') }}/img/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href=" {{ asset('front-end') }}/css/bootstrap.min.css">
    <!-- animate CSS -->
    <link rel="stylesheet" href=" {{ asset('front-end') }}/css/animate.css">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href=" {{ asset('front-end') }}/css/owl.carousel.min.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href=" {{ asset('front-end') }}/css/all.css">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href=" {{ asset('front-end') }}/css/flaticon.css">
    <link rel="stylesheet" href=" {{ asset('front-end') }}/css/themify-icons.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href=" {{ asset('front-end') }}/css/magnific-popup.css">
    <!-- swiper CSS -->
    <link rel="stylesheet" href=" {{ asset('front-end') }}/css/slick.css">
    <!-- style CSS -->
    <link rel="stylesheet" href=" {{ asset('front-end') }}/css/style.css">
    @yield('css')
</head>

<body>
    <!--::header part start::-->
    <header class="main_menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand main_logo" href="{{ route('/') }}">
                            <img src=" {{ asset('front-end') }}/img/logo.png" alt="logo">
                        </a>
                        <a class="navbar-brand single_page_logo" href="{{ route('/') }}">

                            <img src=" {{ asset('front-end') }}/img/footer_logo.png" alt="logo">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="menu_icon"></span>
                        </button>

                        <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('/') }}">Home</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" href="features.html">features</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link" href="pricing.html">pricing</a>
                                </li>
                                {{-- <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown"
                                        role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Blog
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="blog.html"> blog</a>
                                        <a class="dropdown-item" href="single-blog.html">Single blog</a>
                                    </div>
                                </li> --}}
                                {{-- <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown1"
                                        role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        pages
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                                        <a class="dropdown-item" href="elements.html">Elements</a>
                                    </div>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link" href="#">News</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Contact</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Help</a>
                                </li>
                            </ul>
                        </div>
                        <a href=" {{ route('login') }} " class="d-none d-sm-block btn_1 home_page_btn">Log in</a>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!--::Header part end::-->

    <!--::banner part start::-->
    <section class="banner_part">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-5">
                    <div class="banner_img d-none d-lg-block">
                        <img src=" {{ asset('front-end') }}/img/banner_img.png" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="banner_text">
                        <div class="banner_text_iner">
                            <h1>Client Onboarding for Accounting Firms</h1>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                sed do eiusmod tempor incididunt ut labore et dolore magna
                                aliqua. Ut enim ad minim veniam.</p>
                            <a href="#" class="btn_2">
                                Get 14 Day Unlimited Free Trial</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src=" {{ asset('front-end') }}/img/animate_icon/Ellipse_7.png" alt=""
            class="feature_icon_1 custom-animation1">
        <img src=" {{ asset('front-end') }}/img/animate_icon/Ellipse_8.png" alt=""
            class="feature_icon_2 custom-animation2">
        <img src=" {{ asset('front-end') }}/img/animate_icon/Ellipse_1.png" alt=""
            class="feature_icon_3 custom-animation3">
        <img src=" {{ asset('front-end') }}/img/animate_icon/Ellipse_2.png" alt=""
            class="feature_icon_4 custom-animation4">
        <img src=" {{ asset('front-end') }}/img/animate_icon/Ellipse_3.png" alt=""
            class="feature_icon_5 custom-animation5">
        <img src=" {{ asset('front-end') }}/img/animate_icon/Ellipse_4.png" alt=""
            class="feature_icon_6 custom-animation6">
    </section>
    <!--::banner part start::-->

    <!--::use sasu part end::-->
    {{-- <section class="use_sasu padding_top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="single_feature">
                        <div class="single_feature_part">
                            <img src=" {{ asset('front-end') }}/img/icon/feature_icon_1.png" alt="">
                            <h4>Fully Secured</h4>
                            <p>Made great fish shall beast, fourth land also Doesn
                                tree without lesser likeness he fruit of called gathering
                                day whose called were have </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single_feature">
                        <div class="single_feature_part">
                            <img src=" {{ asset('front-end') }}/img/icon/feature_icon_2.png" alt="">
                            <h4>Unique Design</h4>
                            <p>Made great fish shall beast, fourth land also Doesn tree
                                without lesser likeness he fruit of called gathering day whose
                                called were have </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single_feature">
                        <div class="single_feature_part">
                            <img src=" {{ asset('front-end') }}/img/icon/feature_icon_3.png" alt="">
                            <h4>A Volunteer</h4>
                            <p>Made great fish shall beast, fourth land also Doesn tree without
                                lesser likeness he fruit of called gathering day whose called were have </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src=" {{ asset('front-end') }}/img/animate_icon/Ellipse_1.png" alt=""
            class="feature_icon_1 custom-animation1">
    </section> --}}
    <!--::use sasu part end::-->

    <!--::about_us part start::-->
    <section class="about_us section_padding">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6 col-lg-5">
                    <div class="about_us_text">
                        <img src=" {{ asset('front-end') }}/img/icon/Icon_1.png" alt="">
                        <h2>Easy To <br>
                            Access Social Media</h2>
                        <p>Saw shall light. Us their to place had creepeth day
                            night great wher appear to. Hath, called, sea called,
                            gathering wherein open make living Female itself
                            gathering man. Waters and, two. Bearing. Saw she'd
                            all let she'd lights abundantly blessed.</p>
                        <a href="#" class="btn_2">learn more</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="learning_img">
                        <img src=" {{ asset('front-end') }}/img/about_img.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <img src=" {{ asset('front-end') }}/img/animate_icon/Ellipse_4.png" alt=""
            class="feature_icon_1 custom-animation1">
    </section>
    <!--::about_us part end::-->

    <!--::about_us part start::-->
    <section class="about_us right_time">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6 col-lg-6">
                    <div class="learning_img">
                        <img src=" {{ asset('front-end') }}/img/about_img_1.png" alt="">
                    </div>
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="about_us_text">
                        <img src=" {{ asset('front-end') }}/img/icon/Icon_2.png" alt="">
                        <h2>With efficiency to
                            unlock more opportunities</h2>
                        <p>Saw shall light. Us their to place had creepeth day
                            night great wher appear to. Hath, called, sea called,
                            gathering wherein open make living Female itself
                            gathering man. Waters and, two. Bearing. Saw she'd
                            all let she'd lights abundantly blessed.</p>
                        <a href="#" class="btn_2">learn more</a>
                    </div>
                </div>
            </div>
        </div>
        <img src=" {{ asset('front-end') }}/img/animate_icon/Ellipse_5.png" alt=""
            class="feature_icon_2 custom-animation2">
    </section>
    <!--::about_us part end::-->

    <!--::pricing part start::-->
    <section class="pricing_part section_padding home_page_pricing">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_tittle text-center">
                        <h2>Simple Pricing</h2>
                        <p>Life firmament under them evening make after called dont
                            saying likeness isn't wherein also forth she'd air two without</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="single_pricing_part">
                        <img src=" {{ asset('front-end') }}/img/icon/pricing_icon_1.png" alt="">
                        <p>Standard</p>
                        <h3>$50.00 <span>/ mo</span></h3>
                        <ul>
                            <li>2GB Bandwidth</li>
                            <li>Two Account</li>
                            <li>15GB Storage</li>
                            <li>Sale After Service</li>
                            <li>3 Host Domain</li>
                            <li>24/7 Support</li>
                        </ul>
                        <a href="#" class="pricing_btn">Purchase Now</a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_pricing_part">
                        <img src=" {{ asset('front-end') }}/img/icon/pricing_icon_2.png" alt="">
                        <p>Business</p>
                        <h3>$50.00 <span>/ mo</span></h3>
                        <ul>
                            <li>2GB Bandwidth</li>
                            <li>Two Account</li>
                            <li>15GB Storage</li>
                            <li>Sale After Service</li>
                            <li>3 Host Domain</li>
                            <li>24/7 Support</li>
                        </ul>
                        <a href="#" class="pricing_btn">Purchase Now</a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_pricing_part">
                        <img src=" {{ asset('front-end') }}/img/icon/pricing_icon_3.png" alt="">
                        <p>Premium</p>
                        <h3>$60.00 <span>/ mo</span></h3>
                        <ul>
                            <li>2GB Bandwidth</li>
                            <li>Two Account</li>
                            <li>15GB Storage</li>
                            <li>Sale After Service</li>
                            <li>3 Host Domain</li>
                            <li>24/7 Support</li>
                        </ul>
                        <a href="#" class="pricing_btn">Purchase Now</a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_pricing_part">
                        <img src=" {{ asset('front-end') }}/img/icon/pricing_icon_4.png" alt="">
                        <p>Ultimate</p>
                        <h3>$80.00 <span>/ mo</span></h3>
                        <ul>
                            <li>2GB Bandwidth</li>
                            <li>Two Account</li>
                            <li>15GB Storage</li>
                            <li>Sale After Service</li>
                            <li>3 Host Domain</li>
                            <li>24/7 Support</li>
                        </ul>
                        <a href="#" class="pricing_btn">Purchase Now</a>
                    </div>
                </div>
            </div>
        </div>
        <img src=" {{ asset('front-end') }}/img/animate_icon/Ellipse_2.png" alt=""
            class="feature_icon_2 custom-animation2">
    </section>
    <!--::pricing part end::-->

    <!--::about_us part start::-->
    <section class="review_part padding_bottom">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6 col-lg-6">
                    <div class="review_img">
                        <img src=" {{ asset('front-end') }}/img/review_bg.png" alt="">
                    </div>
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="review_slider owl-carousel">
                        <div class="review_part_text">
                            <h2>With efficiency to
                                unlock more opportunities</h2>
                            <p>Saw shall light. Us their to place had creepeth day
                                night great wher appear to. Hath, called, sea called,
                                gathering wherein open make living Female itself
                                gathering man. Waters and, two. Bearing. Saw she'd
                                all let she'd lights abundantly blessed.</p>
                            <h3>Mitchel Jeferson, <span>CEO of softking</span> </h3>
                        </div>
                        <div class="review_part_text">
                            <h2>With efficiency to
                                unlock more opportunities</h2>
                            <p>Saw shall light. Us their to place had creepeth day
                                night great wher appear to. Hath, called, sea called,
                                gathering wherein open make living Female itself
                                gathering man. Waters and, two. Bearing. Saw she'd
                                all let she'd lights abundantly blessed.</p>
                            <h3>Mitchel Jeferson, <span>CEO of softking</span> </h3>
                        </div>
                        <div class="review_part_text">
                            <h2>With efficiency to
                                unlock more opportunities</h2>
                            <p>Saw shall light. Us their to place had creepeth day
                                night great wher appear to. Hath, called, sea called,
                                gathering wherein open make living Female itself
                                gathering man. Waters and, two. Bearing. Saw she'd
                                all let she'd lights abundantly blessed.</p>
                            <h3>Mitchel Jeferson, <span>CEO of softking</span> </h3>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <img src=" {{ asset('front-end') }}/img/animate_icon/Ellipse_4.png" alt=""
            class="feature_icon_2 custom-animation2">
    </section>
    <!--::about_us part end::-->

    <!--::subscribe us part end::-->
    <section class="subscribe_part padding_bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="subscribe_part_text text-center">
                        <h2>Experience the most simple way to <br>
                            manage business</h2>
                        <div class="subscribe_form">
                            <form action="#">
                                <div class="form-row">
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" placeholder="enter your email">
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="subscribe_btn">
                                            <div class="btn_2 d-block">free trail</div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src=" {{ asset('front-end') }}/img/animate_icon/Ellipse_5.png" alt=""
            class="feature_icon_2 custom-animation2">
    </section>
    <!--::subscribe us part end::-->

    <!--::client logo part end::-->
    {{-- <section class="client_logo">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="client_logo_slider owl-carousel d-flex justify-content-between">
                        <div class="single_client_logo">
                            <img src=" {{ asset('front-end') }}/img/client_logo/client_logo_1.png" alt="">
                        </div>
                        <div class="single_client_logo">
                            <img src=" {{ asset('front-end') }}/img/client_logo/client_logo_2.png" alt="">
                        </div>
                        <div class="single_client_logo">
                            <img src=" {{ asset('front-end') }}/img/client_logo/client_logo_3.png" alt="">
                        </div>
                        <div class="single_client_logo">
                            <img src=" {{ asset('front-end') }}/img/client_logo/client_logo_4.png" alt="">
                        </div>
                        <div class="single_client_logo">
                            <img src=" {{ asset('front-end') }}/img/client_logo/client_logo_5.png" alt="">
                        </div>
                        <div class="single_client_logo">
                            <img src=" {{ asset('front-end') }}/img/client_logo/client_logo_1.png" alt="">
                        </div>
                        <div class="single_client_logo">
                            <img src=" {{ asset('front-end') }}/img/client_logo/client_logo_2.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!--::client logo part end::-->

    <!--::footer_part start::-->
    <footer class="footer_part">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-4 col-lg-4">
                    <div class="single_footer_part">
                        <a href="{{ route('/') }}" class="footer_logo_iner"> <img
                                src=" {{ asset('front-end') }}/img/footer_logo.png" alt="#"> </a>
                        <p>Gathered. Under is whose you'll to make years is mat lights thing together fish made
                            forth thirds cattle behold won't. Fourth creeping first female.
                        </p>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-2">
                    <div class="single_footer_part">
                        <h4>About Us</h4>
                        <ul class="list-unstyled">
                            <li><a href="">Managed Website</a></li>
                            <li><a href="">Manage Reputation</a></li>
                            <li><a href="">Power Tools</a></li>
                            <li><a href="">Marketing Service</a></li>
                            <li><a href="">Customer Service</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-2">
                    <div class="single_footer_part">
                        <h4>Quick Links</h4>
                        <ul class="list-unstyled">
                            <li><a href="">Store Hours</a></li>
                            <li><a href="">Brand Assets</a></li>
                            <li><a href="">Investor Relations</a></li>
                            <li><a href="">Terms of Service</a></li>
                            <li><a href="">Privacy & Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-2">
                    <div class="single_footer_part">
                        <h4>My Account</h4>
                        <ul class="list-unstyled">
                            <li><a href="">Press Inquiries</a></li>
                            <li><a href="">Media Directories</a></li>
                            <li><a href="">Investor Relations</a></li>
                            <li><a href="">Terms of Service</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4 col-md-3 col-lg-2">
                    <div class="single_footer_part">
                        <h4>Resources</h4>
                        <ul class="list-unstyled">
                            <li><a href="">Application Security</a></li>
                            <li><a href="">Software Policy</a></li>
                            <li><a href="">Supply Chain</a></li>
                            <li><a href="">Agencies Relation</a></li>
                            <li><a href="">Manage Reputation</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-8">
                    <div class="copyright_text">
                        <P><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | This template is made with <i
                                class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com"
                                target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </P>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="footer_icon social_icon">
                        <ul class="list-unstyled">
                            <li><a href="#" class="single_social_icon"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li><a href="#" class="single_social_icon"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" class="single_social_icon"><i class="fas fa-globe"></i></a></li>
                            <li><a href="#" class="single_social_icon"><i class="fab fa-behance"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--::footer_part end::-->

    <!-- jquery plugins here-->
    <script src=" {{ asset('front-end') }}/js/jquery-1.12.1.min.js"></script>
    <!-- popper js -->
    <script src=" {{ asset('front-end') }}/js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src=" {{ asset('front-end') }}/js/bootstrap.min.js"></script>
    <!-- easing js -->
    <script src=" {{ asset('front-end') }}/js/jquery.magnific-popup.js"></script>
    <!-- swiper js -->
    <script src=" {{ asset('front-end') }}/js/swiper.min.js"></script>
    <!-- swiper js -->
    <script src=" {{ asset('front-end') }}/js/masonry.pkgd.js"></script>
    <!-- particles js -->
    <script src=" {{ asset('front-end') }}/js/owl.carousel.min.js"></script>
    <script src=" {{ asset('front-end') }}/js/jquery.nice-select.min.js"></script>
    <!-- slick js -->
    <script src=" {{ asset('front-end') }}/js/slick.min.js"></script>
    <script src=" {{ asset('front-end') }}/js/jquery.counterup.min.js"></script>
    <script src=" {{ asset('front-end') }}/js/waypoints.min.js"></script>
    <script src=" {{ asset('front-end') }}/js/contact.js"></script>
    <script src=" {{ asset('front-end') }}/js/jquery.ajaxchimp.min.js"></script>
    <script src=" {{ asset('front-end') }}/js/jquery.form.js"></script>
    <script src=" {{ asset('front-end') }}/js/jquery.validate.min.js"></script>
    <script src=" {{ asset('front-end') }}/js/mail-script.js"></script>
    <!-- custom js -->
    <script src=" {{ asset('front-end') }}/js/custom.js"></script>

    @yield('js')
</body>

</html>
