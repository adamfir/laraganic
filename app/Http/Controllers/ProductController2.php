<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Validator;


class ProductController extends Controller
{
    public function pageAdd(){
        $sidebar = 21;
        $head = (object) array();
        $head->title = "Produk";
        $head->subtitle = "Tambah Produk Baru";
        return view('pages.product-add', compact('sidebar', 'head'));
    }
    public function pageUpdate(){
        $sidebar = 22;
        $head = (object) array();
        $head->title = "Produk";
        $head->subtitle = "Update Produk";
        $items = Item::get();
        return view('pages.product-update', compact(
            'sidebar', 
            'head', 
            'items'
        ));
    }

    public function createProduct(Request $request, Item $item){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'description' => 'required',
            'category' => 'required',
            'unit' => 'required',
            'nutrition' => 'required',
            'img' => 'required'
        ]);
        //  dd($request);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $success = $item->create($input);
        $img = $request->file('img')->store('items/'.$success->id);
        // dd($img);
        $success->img=$img;
        $success->save();
        
        return redirect('product/page-add')->with('success', 'Produk berhasil ditambahkan.');
    }


}