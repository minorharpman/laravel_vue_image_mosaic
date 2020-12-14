
@extends('layouts.app')
@section("content")

<div class="container">


    <h2>Image list </h2><br><br>

    userid: {{$changeuserid}}


      <imagelist-component  workuri="{{url('/')}}" setuserid="{{$changeuserid}}" ></imagelist-component>
</div>
@stop
