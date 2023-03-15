@extends('layouts.master')

@section('title')
    Add Proof
@endsection
@section('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<style>
.card .image {
    width: 400px;
    height: 400px;
}
</style>
@endsection
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Add Proof</h1>
                </div>
                <div class="card-body">
                    <form action="/task-update2/{{$tasks->id}}" method="POST"  enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{ method_field('PUT')}}
                        <div class="form-group">
                            <label for="message-text" class="col-form-label" style="font-weight:500;">Proof:</label>
                            <textarea name="descriptrion" class="editor border  rounded" id="editor" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Link</label>
                            <input type="text" name="link" value="" class="form-control border rounded-0" >
                        </div>
                        <button type="submit" class="btn btn-success"> Add</button>
                        <a href="/tasks" class="btn btn-success"> Cancel</a>
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
   ClassicEditor.create( document.querySelector( '#editor' ), {
        toolbar     : [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'imageUpload', 'blockQuote' ],
        ckfinder    : { uploadUrl: '{{route('image.upload').'?_token='.csrf_token()}}',}
    }).catch( error => {
        console.error( error );
    });
</script>


@endsection
