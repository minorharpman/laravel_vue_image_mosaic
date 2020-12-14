@extends('layouts.app')


@section('content')


 <div class="row">
    <!--   -->
<div class="col-sm-9 ml-sm-auto pt-3" >
    <h3>Demo Mosaics - Site owner gallery</h3>
    <p>Only the demo pictures are appeared here.</p>

</div>
 </div>
  <div class="row">

        @forelse($mosaics as $mosaic)

           <div class="col-sm" >


          <a href="{{url('mosaic',$mosaic ->image_name)}}" target="_blank">  <img src="{{url('mosaic','thumbnail_'.$mosaic ->image_name)}}" > </a>
         @if(Auth::check() && Auth::user()->id ==1)         <a href="{{url('/mosaic/delete/'.$mosaic->id)}}"  target="_blank" >Delete {{$mosaic->id}}</a>  @endif
          <br><br><br>

            </div>


        @empty

        <h3>No mosaic</h3>

        @endforelse


</div>


 <div class="row">
  <div class="col-sm-6 mx-auto">

<h2> Instagram: <a href="https://www.instagram.com/zsoltkunsagi" target="_blank"> CLICK! </a>  </h2>

  <!--
   <h3>Tutorial: effects and setting</h3>

<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/OFbPzWNUEK8?rel=0" allowfullscreen></iframe>
</div>
-->
</div>
<!--
 <div class="col-sm-6 mx-auto">
   <h3><a href="https://www.youtube.com/channel/UCifroWdPFT9Ih1aqQMAUmuw/videos" target="_blank" style="text-decoration: underline;">My Youtube Channel: Mosaic Video </a></h3>

<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/GxqjXJD3S0o?rel=0" allowfullscreen></iframe>
</div>
</div>
-->

</div>


@endsection
