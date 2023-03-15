@extends('layouts.master')

@section('title')
    Category
@endsection
@section('head')
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
        <h4 class="modal-title fs-5" id="exampleModalLabel" style="color:#122E50;font-weight:600;">New Category</h4>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
      </div>
      <form action="/save-categorie" methode="POST">
        {{csrf_field()}}
      <div class="modal-body">
          <div class="mb-3 ">
            <label for="recipient-name" class="col-form-label" style="font-weight:500; border-radius 5px;">Name:</label>
            <input type="text" name="namec" class="form-control border rounded-0" id="recipient-name" required>
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
                <h4 class="card-title"> Category</h4>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">New Category</button>
              </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                        <th class="text-dark" style="font-weight:600">Name</th>
                        </thead>
                        <tbody>
                        @foreach ($categories as $data)
                            <tr class="TR{{$data->id}}">
                                <td style="font-weight:400">{{$data->namec}}</td>
                                <td>
                                    <a href="{{url('categories/'.$data->id)}}" class="btn btn-success">Edit</a>
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
<script>
    const items = @json($categories);

        for (var i = 0; i < items.length; i++) {
            $('#DeleteButton'+items[i].id).unbind().on('click', event => {
                console.log(event.currentTarget.dataset.idTask)
                Swal.fire({
                        title: 'êtes-vous sûr?',
                        text: "Vous souhaitez supprimer Categorie",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, Supprimer!'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                'url' : '{{ route('categ-supprimer')}}',
                                'type' : 'POST',
                                data : {'id_categ':event.currentTarget.dataset.idTask,'_token' : '{{ csrf_token() }}' },
                                success : function(data){
                                    // console.log(data)
                                    $(".TR"+data.id_categ ).children().remove();
                                    Swal.fire(
                                    'Supprimé avec succès!',
                                    "Categorie a été supprimé avec succès",
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
