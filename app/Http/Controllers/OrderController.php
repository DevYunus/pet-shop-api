<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Policies\OrderPolicy;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return OrderCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request): OrderCollection
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
     * @param Order $order
     * @return OrderResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Order $order): OrderResource
    {
        $this->authorize($order);

        return new OrderResource($order);
    }

    /**
     * @param Request $request
     * @param Order $order
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Order $order)
    {
        $this->authorize($order);
        // todo - implement order update feature
    }

    /**
     * @param Order $order
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Order $order): Response
    {
        $this->authorize($order);

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
