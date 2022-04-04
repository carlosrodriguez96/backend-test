<?php

namespace App\Http\Controllers;

use App\Bill;
use App\BillItem;
use Illuminate\Http\Request;
use Validator;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bills = Bill::all();
        return response()->json([
            'message' => '',    
            'status' => 200,
            'data' => $bills
        ],200);

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $count = 0;
        $rules=[
            'sender_name' =>'required',
            'sender_nit' =>'required',
            'customer_name' =>'required',
            'customer_nit' =>'required',
            'value' =>'required',
            'iva' =>'required',
            'value_with_iva' =>'required',
            'amount_to_pay' =>'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => $validator->messages(),
                'data' => []
            ]);

        }
        $data=[
            'sender_name' =>$request->sender_name,
            'sender_nit' =>$request->sender_nit,
            'customer_name' =>$request->customer_name,
            'customer_nit' =>$request->customer_nit,
            'value' =>$request->value,
            'iva' =>$request->iva,
            'value_with_iva' =>$request->value_with_iva,
            'amount_to_pay' =>$request->amount_to_pay
        ];
            
       $bill = Bill::create($data);
       if ($bill) {

            $items = $request->items;    
            $numberItems = count($items);
            foreach($items as $item)
            {
                $item["bill_id"]=$bill->id;
                BillItem::create($item);  
                $count++;           
            }
                
            if($count == $numberItems){
                return response()->json([
                    'message' => 'Bill created successfully',    
                    'status' => 201
                ],201);
            }
       }else {
        return response()->json([
            'message' => 'Bill not created',    
            'status' => 500
        ],200);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        //
    }

    public function getById($id){
        
       $bill = Bill::find($id);

        if ($bill) { 

           $items=BillItem::where('bill_id',$bill->id)->get();
           $bill->items = $items;
           return response()->json([
            'message' => 'Bill find successful',
            'data'=> $bill,
            'status' => 200
            ],200);        
        }
        return response()->json([
            'message' => 'Bill not found',
            'data'=> [],
            'status' => 404
        ],200);

    }
}
