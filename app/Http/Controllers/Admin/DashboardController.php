<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tasks;
use App\Models\Balance;
use App\Models\Archiveuser;
use App\Models\Invoice;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function registred()
    {
        $admin = User::where('usertype','admin')->get();
        $user = DB::table('users')
                    ->select('users.*','categories.namec')
                    ->join('categories', 'categories.id', '=', 'users.cid')
                    ->get();
        $totalusers = User::count();
        return view('admin.register',compact('admin'))->with('users',$user);

    }
    public function registrededit(Request $request ,$id)
    {
        $user = User::findOrFail($id);
        return view('admin.register-edit')->with('users',$user);
    }
    public function registredupdate(Request $request ,$id)
    {
        $users = User::find($id);
        $users->name = $request->input('username');
        $users->usertype = $request->input('usertype');
        $users->email = $request->input('email');
        $users->update();
        return redirect('/roleregiter')->with('status','user is modified');
    }
    public function registreddel($id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        return redirect('/roleregiter')->with('status','user is delated');

    }
    public function state()
    {
        $totalusers = User::count();
        return view('admin.dashboard')->with('users',$totalusers);
    }

    public function useradd(Request $request)
    {
        $users = new User;
        $users->name = $request->input('name');
        $users->email = $request->input('email');
        $users->phone = $request->input('phone');
        $users->password = Hash::make($request->input('password'));
        $users->cid = $request->input('categories');
        $users->usertype = $request->input('usertype');

        $users->save();
        return redirect('/roleregiter')->with('success','task aded');
    }
    public function userprofile()
    {
        $balance = Balance::first()->bal;

        return view('admin.user-profile',compact('balance'));
    }


    public function supprimercompte(Request $request){

        $tasks = Tasks::all();

        foreach($tasks as $task){
            $arr = array();
            $checked = 0;
            if($task->users != NULL){
                foreach($task->users as $user){
                    if($user != $request->id_user){
                        array_push($arr,$user);
                    }else{
                        $checked = 1;
                    }
                }

                if($checked == 1){
                    $users = [
                        "users" => $arr,
                    ];
                    Tasks::where('id',$task->id)->update($users);
                }
            }

        }

        $user = User::where('id',$request->id_user)->first();
        $arch = new Archiveuser;
        $arch->name = $user->name;
        $arch->email = $user->email;
        $arch->phone = $user->phone;
        $arch->usertype = $user->usertype;
        $arch->save();

        User::where('id',$request->id_user)->delete();
        $responce['id_user'] = $request->id_user;
        return $responce;
    }



      public function impersonate(User $user)
    {
        auth()->user()->impersonate($user);

        return redirect('/');
    }

    public function leaveImpersonate()
    {
        $user = User::where('usertype','admin')->first();
        auth()->user()->impersonate($user);

        return redirect('/roleregiter');
    }


    public function balance(Request $request){

        $balanc = [
            "bal" => $request->balance,
        ];
        Balance::first()->update($balanc);

        return redirect('/user-profile');

    }
    public function phone(Request $request){

        $pho = [
            "phone" => $request->phone,
        ];
        User::where('id',Auth::user()->id)->update($pho);

        return redirect('/user-profile');

    }
    public function email(Request $request){

        $pho = [
            "email" => $request->email,
        ];
        User::where('id',Auth::user()->id)->update($pho);

        return redirect('/user-profile');

    }
    public function name(Request $request){

        $pho = [
            "name" => $request->name,
        ];
        User::where('id',Auth::user()->id)->update($pho);

        return redirect('/user-profile');

    }
    public function invoiceshow(){
        return view('admin.invoceliste');
    }
    public function invoicestatusupdate(Request $request){
        $invoice = [
            "status" => $request->status,
        ];
        Invoice::where('id',$request->Invoice)->update($invoice);
        return redirect()->back();
    }
}
