@extends('layouts.master')

@section('title')
    Task Users
@endsection
@section('head')
<script charset="utf-8" src="//cdn.iframe.ly/embed.js?api_key='bcfe2a7e3f555da6eb4a63'"></script>
<script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<style>
.card .image {
    width: 100px;
    height: 100px;
}
</style>
@endsection
@section('content')
@php
    use App\Models\User;
    use App\Models\Tasks;
    $last_complTask = Tasks::latest('updated_at')->where('completed','1')->take(5)->get();

@endphp

<div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Task Users</h4>
              </div>

            <div class="card-body">
                <div class="table-responsive">
                <table class="table">
                    <thead class=" text-primary">
                    <th>Task</th>
                    <th>User</th>
                    <th>Proof</th>
                    <th>Link</th>
                    <th>Status</th>
                    </thead>
                    <tbody>
                    @foreach ($taskusers as $data)
                        @php $cpt = 0; @endphp

                        <tr>
                            <td>{{ Tasks::where('id',$data->tid)->first()->Name}}</td>
                            <td>{{ User::where('id',$data->uid)->first()->name}}</td>
                            <td >{!! $data->files !!}</td>

                            @if($data->link == NULL)
                                <td></td>
                            @else
                                <td><a href="{{$data->link}}" target="_blank"  class="btn btn-dark">{{$data->link}}</a></td>
                            @endif
                            @if($data->status == 0)
                                <td ><a class="btn btn-success" id="status{{$data->id}}" data-id="{{$data->id}}" data-status="encours">En cours</a></td>
                            @else
                                <td ><a class="btn btn-success" id="status{{$data->id}}" data-id="{{$data->id}}" data-status="valider">Valider</a></td>
                            @endif

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>

            </div>
          </div>
        </div>

@endsection

@section('script')
<script>

    const taskUsers = @json($taskusers);

    taskUsers.forEach(task =>
        $('#status'+task.id).on('click', eventTasks => {
            var id = $(eventTasks.currentTarget).data('id');
            var status = $(eventTasks.currentTarget).data('status');

            $.ajax({
                    'url': '{{ route('status') }}',
                    'type': 'POST',
                    data: {
                        'id' : id,
                        'status' : status,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if(data.status == "valider"){
                            $('#status'+data.id).data('status', data.status);
                            document.getElementById("status"+data.id).innerText         = "Valider";
                        }
                        if(data.status == "encours"){
                            $('#status'+data.id).data('status', data.status);
                            document.getElementById("status"+data.id).innerText         = "En cours";
                        }
                    },
                    error: function () {
                        sweetAlertMsg("error","Veuillez réessayer !!")
                    }
            })

            console.log(id,status);
            eventTasks.preventDefault();
        })
    );

</script>
<script>
    function sweetAlertMsg(icon, msg) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: icon,
            title: '<small>' + msg + '</small>',
        });
    }
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll( 'div[data-oembed-url]' ).forEach( element => {
        // Discard the static media preview from the database (empty the <div data-oembed-url="...">).
        while ( element.firstChild ) {
            element.removeChild( element.firstChild );
        }

        // Generate the media preview using Iframely.
        iframely.load( element, element.dataset.oembedUrl ) ;
    } );
    document.querySelectorAll( 'oembed[url]' ).forEach( element => {
        console.log(element, element.attributes.url.value)
        iframely.load( element, element.attributes.url.value );
    } );

    document.querySelectorAll( 'oembed[url]' ).forEach( element => {
        // Create the <a href="..." class="embedly-card"></a> element that Embedly uses
        // to discover the media.
        const anchor = document.createElement( 'a' );

        anchor.setAttribute( 'href', element.getAttribute( 'url' ) );
        anchor.className = 'embedly-card';

        element.appendChild( anchor );
    } );
</script>
@endsection
