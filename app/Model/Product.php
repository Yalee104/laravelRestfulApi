<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

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
