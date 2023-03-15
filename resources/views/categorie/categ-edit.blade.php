@extends('layouts.master')

@section('title')
    Edit Category
@endsection

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
                    <h1>Edit Category</h1>
                </div>
                <div class="card-body">
                    <form action="/categ-update/{{$categories->id}}" method="POST">
                    {{csrf_field()}}
                    {{ method_field('PUT')}}
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="namec" value="{{ $categories->namec}}" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success"> Update</button>
                        <a href="/categories" class="btn btn-success"> Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')

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
