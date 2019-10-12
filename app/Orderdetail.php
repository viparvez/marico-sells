<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{

	protected $fillable = ['product_id','order_id','qty','subtotal','active', 'deleted', 'createdbyuserid', 'updatedbyuserid'];

    public function Order(){
		return $this->belongsTo('App\Order', 'order_id');
	}

    public function Product() {
        return $this->belongsTo('App\Product','product_id');
    }
    
    public function CreatedBy() {
        return $this->belongsTo('App\User', 'createdbyuserid');
    }

    public function UpdatedBy() {
        return $this->belongsTo('App\User', 'updatedbyuserid');
    }
}
