<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Categories = Category::all();
        return response()->json([
            "status"=>"ok",
            "message"=>"All Categories",
            "errors"=>null,
            "data"=>CategoryResource::collection($Categories)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = $request->createCategory();
        return response()->json([
            "status"=>"ok",
            "message"=>"Category created successfully",
            "errors" => null,
            "data"=>CategoryResource::make($category)
        ],201);
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if(empty($category)) return response()->json([
            "status"=>false,
            "message"=>"not exist id",
            "errors"=>"not exist id",
            "data"=>null
        ],404); 
        
        return response()->json([
            "status"=>true,
            "message"=>"Category get successfully",
            "errors"=>null,
            "data"=>CategoryResource::make($category)
        ]);

        //return response()->json(["error"=>"not exist id"]);
        //return new CategoryResource($category);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator=$request->validate([
            'name' => 'required|string|max:100|unique:categories,name,'. $id,

        ]);  

        $Category = Category::find($id);
        if(empty($Category)) return response()->json([
            "status"=>false,
            "message"=>"not exist id",
            "errors"=>"not exist id",
            "data"=>null
        ],404);

        $Category->update([
            'name' =>isset( $request->name)? $request->name:$Category['name']
        ]);


        return response()->json([
            "status"=>true,
            "message"=>"Category Updated successfully",
            "errors"=>null,
            "data"=>CategoryResource::make($Category)
        ]);
       // $category = $request->updateCategory($id);
        //return new CategoryResource($category);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if(empty($category)) return response()->json([
            "status"=>false,
            "message"=>"not exist id",
            "errors"=>"not exist id",
            "data"=>null
        ],404); 

        $category->delete();
        return response()->json([
            "status"=>true,
            "message"=>"Category deleted successfully",
            "errors"=>null,
            "data"=>null
        ]); 
    }
}
