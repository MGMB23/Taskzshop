@extends('layouts.master')

@section('title')
    Invoice
@endsection

@php
    use App\Models\User;
    use App\Models\Taskuser;
    use App\Models\Invoice;
    $invoices = Invoice::all();
@endphp

@section('content')
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
                            <th class="text-dark" style="font-weight:600">Users</th>
                            <th class="text-dark" style="font-weight:600">Date</th>
                            <th class="text-dark" style="font-weight:600">Status</th>
                        </thead>
                     
                    <tbody>
                        @foreach ($invoices as $row)
                        <tr class="">
                          <td>{{$row->id}}</td>
                          <td>{{$row->name}}</td>
                          <td>{{$row->date}}</td>                          
                          <td style="color:#46DCBE; font-weight:500 ;font-size:15px">
                                <button class="btn @if($row->status) btn-success @else btn-warning @endif" data-toggle="modal" data-target="#exampleModal" data-status="{{$row->id}}" data-title="{{$row->name}}">
                                    @if($row->status)
                                        Paid
                                    @else
                                        Pending
                                    @endif
                                </button>
                          </td>
                            <td>
                                <a href="/invoice-view/{{$row->id}}" class="btn btn-success">View <i class="fa fa-eye"></i></a>
                                <a href="/invoicedownload/{{$row->id}}" class="btn btn-primary">Download <i class="fa fa-download"></i></a>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="{{ route('invoice-status-update')}}">
        @csrf
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Changer le status de </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <input type="hidden" name="Invoice">
                <div class="input-group mb-3">
                    <select class="custom-select" id="inputGroupSelect" name="status">
                        <option value="1" selected>Paid</option>
                        <option value="0">Pending</option>
                    </select>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Changer</button>
        </div>
        </div>
    </form>
  </div>
</div>
@endsection
@section('script')
<script>
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var title = button.data('title') // Extract info from data-* attributes
  var status = button.data('status') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Changer le status de ' + title)
  modal.find('.modal-body input').val(status)

})
</script>
@endsection
