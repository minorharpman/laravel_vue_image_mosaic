
@extends('layouts.app')
@section("content")

<div class="container">



    <h2>Users' images  </h2><br><br>

    <table class="table">
        <tbody>
            <tr>
                <td>
                    <b>name</b>
                </td>
                <td>
                    <b>email</b>
                </td>

                <td>
                    <b>created</b>
                </td>

                  <td>
                      <b>Pictures</b>
                  </td>

            </tr>
            @foreach($users as $item)

            @if ($item->id !=1)
            <tr>
                <td>
                    {{$item->name}}

                </td>
                <td>
                    {{$item->email}}
                </td>
                <td>
                    {{$item->created_at}}
                </td>
                <td>
                    {{$item->pictures}}
                </td>

                                <td>
                    <a class="nav-link" href="{{ url('/admin/imagelist/'.$item->id) }}"> User list </a>
                                </td>

                     <td>
                    <a class="nav-link" href="{{ url('/image/deletenotuserrows/'.$item->id) }}"> Image check </a>
                                </td>

            </tr>

          @endif

            @endforeach

        </tbody>
    </table>

</div>
@stop
