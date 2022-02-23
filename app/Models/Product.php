<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_uuid',
        'uuid',
        'title',
        'price',
        'description',
        'metadata',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'price' => 'float',
        'metadata' => 'array',
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->withTimestamps()
            ->withPivot('quantity');
    }

    public function scopeWithSort($query, $sorting)
    {
        if(empty($sorting)){
            return $query;
        }

        [$sortBy, $direction] = $sorting;
        return  $query->orderBy($sortBy, $direction?'desc':'asc');
    }

    public function scopeWithCategory($query, $category)
    {
        if(!$category){
            return $query;
        }

        return  $query->whereHas('category', function($q) use ($category){
            return $q->where('title','like', "%$category%");
        });
    }

    public function scopeWithPrice($query, $price)
    {
        if(!$price){
            return $query;
        }

        return  $query->where('price', $price);
    }

    public function scopeWithTitle($query, $title)
    {
        if(!$title){
            return $query;
        }

        return  $query->where('title', "%$title%");
    }
}
