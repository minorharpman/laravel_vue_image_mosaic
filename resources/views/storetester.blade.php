@extends('layouts.app')

@section('content')


<div class="container-fluid">
  <div class="row">



          {!! Form::open(['action' => 'ImageController@store', 'method' => 'post', 'files' => true]) !!}




          <div class="form-group">
            {{ Form::label('image', 'Image (PNG, JPG, 440px x 200px), Max image size: KB:') }} {{ Form::file('image',array('class' => 'form-control'))
            }}
          </div>


          {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }} {!! Form::close() !!}


  </div>
</div>

@endsection
