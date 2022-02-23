<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserOrdersRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{


    /**
     * @param Request $request
     * @return UserResource
     */
    public function store(Request $request, User $user)
    {
        return new UserResource($user);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return UserResource
     */
    public function update(Request $request, User $user)
    {
        return new UserResource($user);
    }

    /**
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        if(!$user->delete()){
            return \response([
                'message' => 'Unable to delete User.'
            ],'400');
        }

        return \response([
            'message' => 'User has been deleted successfully.'
        ]);
    }

    /**
     * @param UserOrdersRequest $request
     * @return OrderCollection
     */
    public function userOrders(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'sortBy'=>['sometimes','in:order_status,payment'],
            'desc'=>['boolean|required_if:sortBy']
        ]);

        $sorting = [$request->input('sortBy'), $request->input('desc',true)];

        $userOrders = $user->orders()
            ->with('user',function($query){
                return $query->select(['id', 'first_name', 'last_name']);
            })
            ->with('payment',function($query){
                return $query->select(['id', 'type']);
            })
            ->with('orderStatus',function($query){
                return $query->select(['id', 'title']);
            })
            ->withSort($sorting)
                ->withOrderStatus($request->input('order_status'))
            ->withPayment($request->input('payment'))
            ->paginate();

        return new OrderCollection($userOrders);
    }

}
