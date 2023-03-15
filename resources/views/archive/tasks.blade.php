@extends('layouts.master')

@section('title')
    Archive Tasks
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
@endphp
<div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Archive Tasks</h4>
              </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <th>Name</th>
                            <th>Decription</th>
                            <th>Prize</th>
                            <th>Completed</th>
                            <th>Users</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $data)
                                <tr>
                                    <td>{{$data->Name}}</td>
                                    <td>{!! $data->Description !!}</td>
                                    <td>{{$data->prize}}</td>
                                    @if($data->completed  == 0)
                                        <td>Not Complete</td>
                                    @else
                                        <td>Completed</td>
                                    @endif
                                    @if($data->users  == NULL)
                                        <td></td>
                                    @else
                                        <td>
                                            @foreach ($data->users as $user)
                                                {{User::where('id',$user)->first()->name}} <br>
                                            @endforeach
                                        </td>
                                    @endif
                                    <td>{{$data->created_at}}</td>
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



