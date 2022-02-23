<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return OrderCollection
     */
    public function index(Request $request)
    {

        $request->validate([
            'sortBy'=>['sometimes','in:user,order_status,payment'],
            'desc'=>['boolean|required_if:sortBy']
        ]);

        $sorting = [$request->input('sortBy'), $request->input('desc',true)];

        $orders = Order::query()
            ->with('user',function($query){
                return $query->select(['id', 'first_name', 'last_name']);
            })
            ->with('payment',function($query){
                return $query->select(['id', 'type']);
            })
            ->with('orderStatus',function($query){
                return $query->select(['id', 'title']);
            })
            ->with('products')
            ->withSort($sorting)
            ->withUser($request->input('user'))
            ->withOrderStatus($request->input('order_status'))
            ->withPayment($request->input('payment'))
            ->paginate();

        return new OrderCollection($orders);
    }


    /**
     * @param Request $request
     * @param Order $order
     * @return OrderResource
     */
    public function show(Request $request, Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * @param Request $request
     * @param Order $order
     * @return OrderResource
     */
    public function update(Request $request, Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * @param Request $request
     * @param Order $order
     * @return Response
     */
    public function destroy(Order $order)
    {
        if(!$order->delete()){
            return \response([
                'message' => 'Unable to delete Order.'
            ],'400');
        }

        return \response([
            'message' => 'Order has been deleted successfully.'
        ]);
    }
}
