<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- Printerest--->
    <meta name="p:domain_verify" content="ac23c256243e44afe08dded4076c84a9"/>

    <title>{{ config('app.name', 'Laravel') }}, Instagram photo creator</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
     <link href="{{ asset('css/mystyle.css') }}" rel="stylesheet">
</head>
<body>

    <link rel="image_src" href="https://blogbook.hu/laravel_vue_image_mosaic/public/design/balaton_mosaic.png" />

<!-- google banner -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- mosaicpic blogbook oldalon -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9781487221982398"
     data-ad-slot="8781028489"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<!-- banner -->


    <div id="app">
<div class="jumbotron jumbotron-fluid jumbotron-mod"  style="margin:0px;background: #0080ff;color:white;background-image:url({{ asset('design/balaton_mosaic.png') }}); ;  ">
   <a class="navbar-brand" href="{{ url('/') }}" style="color:white;display: block;"><div class="container">
    <h1  style="font-weight:bold;text-shadow: 4px 3px 0 #000;">Free Online  Art Mosaic  Maker  <br> Impress Your Friends with a mosaic or a collage picture.</h1>
    <p class="lead" style="font-weight:bold;" >Instagram photo creator , Mosaic and thumbnail collage maker,  {{ config('app.name', 'Laravel') }} </p>
  </div></a>
</div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark ">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}"  style="display:none;">
                  Instagram photo creator
                </a>   
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                  <li class="nav-item">  <a class="nav-link" href="{{ url('/') }}">Main</a></li>
                 <!-- <li class="nav-item">  <a class="nav-link" target="_blank" href="..">Download</a></li>  -->
                   <li class="nav-item">  <a class="nav-link" href="{{ url('/contact') }}">About</a></li>
                   <li class="nav-item">  <a class="nav-link" href="{{ url('/mosaic/index') }}" >Demo Gallery</a></li>
                   <li class="nav-item">  <a class="nav-link" href="{{ url('/babylon') }}" >3D World</a></li>
                     <li class="nav-item">  <a class="nav-link" href="{{ url('/babylonphysics') }}" >Falling Blocks</a></li>
                     <!-- <li class="nav-item">  <a class="nav-link" href="https://mosaicpic.com/game_like_minecraft_in_webbrowser/index.html"  >Game like Minecraft in Browser</a></li>
                    -->

                 <!--  <li class="nav-item">  <a class="nav-link" href="#" >Main Page</a></li>-->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </li>
                        @else

  @if(Auth::user()->id !=4  && Auth::user()->id !=5)      <a class="nav-link" href="{{ route('changePassword') }}">Change Password </a> @endif
@if (Auth::user()->id == 1)
  <!-- OFF
    <a class="nav-link" href="{{ url('/babylonmine') }}" >Babylon Cube</a>
-->
    <a class="nav-link" href="{{ route('mosaicupload') }}">Mosaic upload </a>
     <a class="nav-link" href="{{ url('/admin/userlist') }}">Admin:Userlist </a>

@endif
                            <li class="nav-item dropdown ">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>




                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>





        <!-- banner -->
<!-- banner end -->


<!-- banner -->

<!-- banner end -->

     <!-- banner -->

     <!-- banner end -->


    </div>
  <!--google banner -->

    <!--google banner -->


<!-- banner -->

<!-- banner -->

<!-- Global site tag (gtag.js) - Google Analytics -->


</body>
</html>
