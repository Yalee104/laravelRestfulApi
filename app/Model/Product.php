<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Product
 *
 * @property int $id
 * @property string $name
 * @property string $detail
 * @property int $price
 * @property int $stock
 * @property int $discount
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Review[] $reviews
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereUserId($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    /*  Aaron
     *  NOTE:   We add fillable to prevent overwriting protected keys during mass assignment,
     *          in this case only below key is allowed to be updated or created
     */
    protected $fillable = ['name', 'detail', 'price', 'stock', 'discount', 'user_id'];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
