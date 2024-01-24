<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function add(){
        $categories=Category::all();

        return view('home', compact('categories'));

    }

    public function store(Request $request){
        $name = $request->name;
        $price = $request->price;
        $stock = $request->stock;
        $photo = $request->photo;
        $description = $request->description;
        $category_id = $request->category_id;
        $stand = $request->stand;

        Product::create([
            'name'=>$name,
            'price'=>$price,
            'stock'=>$stock,
            'photo'=>$photo,
            'description'=>$description,
            'category_id'=>$category_id,
            'stand'=>$stand,
        ]);

        return redirect()->back()->with('status','Berhasil menambah produk');
    }

    public function update(Request $request, $id){
        $name = $request->name;
        $price = $request->price;
        $stock = $request->stock;
        $photo = $request->photo;
        $description = $request->description;
        $category_id = $request->category_id;
        $stand = $request->stand;

        Product::find($id)->update([
            'name'=>$name,
            'price'=>$price,
            'stock'=>$stock,
            'photo'=>$photo,
            'description'=>$description,
            'category_id'=>$category_id,
            'stand'=>$stand,
        ]);

        return redirect()->back()->with('status','Berhasil update produk');
    }

    public function destroy($id){
        $delete = Product::find($id)->delete();

        if($delete){
            return redirect('/')->with('status','Berhasil menghapus produk');
        }
        else{
            return redirect('/')->with('status','Gagal menghapus data');
        }
    }
}
