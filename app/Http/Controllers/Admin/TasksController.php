<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Archivetask;
use Illuminate\Http\Request;
use App\Models\Tasks;
use App\Models\User;
use App\Models\Taskuser;
use App\Models\Invoice;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class TasksController extends Controller
{
   public function first()
   {

      $user = Auth::user();
      $tasks = Tasks::all();
      $users = User::where('usertype',"user")->get();
        // dd($tasks);
      return view('admin.tasks',compact('user','users'))->with('tasks',$tasks);
   }
   public function save(Request $request)
   {
        // dd($request,$request->input('name'),$request->users_id);
        if($request->users_id == NULL){
            $tasks = new Tasks;
            $tasks->name = $request->input('name');
            $tasks->Description = $request->input('descriptrion');
            $tasks->prize = $request->input('prize');
            $tasks->completed = 0;
            $tasks->users = $request->users_id;
            $tasks->save();
            return redirect('/tasks')->with('success','task aded');
        }else{
            if(count($request->users_id) == 1 && $request->users_id[0] == 0){
                $users = User::where('usertype',"user")->get();
                $arr = array();
                foreach($users as $user)
                    array_push($arr,$user->id);

                $tasks = new Tasks;
                $tasks->name = $request->input('name');
                $tasks->Description = $request->input('descriptrion');
                $tasks->prize = $request->input('prize');
                $tasks->completed = 0;
                $tasks->users = $arr;
                $tasks->save();
                return redirect('/tasks')->with('success','task aded');
            }else{
                $checked = 0;
                foreach($request->users_id as $user){
                    if($user == 0){
                        $checked = 1;
                    }
                }
                $tasks = new Tasks;
                $tasks->name = $request->input('name');
                $tasks->Description = $request->input('descriptrion');
                $tasks->prize = $request->input('prize');
                $tasks->completed = 0;
                if($checked == 0)
                    $tasks->users = $request->users_id;
                else{
                    $users = User::where('usertype',"user")->get();
                    $arr = array();
                    foreach($users as $user)
                        array_push($arr,$user->id);

                    $tasks->users = $arr;
                }

                $tasks->save();
                return redirect('/tasks')->with('success','task aded');
            }
        }
   }
   public function edit($id)
   {
      $tasks = Tasks::findorFail($id);
      return view('admin.task-edit')->with('tasks',$tasks);
   }
   public function updatetask(Request $request ,$id)
   {
      $tasks = Tasks::findOrFail($id);
      $tasks->name = $request->input('name');
      $tasks->description = $request->input('description');
      $tasks->prize = $request->input('prize');
      $tasks->users = $request->users_id;
      $tasks->update();
      return redirect('/tasks')->with('status','user is modified');

   }

   public function edit2($id)
   {
      $tasks = Tasks::findorFail($id);
      return view('admin.task-edit2')->with('tasks',$tasks);
   }
   public function updatetask2(Request $request ,$id)
   {
    // $images = $request->file('image');
    // $arr = array();
    // foreach($images as $image){
    //     $userFolder = Auth::user()->id . '_'. Auth::user()->email;
    //     $file = $image;
    //     $path = $file->store($userFolder);
    //     $file->getClientOriginalExtension();
    //     $file->move(public_path('/proofusers'.'/'.$userFolder), $path);
    //     Storage::deleteDirectory($userFolder);
    //     array_push($arr,'proofusers/'.$path);
    // }
        $taskuser = new Taskuser;
        $taskuser->uid = Auth::user()->id;
        $taskuser->tid = $id;
        // $taskuser->files = $arr;
        $taskuser->files = $request->input('descriptrion');

        $taskuser->link = $request->link;
        $taskuser->status = 0;
        $taskuser->payment = 0;
        $taskuser->invoice_id = 0;
        $taskuser->save();


        $addProof = [
            "completed" => 1,
        ];
        Tasks::where('id',$id)->update($addProof);

        return redirect('/tasks')->with('status','user is modified');
   }


   public function taskdel($id)
   {
      $tasks = Tasks::findOrFail($id);
      $tasks->delete();
      return redirect('/tasks')->with('status','user is delated');
   }


   public function taskusers($id)
   {
        $taskusers = Taskuser::where('tid',$id)->get();
        return view('admin.taskusers')->with('taskusers',$taskusers);
   }

   public function status(Request $request)
   {

        if($request->status == "encours"){

            $taskuser       =  Taskuser::where('id',$request->id)->first();
            $task           =  Tasks::where('id',$taskuser->tid)->first();
            $userbal        =  User::where('id',$taskuser->uid)->first()->balance;
            $usertotbal     =  User::where('id',$taskuser->uid)->first()->total_balance;

            $balance = [
                "balance"       => $userbal + $task->prize,
                "total_balance" => $usertotbal + $task->prize,
            ];
            User::where('id',$taskuser->uid)->update($balance);

            $status = [
                "status" => 1,
            ];
            $response['status'] = "valider";



        }
        if($request->status == "valider"){


            $taskuser       =  Taskuser::where('id',$request->id)->first();
            $task           =  Tasks::where('id',$taskuser->tid)->first();
            $userbal        =  User::where('id',$taskuser->uid)->first()->balance;
            $usertotbal     =  User::where('id',$taskuser->uid)->first()->total_balance;

            $balance = [
                "balance"       => $userbal - $task->prize,
                "total_balance" => $usertotbal - $task->prize,
            ];
            User::where('id',$taskuser->uid)->update($balance);



            $status = [
                "status" => 0,
            ];
            $response['status'] = "encours";
        }
        $response['id'] = $request->id;

        Taskuser::where('id',$request->id)->update($status);
        return $response;
   }

   public function supprimertask(Request $request){

        $task = Tasks::where('id',$request->id_task)->first();

        $archive                = new Archivetask;
        $archive->Name          = $task->Name;
        $archive->Description   = $task->Description;
        $archive->prize         = $task->prize;
        $archive->completed     = $task->completed;
        $archive->users         = $task->users;
        $archive->save();

        Tasks::where('id',$request->id_task)->delete();
        $responce['id_task'] = $request->id_task;
        return $responce;
    }

    public function storeImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('media'), $fileName);

            $url = asset('media/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }

    public function generateInvoicePDF()
    {
        $invoice = new Invoice();
        $invoice = new Invoice;
        $user       = Auth::user();
        $task       = Tasks::all();
        $invoices = Invoice::all();
        $balance = [
            "balance"       => 0,
        ];
        User::where('id',$user->id)->update($balance);
        $taskusers  = Taskuser::where('uid',$user->id)->where('payment',0)->get();
        $somme = 0;
        $i = 1;
        $data = [
            'id_invoice' => '#'.$i,
            'date' => date('m/d/Y'),
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
        ];
        // dd($data);
        $pdf = PDF::loadView('admin.invoice',compact('data','taskusers'));
        $invoice->user_id = $user->id;
        $invoice->date = date('Y-m-d');
        $invoice->name = $user->name;
        $invoice->phone = $user->phone;
        $invoice->email = $user->email;
        $invoice->save();
        foreach($taskusers as $ta){
            $pay = [
                "payment" => 1,
                "invoice_id" => $invoice->id,
            ];
            Taskuser::where('id',$ta->id)->update($pay);
        }
        return $pdf->download('invoice.pdf');
    }
    public function invoiceview(int $id)
    {
        $invoice = Invoice::findOrfail($id);
        $user       = $invoice->user_id;
        $taskusers  = Taskuser::where('uid',$user)->where('invoice_id',$invoice->id)->get();
        $i = 0;
        $data = [
            'id_invoice' => '#'.$invoice->id,
            'date' => date('m/d/Y'),
            'name' => $invoice->name,
            'phone' => $invoice->phone,
            'email' => $invoice->email,
        ];
        return view('admin.invoice',compact('data','taskusers'));
    }
    public function invoicedownload(int $id){
        $invoice = Invoice::findOrfail($id);
        $user       = $invoice->user_id;
        $taskusers  = Taskuser::where('uid',$user)->where('invoice_id',$invoice->id)->get();
        $i = 0;
        $data = [
            'id_invoice' => '#'.$invoice->id,
            'date' => date('m/d/Y'),
            'name' => $invoice->name,
            'phone' => $invoice->phone,
            'email' => $invoice->email,
        ];
        $pdf = PDF::loadView('admin.invoice',compact('data','taskusers'));
        return $pdf->download('invoice.pdf');
    }
    public function showmyinvoice()
    {
        return view('admin.myinvoice');    
    }
}
