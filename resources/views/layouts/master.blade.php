<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy Pivovarov aka AngryDeer http://studioweb.pro
 * Date: 29.12.15
 * Time: 16:40
 */?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    @include('header.head')
</head>
<body>
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Add your site or application content here -->
<header id="header" class="">
    {{--@include('header.header')--}}
</header><!-- /header -->
<section>
    {{-- <div class="container"> --}}
    @include('errors.errmsg')
    @yield('body')
    {{-- <p>Hello world! This is HTML5 Boilerplate.</p> --}}
    {{-- </div> --}}
</section>
{{--@include('footer.footer')--}}
@include('footer.foot_script')
</body>
</html>
