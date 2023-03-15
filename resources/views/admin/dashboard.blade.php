@extends('layouts.master')

@section('title')
    Dashboard
@endsection
@section('head')
<script charset="utf-8" src="//cdn.iframe.ly/embed.js?api_key='bcfe2a7e3f555da6eb4a63'"></script>
<script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>
<style>
.card img {
    width: 100px;
    height: 100px;
}
#state{
    cursor:pointer;
}
</style>
@endsection
@section('content')
@php
use App\Models\User;
use App\Models\Tasks;
use App\Models\Taskuser;
use App\Models\Categorie;
use App\Models\Balance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

$total_users =  User::count();
$total_tasks = Tasks::count();
$recentTasks = Tasks::latest()->take(5)->get();
// $recentTasks = DB::table('taskusers')
//                 ->leftJoin('tasks', 'tid', '=', 'tasks.id')
//                 ->join('users', 'uid', '=', 'users.id')
//                 ->latest('taskusers.updated_at')->take(5)->get();
$recentUsers = User::where('usertype',"user")->latest('updated_at')->take(5)->get();
$completedTask = Tasks::where('completed','1')->count();
$pendingTask = Tasks::where('completed','0')->count();
$last_complTask = DB::table('taskusers')
            ->leftJoin('tasks', 'tid', '=', 'tasks.id')
            ->join('users', 'uid', '=', 'users.id')
            ->where('taskusers.status',1)
            ->latest('taskusers.updated_at')->take(5)
            ->get();
$user = Auth::user();
$tasks = Tasks::all();

// ---------------------- User -------------
$tasksU = Tasks::all();
$count = 0;
foreach ($tasksU as $task ) {
    if($task->users != NULL){
        foreach ($task->users as $us) {
            if($us == $user->id)
                $count++;
        }
    }
}
$user_total_tasks = $count;
$usercompletedTask = Tasks::where('completed','1')->count();
$userpendingTask = Taskuser::where('uid',$user->id)->count();
$balance = $user->balance;
$total_balance = $user->total_balance;

$usertasks =  DB::table('taskusers')
            ->leftJoin('tasks', 'tid', '=', 'tasks.id')
            ->join('users', 'uid', '=', 'users.id')
            ->where('taskusers.status',1)
            ->where('users.id',$user->id)
            ->get();
$userrecentTasks = Tasks::latest()->take(5)->get();
$bal = Balance::first()->bal;
$total_cat = categorie::count()

@endphp
@if(Auth::user()->usertype == "admin")
    <div class="row">
        <div class="col-md-4 col-xl-3" id="state">
            <a href="/roleregiter">
                <div class="card bg-c-blue order-card">
                        <div class="card-block">
                            <h6 class="m-b-20">Total Users</h6>
                            <h2 class="text-right"><i class="fa-solid fa-users f-left"></i><span>{{$total_users}}</span></h2>
                        </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-xl-3 "  id="state">
            <a href="/tasks">
                <div class="card bg-c-green order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Total Tasks</h6>
                        <h2 class="text-right"><i class="fa-solid fa-list-check f-left"></i><span>{{$total_tasks}}</span></h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-xl-3 "  id="state">
            <div class="card bg-c-yellow order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Completed Tasks </h6>
                    <h2 class="text-right"><i class="fa-solid fa-bars-progress f-left"></i><span>{{$completedTask}}</span></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3"  id="state">
            <div class="card bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Pending task</h6>
                    <h2 class="text-right"><i class="fa-sharp fa-solid fa-spinner f-left"></i><span>{{$pendingTask}}</span></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3"  id="state">
            <a href="/categories">
                <div class="card bg-c-pink order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Total categories</h6>
                        <h2 class="text-right"><i class="fa-sharp fa-solid fa-spinner f-left"></i><span>{{$total_cat}}</span></h2>
                    </div>
                </div>
            </a> 
        </div>
    </div>
    <div class="row">
        <!-- Content Column -->
        <div class="col-lg-6 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold" style="color:#012970" >Today's 5 Tasks <i class="fa-sharp fa-solid fa-list-check"></i></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                        <th class="text-dark" style="font-weight:600">Name</th>
                        <th class="text-dark"style="font-weight:600">Description</th>
                        <th class="text-dark"style="font-weight:600">Prize</th>
                        </thead>
                        <tbody>
                        @foreach ($recentTasks as $row)
                        <tr>
                            <td style="color:#173457; font-weight:500; font-size:15px">{{ $row->Name }}</td>
                            <td style="color:#173457; font-weight:500 ;font-size:15px">{!! $row->Description !!}</td>
                            <td style="color:#FFC067; font-weight:500 ;font-size:15px"><strong> {{ $row->prize }}</strong></td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold" style="color:#012970" >Today's 5 Users <i class="fa fa-users"></i></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                        <th class="text-dark"style="font-weight:600">Name</th>
                        <th class="text-dark" style="font-weight:600">Mail</th>
                        <th class="text-dark" style="font-weight:600">Phone</th>
                        </thead>
                        <tbody>
                        @foreach ($recentUsers as $row)
                        <tr>
                            <td style="color:#173457; font-weight:500">{{ $row->name }}</td>
                            <td style="color:#173457; font-weight:500">{{ $row->email }}</td>
                            <td style="color:#173457; font-weight:500">{{ $row->phone }}</td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                    </div>
                </div>
        </div>
    </div>
    <!-- Content Column -->
    <div class="col-lg-6 mb-4">

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold" style="color:#012970" >Last Task Completed <i class="fa-sharp fa-solid fa-list-check"></i></h5>
            </div>
            <div class="card-body">
                    <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                        <th class="text-dark" style="font-weight:600">Name</th>
                        <th class="text-dark"style="font-weight:600">User</th>
                        <th class="text-dark"style="font-weight:600">Prize</th>
                        <th class="text-dark"style="font-weight:600">Status</th>

                        </thead>
                        <tbody>
                        @foreach ($last_complTask as $row)
                        <tr>
                            <td style="color:#173457; font-weight:500; font-size:15px">{{ $row->Name }}</td>
                            <td style="color:#173457; font-weight:500 ;font-size:15px">{{ $row->name }}</td>
                            <td style="color:#FFC067; font-weight:500 ;font-size:15px"><strong> {{ $row->prize }}</strong></td>
                            <td style="color:#46DCBE; font-weight:500 ;font-size:15px" ><strong> Completed</strong></td>

                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                    </div>
                </div>
        </div>
    </div>
@else
<div class="row">

        <div class="col-md-4 col-xl-3"  id="state">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Tasks</h6>
                    <h2 class="text-right"><i class="fa-solid fa-list-check f-left"></i><span>{{$user_total_tasks}}</span></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3"  id="state">
            <div class="card bg-c-yellow order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Completed Tasks </h6>
                    <h2 class="text-right"><i class="fa-solid fa-bars-progress f-left"></i><span>{{$userpendingTask}}</span></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3"  id="state">
            <div class="card bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Pending task</h6>
                    <h2 class="text-right"><i class="fa-sharp fa-solid fa-spinner f-left"></i><span>{{$user_total_tasks - $userpendingTask}}</span></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3"  id="state">
            <div class="card bg-c-blue order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Balance</h6>
                    <h2 class="text-right"><i class="fa-solid fa-coins f-left"></i><span>{{$balance}}</span></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3"  id="state">
            <div class="card bg-c-blue order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Gain</h6>
                    <h2 class="text-right"><i class="fa-solid fa-coins f-left"></i><span>{{$total_balance}}</span></h2>
                </div>
            </div>
        </div>

</div>
<div class="row">
    <!-- Content Column -->
    <div class="col-lg-6 mb-4">

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold" style="color:#012970" >Today's 5 Tasks <i class="fa-sharp fa-solid fa-list-check"></i></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table">
                    <thead class=" text-primary">
                    <th class="text-dark" style="font-weight:600">Name</th>
                    <th class="text-dark"style="font-weight:600">Description</th>
                    <th class="text-dark"style="font-weight:600">Prize</th>
                    </thead>
                    <tbody>
                        @php $compt = 0; @endphp
                    @foreach ($userrecentTasks as $row)
                        @if($compt < 5)
                            @php $checked = 0; @endphp
                            @if($row->users != NULL)
                                @foreach ($row->users as $us)
                                    @if($us == $user->id)
                                        @php $checked = 1; @endphp
                                    @endif
                                @endforeach
                            @endif

                            @if($checked == 1)
                                <tr>
                                    <td style="color:#173457; font-weight:500; font-size:15px">{{ $row->Name }}</td>
                                    <td style="color:#173457; font-weight:500 ;font-size:15px">{!! $row->Description !!}</td>
                                    <td style="color:#FFC067; font-weight:500 ;font-size:15px"><strong> {{ $row->prize }}</strong></td>

                                </tr>
                                @php $compt++; @endphp
                            @endif
                        @endif
                    @endforeach

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
        <!-- Content Column -->
        <div class="col-lg-6 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold" style="color:#012970" >My Last Tasks <i class="fa-sharp fa-solid fa-list-check"></i></h5>
                @if(Auth::user()->balance > $bal)
                    <a href="/generate-invoice-pdf"  class="btn btn-dark" >Download Invoice</a>
                @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <th class="text-dark" style="font-weight:600">Name</th>
                            <th class="text-dark"style="font-weight:600">Prize</th>
                            <th class="text-dark"style="font-weight:600">Status</th>
                        </thead>
                        <tbody>
                        @foreach ($usertasks as $row)
                            <tr>
                                <td style="color:#173457; font-weight:500; font-size:15px">{{ $row->Name }}</td>
                                <td style="color:#FFC067; font-weight:500 ;font-size:15px"><strong> {{ $row->prize }}</strong></td>
                                <td style="color:#46DCBE; font-weight:500 ;font-size:15px" ><strong> Completed</strong></td>
                                {{-- <td><a href="/generate-invoice-pdf/{{ $row->tid }}/{{ $row->uid }}"  class="btn btn-dark" >Invoice</a></td> --}}
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
</div>


@endif



@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>


 <!-- Script -->
 <script>

    document.querySelectorAll( 'div[data-oembed-url]' ).forEach( element => {
        // Discard the static media preview from the database (empty the <div data-oembed-url="...">).
        while ( element.firstChild ) {
            element.removeChild( element.firstChild );
        }

        // Generate the media preview using Iframely.
        iframely.load( element, element.dataset.oembedUrl ) ;
    } );
    document.querySelectorAll( 'oembed[url]' ).forEach( element => {
        console.log(element, element.attributes.url.value)
        iframely.load( element, element.attributes.url.value );
    } );

    document.querySelectorAll( 'oembed[url]' ).forEach( element => {
        // Create the <a href="..." class="embedly-card"></a> element that Embedly uses
        // to discover the media.
        const anchor = document.createElement( 'a' );

        anchor.setAttribute( 'href', element.getAttribute( 'url' ) );
        anchor.className = 'embedly-card';

        element.appendChild( anchor );
    } );
</script>
@endsection
