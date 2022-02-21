<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'order_status_id',
        'payment_id',
        'uuid',
        'products',
        'address',
        'delivery_fee',
        'amount',
        'shipped_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'order_status_id' => 'integer',
        'payment_id' => 'integer',
        'products' => 'array',
        'address' => 'array',
        'delivery_fee' => 'float',
        'amount' => 'float',
        'shipped_at' => 'timestamp',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    /**
     * @return BelongsTo
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withTimestamps()
            ->withPivot('quantity');
    }

    public function scopeWithSort($query, $sorting)
    {

        if(empty($sorting)){
            return $query;
        }

        [$sortBy, $direction] = $sorting;

        return match ($sortBy) {
            default => $query,
            'user' => $query->whereHas('user',function($q) use ($sortBy, $direction){return $q->orderBy('first_name', $direction?'desc':'asc');}),
            'payment' => $query->whereHas('payment',function($q) use ($sortBy, $direction){return $q->orderBy('type', $direction?'desc':'asc');}),
            'order_status' =>  $query->whereHas('orderStatus',function($q) use ($sortBy, $direction){return $q->orderBy('title', $direction?'desc':'asc');}),
        };
    }

    public function scopeWithUser($query, $user)
    {
        if(!$user){
            return $query;
        }

        return  $query->whereHas('user', function($q) use ($user){
            return $q->where('first_name', 'like',"%$user%")->orWhere('last_name','like',"%$user%");
        });
    }

    public function scopeWithOrderStatus($query, $orderStatus)
    {
        if(!$orderStatus){
            return $query;
        }

        return  $query->whereHas('orderStatus', function($q) use ($orderStatus){
            return $q->where('title', $orderStatus);
        });
    }

    public function scopeWithPayment($query, $payment)
    {
        if(!$payment){
            return $query;
        }

        return  $query->whereHas('payment', function($q) use ($payment){
            return $q->where('type', $payment);
        });
    }
}
