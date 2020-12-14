
@extends('layouts.app')
@section("content")

<div class="container">



    <h2>Image list</h2><br><br>

    <table class="table">
        <tbody>
            <tr>
                <td>
                    <b>image</b>
                </td>


            </tr>
            @foreach($images as $image)
            <tr>
                <td>
             {{$image->image_name}}  <img src="{{url('images',$image->image_name)}}" >
                </td>



            </tr>

            @endforeach

        </tbody>
    </table>

</div>
@stop
