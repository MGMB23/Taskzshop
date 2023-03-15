@extends('layouts.master')

@section('title')
    My Invoice
@endsection
@section('head')
<script charset="utf-8" src="//cdn.iframe.ly/embed.js?api_key='bcfe2a7e3f555da6eb4a63'"></script>
<script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<style>
.card img {
    width: 100px;
    height: 100px;
}
.card figure {
    width: 100px;
    height: 100px;
}
</style>
@endsection

@section('content')
@php
    use App\Models\User;
    use App\Models\Taskuser;
    use App\Models\Invoice;

    $user_id       = Auth::user()->id;
    $invoices = Invoice::where('user_id', $user_id)->get();

    
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Invoice Liste</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <th class="text-dark" style="font-weight:600">Id</th>
                            <th class="text-dark" style="font-weight:600">Date</th>
                            <th class="text-dark" style="font-weight:600">Status</th>
                        </thead>
                    <tbody>
                        @foreach ($invoices as $row)
                            <tr class="">
                            <td>{{$row->id}}</td>
                            <td>{{$row->date}}</td> 
                            <td>
                                @if($row->status == 1)
                                    <h6 class="text-success">paid</h6>
                                @else
                                <h6 class="text-warning">Pending</h6>
                                @endif
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
@endsection
