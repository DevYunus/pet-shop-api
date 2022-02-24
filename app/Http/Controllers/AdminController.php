<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request){
        $request->validate([
            'first_name' => ['sometimes','nullable','string'],
            'email' => ['sometimes','email'],
            'phone' => ['sometimes','integer'],
            'address' => ['sometimes','nullable','string'],
            'is_marketing' => ['sometimes','boolean'],
            'sortBy'=>['sometimes','in:first_name,email,phone_number,address,is_marketing'],
            'desc'=>['boolean|required_if:sortBy']
        ]);

        $sorting = [$request->input('sortBy'), $request->input('desc',true)];

        $users = User::query()
            ->admin()
            ->withSort($sorting)
            ->withFirstName($request->input('first_name'))
            ->withEmail($request->input('email'))
            ->withPhone($request->input('phone_number'))
            ->withAddress($request->input('address'))
            ->withIsMarketing($request->input('is_marketing'))
            ->paginate();

        return new UserCollection($users);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

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
}
