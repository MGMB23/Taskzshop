@extends('layouts.master')

@section('title')
    Register
@endsection
@php
        use App\Models\Categorie;
        $categories = Categorie::all();
    @endphp
@section('content')
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">New Users</h1>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
      </div>
      <form action="/add-user" methode="POST">
        {{csrf_field()}}
      <div class="modal-body">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Name:</label>
            <input type="text" name="name" class="form-control border rounded-0" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">email:</label>
            <input type="text" name="email" class="form-control border rounded-0" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Phone:</label>
            <input type="text" name="phone" class="form-control border rounded-0" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="prize-text" class="col-form-label">Password:</label>
            <input type="password" class="form-control border rounded-0" name="password" id="message-text"></input>
          </div>
          <div class= "mb-3">
            <label for="prize-text" class="col-form-label">Categories:</label>
            <select name="categories">
                  @foreach ($categories as $cat)
                      <option value="{{$cat->id}}">{{$cat->namec}}</option>
                  @endforeach
              </select>
          </div>
          <div class= "mb-3">
            <label for="prize-text" class="col-form-label">UserType:</label>
            <select name="usertype">
                <option value="admin">Admin</option>
                <option value="user" selected>User</option>
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
<div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Users</h4>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Users</button>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th class="text-dark" style="font-weight:600">Name</th>
                      <th class="text-dark" style="font-weight:600">Mail</th>
                      <th class="text-dark" style="font-weight:600">Phone</th>
                      <th class="text-dark" style="font-weight:600">UserType</th>
                      <th class="text-dark" style="font-weight:600">Categorie</th>
                    </thead>
                    <tbody>

                      @foreach ($admin as $row)
                        <tr class="TR{{$row->id}}">
                          <td>{{$row->name}}</td>
                          <td>{{$row->email}}</td>
                          <td>{{$row->phone}}</td>
                          <td>{{$row->usertype}}</td>
                          <td></td>
                          <td class="text-right"></td>
                          <td>
                              {{-- <a href="{{ route('users.impersonate', $row->id) }}" class="btn btn-btn-warning" target="_blank">User login</a> --}}
                              {{-- <a href="/logout1/{{$row->id}}" class="btn btn-primary">Login</a> --}}
                          </td>
                          <td>
                              <a href="/role-edit/{{$row->id}}" class="btn btn-success">Edit</a>
                          </td>
                          <td>
                              {{-- <form action="/role-del/{{$row->id}}" method="POST">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}
                                  <button type="submite" class="btn btn-danger">Delete</button>
                              </form> --}}
                              {{-- <a class="btn btn-danger text-white" id="DeleteButton{{$row->id}}" data-id-user="{{$row->id}}">Delete</a> --}}

                          </td>
                        </tr>
                      @endforeach
                      @foreach ($users as $row)
                      <tr class="TR{{$row->id}}">
                        <td>{{$row->name}}</td>
                        <td>{{$row->email}}</td>
                        <td>{{$row->phone}}</td>
                        <td>{{$row->usertype}}</td>
                        <td>{{$row->namec}}</td>
                        <td class="text-right"></td>
                        <td>
                            <a href="{{ route('users.impersonate', $row->id) }}" class="btn btn-btn-warning" target="_blank">User login</a>
                            {{-- <a href="/logout1/{{$row->id}}" class="btn btn-primary">Login</a> --}}
                        </td>
                        <td>
                            <a href="/role-edit/{{$row->id}}" class="btn btn-success">Edit</a>
                        </td>
                        <td>
                            {{-- <form action="/role-del/{{$row->id}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submite" class="btn btn-danger">Delete</button>
                            </form> --}}
                            <a class="btn btn-danger text-white" id="DeleteButton{{$row->id}}" data-id-user="{{$row->id}}">Delete</a>

                        </td>
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
const items = @json($users);

    for (var i = 0; i < items.length; i++) {
        $('#DeleteButton'+items[i].id).unbind().on('click', event => {
            console.log(event.currentTarget.dataset.idUser)
            Swal.fire({
                    title: 'êtes-vous sûr?',
                    text: "Vous souhaitez supprimer l'utilisateur",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            'url' : '{{ route('profile-supprimer-compte')}}',
                            'type' : 'POST',
                            data : {'id_user':event.currentTarget.dataset.idUser,'_token' : '{{ csrf_token() }}' },
                            success : function(data){
                                $(".TR"+data.id_user ).children().remove();
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
