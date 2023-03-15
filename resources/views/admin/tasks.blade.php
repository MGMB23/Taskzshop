@extends('layouts.master')

@section('title')
    Tasks
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
    use App\Models\Taskuser;
@endphp

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title fs-5" id="exampleModalLabel" style="color:#122E50;font-weight:600;">New Task</h4>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
      </div>
      <form action="/save-task" methode="POST">
        {{csrf_field()}}
      <div class="modal-body">
          <div class="mb-3 ">
            <label for="recipient-name" class="col-form-label" style="font-weight:500; border-radius 5px;">Name:</label>
            <input type="text" name="name" class="form-control border rounded-0" id="recipient-name" required>
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label" style="font-weight:500;">Description:</label>
            <textarea name="descriptrion" class="editor border  rounded" id="editor" cols="30" rows="10"></textarea>
          </div>
          <div class="mb-3">
            <label for="prize-text" class="col-form-label" style="font-weight:500;">Prize:</label>
            <input class="form-control border rounded-0" name="prize" id="message-text" type="number" min ="0" required>
          </div>
          <div class="mb-3">
            <label for="prize-text" class="form-select" style="font-weight:500;">Assign To:</label>
            <select name="users_id[]" id="choices-multiple-remove-button" multiple>
                <option value="">ALL</option>
                @foreach ($users as $row)
                    <option value="{{$row->id}}">{{ $row->name }}</option>
                @endforeach
            </select>
          </div>
      </div>


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
    </form>
    </div>
  </div>
</div>
@if($user->usertype  == "admin")
    @foreach ($tasks as $data)
        <div class="modal fade" id="exampleModal{{$data->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$data->id}}" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5 text-danger" id="exampleModalLabel{{$data->id}}" style="color:#122E50;font-weight:600;">Users</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
                </div>
                <form action="/save-task" methode="POST">
                    {{csrf_field()}}
                    <div class="modal-body">
                        @if($data->users  == NULL)
                            <div class="mb-3 text-center text-success">
                                <label for="recipient-name" class="col-form-label" style="font-weight:500; border-radius 5px;">
                                    No user exists for this Task
                                </label>
                            </div>
                        @else
                            @php $comp = 1 @endphp
                            @foreach ($data->users as $us)
                                <div class="mb-3 text-center text-success">
                                    <label for="recipient-name" class="col-form-label" style="font-weight:500; border-radius 5px;">
                                        {{$comp++}} - {{User::where('id',$us)->first()->name}}
                                    </label>
                                    <hr>
                                </div>
                            @endforeach

                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    @endforeach
@endif
<div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Task</h4>
                @if($user->usertype =="admin")
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">New Task</button>
                @endif
              </div>
            @if($user->usertype  == "admin")
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                        <th class="text-dark" style="font-weight:600">Name</th>
                        <th class="text-dark" style="font-weight:600">Decription</th>
                        <th class="text-dark" style="font-weight:600">Prize</th>
                        <th class="text-dark" style="font-weight:600">Completed</th>
                        <th class="text-dark" style="font-weight:600">Users</th>
                        </thead>
                        <tbody>
                        @foreach ($tasks as $data)
                        <tr class="TR{{$data->id}}">
                            <td style="font-weight:400">{{$data->Name}}</td>
                            <td >{!! $data->Description !!}</td>
                            <td style="font-weight:400">{{$data->prize}}</td>
                            @if($data->completed  == 0)
                                <td style="font-weight:400">Not Complete</td>
                            @else
                                <td style="font-weight:400">Completed</td>
                            @endif

                            <td style="font-weight:400">
                                <a type="button" class="btn text-white"  data-toggle="modal" data-target="#exampleModal{{$data->id}}">Users</a>
                            </td>

                            <td class="text-right" style="font-weight:400"></td>
                            <td style="font-weight:400">
                                <a href="{{url('taskusers/'.$data->id)}}" class="btn btn-warning">Users Proof</a>
                            </td>
                            <td>
                                <a href="{{url('tasks/'.$data->id)}}" class="btn btn-success">Edit</a>
                            </td>
                            <td>
                                <a class="btn btn-danger text-white" id="DeleteButton{{$data->id}}" data-id-task="{{$data->id}}">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            @else
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                        <th>Name</th>
                        <th>Decription</th>
                        <th>Prize</th>
                        </thead>
                        <tbody>
                        @foreach ($tasks as $data)
                            @php $checked = 0; @endphp
                            @if($data->users  != NULL)
                                @foreach($data->users as $us)
                                    @if($user->id == $us)
                                        @php $checked = 1; @endphp
                                    @endif
                                @endforeach
                            @endif

                            @if($checked == 1)
                                @php
                                    $check = Taskuser::where('uid',$user->id)->where('tid',$data->id)->first();
                                @endphp
                                @if($check == NULL)
                                    <tr>
                                @else
                                    <tr class="">
                                @endif
                                <td>{{$data->Name}}</td>
                                <td>{!! $data->Description !!}</td>
                                <td>{{$data->prize}}</td>
                                <td class="text-right"></td>
                                @if($check == NULL)
                                    <td>
                                        <a href="{{url('tasks2/'.$data->id)}}" class="btn btn-success">Add Proof</a>
                                    </td>
                                @else
                                    <td>
                                    </td>
                                @endif
                            @endif
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            @endif
            </div>
          </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

<script>
    $(document).ready(function(){
     var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
        removeItemButton: true,
        maxItemCount:5,
        searchResultLimit:5,
        renderChoiceLimit:5
      });
 });
</script>
 <!-- Script -->
 <script>
   ClassicEditor.create( document.querySelector( '#editor' ), {
        ckfinder    : { uploadUrl: '{{route("image.upload")."?_token=".csrf_token()}}',}
    }).catch( error => {
        console.error( error );
    });
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
<script>
    const items = @json($tasks);

        for (var i = 0; i < items.length; i++) {
            $('#DeleteButton'+items[i].id).unbind().on('click', event => {
                console.log(event.currentTarget.dataset.idTask)
                Swal.fire({
                        title: 'êtes-vous sûr?',
                        text: "Vous souhaitez supprimer Task",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, Supprimer!'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                'url' : '{{ route('task-supprimer')}}',
                                'type' : 'POST',
                                data : {'id_task':event.currentTarget.dataset.idTask,'_token' : '{{ csrf_token() }}' },
                                success : function(data){
                                    // console.log(data)
                                    $(".TR"+data.id_task ).children().remove();
                                    Swal.fire(
                                    'Supprimé avec succès!',
                                    "l'utilisateur a été supprimé avec succès",
                                    'success'
                                    )
                                },
                                error: function () {
                                    sweetAlertMsg("error","Please Try Again !!")
                                }
                            });
                    }
                })
                event.preventDefault();
            });
        }

    </script>
    <script>
        // alert message
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
                title: '<small>'+msg+'</small>',
            });
        }
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
