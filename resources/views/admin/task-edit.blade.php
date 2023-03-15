@extends('layouts.master')

@section('title')
    Edit Task
@endsection

{{-- @section('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
@endsection --}}

@section('content')
@php
    use App\Models\User;
    $users = User::where('usertype','user')->get();
@endphp
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Edit Task</h1>
                </div>
                <div class="card-body">
                    <form action="/task-update/{{$tasks->id}}" method="POST">
                    {{csrf_field()}}
                    {{ method_field('PUT')}}
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" value="{{ $tasks->Name}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea type="text" name="description" value="{{ $tasks->Description}}" class="form-control" id="editor">{!! $tasks->Description !!}</textarea>

                        </div>
                        <div class="form-group">
                            <label>prize</label>
                            <input type="text" name="prize" value="{{$tasks->prize}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="prize-text" class="col-form-label">Assign To:</label>
                            <select name="users_id[]" id="choices-multiple-remove-button" multiple>
                                @if($tasks->users == NULL)
                                    @foreach ($users as $row)
                                        <option value="{{$row->id}}">{{ $row->name }}</option>
                                    @endforeach
                                @else
                                    @foreach ($users as $row)
                                        @php $check = 0; @endphp
                                        @foreach ($tasks->users as $us)
                                            @if($us == $row->id)
                                                @php $check = 1; @endphp
                                            @endif
                                        @endforeach
                                        @if($check == 0)
                                            <option value="{{$row->id}}">{{ $row->name }}</option>
                                        @else
                                            <option value="{{$row->id}}" selected>{{ $row->name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success"> Update</button>
                        <a href="/" class="btn btn-success"> Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create( document.querySelector( '#editor' ), {
         toolbar     : [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'imageUpload', 'blockQuote' ],
         ckfinder    : { uploadUrl: '{{route('image.upload').'?_token='.csrf_token()}}',}
     }).catch( error => {
         console.error( error );
     });
 </script>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
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
@endsection
