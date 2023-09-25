<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::all();
        return response()->json([
            "status"=>true,
            "message"=>"All Products",
            "errors"=>null,
            "data"=>$products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $product = $request->createProduct();
        return response()->json([
            "status"=>true,
            "message"=>"Product created successfully",
            "errors"=>null,
            "data"=>$product
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if(empty($product))  return response()->json([
            "status"=>false,
            "message"=>"not exist id",
            "errors"=>"not exist id",
            "data"=>null
        ],400); 

        return response()->json([
            "status"=>true,
            "message"=>"Product get successfully",
            "errors"=>null,
            "data"=>$product
        ]);
    } 

    //searchName
    public function searchName($name)
    {
        $products = Product::where('name','like',"%$name%")->get(); 
        return response()->json([
            "status"=>true,
            "message"=>"Product get successfully",
            "errors"=>null,
            "data"=>$products
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator=$request->validate([
            'name' => 'string|max:100|unique:products,name,'. $id,
            'category_id' => 'integer|max:100|exists:categories,id',
            'price' => 'numeric',
            'stock' => 'integer',
            'description' => 'string',
            'status' => 'boolean',
            'image' => 'image|max:2048',// mimes:jpeg,png,jpg,gif|

        ]);  

        $Product = Product::find($id);
        if(empty($Product)) return response()->json([
            "status"=>false,
            "message"=>"not exist id",
            "errors"=>"not exist id",
            "data"=>null
        ],400);

        $imageFile = @$request->file('image');
        if (isset($imageFile)) {
            // Generate a unique name for the image file
            $imageName = uniqid() . '.' . $imageFile->getClientOriginalExtension();
            // Save the image file
            $imageFile->storeAs('public/images', $imageName);
            // delete old image
            Storage::disk('public')->delete('images/' . $Product['image']);
        }


        $Product->update([
            'name' => isset($request->name) ? $request->name : $Product['name'],
            'category_id' => isset($request->category_id) ? $request->category_id : $Product['category_id'],
            'price' => isset($request->price) ? $request->price : $Product['price'],
            'stock' => isset($request->stock) ? $request->stock : $Product['stock'],
            'description' => isset($request->description) ? $request->description : $Product['description'],
            'status' => isset($request->status) ? $request->status : $Product['status'],
            'image' => isset($request->image) ? $imageName : $Product['image'],
         ]);

        return response()->json([
            "status"=>true,
            "message"=>"Product Updated successfully",
            "errors"=>null,
            "data"=>$Product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $Product = Product::find($id);
        if(empty($Product)) return response()->json([
            "status"=>false,
            "message"=>"not exist id",
            "errors"=>"not exist id",
            "data"=>null
        ],404); 
        Storage::disk('public')->delete('images/'.$Product['image']);
        $Product->delete();
        return response()->json([
            "status"=>true,
            "message"=>"Product deleted successfully",
            "errors"=>null,
            "data"=>null
        ]); 
    }
}
