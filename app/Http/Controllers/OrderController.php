<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_Products;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  $Orders = Order::all();
        $Orders = Order::orderBy('id', 'desc')->paginate(2);
        return response()->json([
            "status"=>true,
            "message"=>"All Orders",
            "errors"=>null,
            "data"=>$Orders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        //validetor request
            $validator=$request->validate([
                'customer_id' => 'required|integer|max:100|exists:customers,id',
                'customer_name' => 'required|string|max:100',
                'customer_email' => 'required|email',
                'customer_phone' => 'required|string|regex:/^[0-9]{11}$/',
                'customer_address' => 'required|string|max:255',
                //products validation
                'products' => 'required|array',
                'products.*.id' => 'required|integer|max:100|exists:products,id',
                'products.*.quantity' =>'required|min:1',
                'products.*.price'=>'required|numeric',
                'products.*.subTotal'=>'required|numeric',
                'products.*.description'=>'nullable|string|max:255',

            ]);  
            $total = 0;
            foreach($request->products as $product){
                $total = $total + ($product['price']*$product['quantity']);
            } 
            // start Transaction
           // DB::beginTransaction();
           $order =  Order::create([
                'customer_id' => $request->customer_id,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'date' => Carbon::now()->toDateTimeString(),
                'total' =>  $total,
            ]);
            // if error in order rollback
            $Order_Products = [];
            foreach($request->products as $product){
                $Order_Products[] = Order_Products::create([
                        'order_id' => $order['id'],
                        'product_id' =>$product['id'],
                        'description' => @$product['description'],
                        'product_price' => $product['price'],
                        'product_subTotal' => $product['subTotal'],
                        'product_quantity' => $product['quantity'],
                    ]);
            } 
           // DB::commit();
            $order['products'] = $Order_Products;
            return response()->json([
                "status"=>true,
                "message"=>"Order created successfully",
                "errors" =>null,
                "data"=>$order
            ],201);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Order = Order::find($id);
        if(empty($Order)) return response()->json([
            "status"=>false,
            "message"=>"not exist id",
            "errors"=>"not exist id",
            "data"=>null
        ],404);
        $orderProducts = Order_Products::where(['order_id' => $id] )->get();
        $Order['products'] =$orderProducts ;
        return response()->json([
            "status"=>true,
            "message"=>"Order get successfully",
            "errors"=>null,
            "data"=>$Order
        ]);
    }

      //searchName
      public function searchNumber($number)
      {
          $Orders = Order::where('id','like',"%$number%")->get(); 
          return response()->json([
              "status"=>true,
              "message"=>"Orders get successfully",
              "errors"=>null,
              "data"=>$Orders
          ]);
      }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) 
    {
        $validator=$request->validate([
            'status' => 'required|in:new,cancelled,completed',
        ]);  
        $Order = Order::find($id);
        if(empty($Order)) return response()->json([
            "status"=>false,
            "message"=>"not exist id",
            "errors"=>"not exist id",
            "data"=>null
        ],404);
        $Order->update([ 'status' =>$request->status ]);
        return response()->json([
            "status"=>true,
            "message"=>"Order Updated successfully",
            "errors"=>null,
            "data"=>$Order
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
