@extends('layouts.master')

@section('title')
    User Profile
@endsection

@section('content')

@if(Auth::user()->usertype == "admin")
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title fs-5" id="exampleModalLabel1" style="color:#122E50;font-weight:600;">Edit Balance</h4>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
        </div>
        <form action="/balanc" methode="POST">
          {{csrf_field()}}
        <div class="modal-body">
            <div class="mb-3 ">
              <label for="recipient-name" class="col-form-label" style="font-weight:500; border-radius 5px;">Balance :</label>
              <input type="text" name="balance" value="{{$balance}}" class="form-control border rounded-0" id="recipient-name" required>
            </div>
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Edit</button>
        </div>
      </form>
      </div>
    </div>
</div>
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title fs-5" id="exampleModalLabel2" style="color:#122E50;font-weight:600;">Edit Phone</h4>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
        </div>
        <form action="/phone" methode="POST">
          {{csrf_field()}}
        <div class="modal-body">
            <div class="mb-3 ">
              <label for="recipient-name" class="col-form-label" style="font-weight:500; border-radius 5px;">Phone :</label>
              <input type="text" name="phone" value="{{Auth::user()->phone}}" class="form-control border rounded-0" id="recipient-name" required>
            </div>
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Edit</button>
        </div>
      </form>
      </div>
    </div>
</div>
<div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title fs-5" id="exampleModalLabel3" style="color:#122E50;font-weight:600;">Edit Email</h4>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
        </div>
        <form action="/email" methode="POST">
          {{csrf_field()}}
        <div class="modal-body">
            <div class="mb-3 ">
              <label for="recipient-name" class="col-form-label" style="font-weight:500; border-radius 5px;">Email :</label>
              <input type="text" name="email" value="{{Auth::user()->email}}" class="form-control border rounded-0" id="recipient-name" required>
            </div>
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Edit</button>
        </div>
      </form>
      </div>
    </div>
</div>
<div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title fs-5" id="exampleModalLabel3" style="color:#122E50;font-weight:600;">Edit Name</h4>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
        </div>
        <form action="/name" methode="POST">
          {{csrf_field()}}
        <div class="modal-body">
            <div class="mb-3 ">
              <label for="recipient-name" class="col-form-label" style="font-weight:500; border-radius 5px;">Name :</label>
              <input type="text" name="name" value="{{Auth::user()->name}}" class="form-control border rounded-0" id="recipient-name" required>
            </div>
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Edit</button>
        </div>
      </form>
      </div>
    </div>
</div>
@endif


<section style="background-color: #eee;">
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
          </ol>
        </nav>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3">{{Auth::user()->name}}</h5>
            <div class="d-flex justify-content-center mb-2">
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0" data-toggle="modal" data-target="#exampleModal4">{{Auth::user()->name}}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0" data-toggle="modal" data-target="#exampleModal3">{{Auth::user()->email}}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Phone</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0" data-toggle="modal" data-target="#exampleModal2">{{Auth::user()->phone}}</p>
              </div>

            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">User Type</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{Auth::user()->usertype}}</p>
              </div>
            </div>
            @if(Auth::user()->usertype == "admin")
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Balance</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0"  data-toggle="modal" data-target="#exampleModal1">{{$balance}} <i class="fa fa-pen"></i></p>
                    </div>
                </div>
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection

@section('script')

@endsection
