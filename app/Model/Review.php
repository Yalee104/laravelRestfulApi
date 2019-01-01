<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

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
