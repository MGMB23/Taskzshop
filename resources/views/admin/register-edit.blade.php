@extends('layouts.master')

@section('title')
    Edit User
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Edit User</h1>
                </div>
                <div class="card-body">
                    <form action="/role-register-update/{{ $users->id}}" method="POST">
                    {{csrf_field()}}    
                    {{ method_field('PUT')}}
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="username" value="{{ $users->name}}" class="form-control border rounded-0">
                        </div>
                        <div class="form-group">
                            <label>Mail</label>
                            <input type="text" name="email" value="{{ $users->email}}" class="form-control border rounded-0">
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="usertype">
                                <option value="admin">Admin</option>
                                <option value="user" selected>User</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success"> Update</button>
                        <a href="/roleregiter" class="btn btn-success"> Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

