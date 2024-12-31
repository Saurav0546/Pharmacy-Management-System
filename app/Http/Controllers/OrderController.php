<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use App\Models\Medicine;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    
    public function index()
    {
        $orders = Order::with('medicines')->get();
        return response()->json([
            'data' => $orders,
            'message' => __('messages.orders.fetched')
        ], 200);
    }


    public function show($id)
    {
        return Order::with('medicines')->findOrFail($id);
        return response()->json([
            'data' => $order,
            'message' => __('messages.orders.fetched')
        ], 200);
    }

    public function store(StoreOrderRequest $request)
    {
        // Create the order
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'order_date' => $request->order_date
        ]);


        $medicinesData = [];
        $totalPrice = 0;  // Initialize the total price

        if ($request->has('medicines')) {
            foreach ($request->medicines as $medicine) {
                if (isset($medicine['id']) && isset($medicine['quantity'])) {
                  
                    $medicineRecord = Medicine::find($medicine['id']);
                    if ($medicineRecord) {
                       
                        $price = $medicineRecord->price;
                        $quantity = $medicine['quantity'];
                        $totalPrice += $price * $quantity;  

                        $medicinesData[$medicine['id']] = ['quantity' => $quantity];
                    }
                }
            }
        }

    
        $order->medicines()->attach($medicinesData);
        
        $order->total_price = $totalPrice;
        $order->save();

        return response()->json([
            'data' => $order->load('medicines'),
            'message' => __('messages.orders.created')
        ], 201);
    }



    public function update(OrderUpdateRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->only(['customer_name', 'order_date']));

        if ($request->has('medicines')) {
            $order->medicines()->detach();
            foreach ($request->medicines as $medicine) { {
                    $order->medicines()->attach($medicine['id'], ['quantity' => $medicine['quantity']]);
                }
            }
        }
        return response()->json([
            'data' => $order->load('medicines'),
            'message' => __('messages.orders.updated')
        ], 200);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(null, 204);
    }
}