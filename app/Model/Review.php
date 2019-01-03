<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Review
 *
 * @property int $id
 * @property int $product_id
 * @property string $customer
 * @property string|null $review
 * @property int $star
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereStar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Review extends Model
{
    /*  Aaron
     *  NOTE:   We add fillable to prevent overwriting protected keys during mass assignment,
     *          in this case only below key is allowed to be updated or created
     */
    protected $fillable = ['product_id', 'customer', 'review', 'star'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
