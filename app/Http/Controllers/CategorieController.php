<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{

    public function index()
    {
        $categories = Categorie::all();
        return view('categorie.index',compact('categories'));
    }

    public function save(Request $request)
   {
      $categories = new Categorie;
      $categories->namec = $request->input('namec');
      $categories->save();
      return redirect('/categories')->with('success','Categorie added');
   }

   public function supprimertask(Request $request){


        Categorie::where('id',$request->id_categ)->delete();
        $responce['id_categ'] = $request->id_categ;
        return $responce;
    }

    public function edit($id)
   {
      $categories = Categorie::findorFail($id);
      return view('categorie.categ-edit')->with('categories',$categories);
   }
   public function updatetask(Request $request ,$id)
   {
      $categories = Categorie::findOrFail($id);
      $categories->namec = $request->input('namec');
      $categories->update();
      return redirect('/categories')->with('status','categorie is modified');

   }

}
