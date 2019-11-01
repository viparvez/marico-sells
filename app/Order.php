<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['retailer_id', 'code', 'phone', 'name', 'location', 'bazar', 'businessarea', 'quest', 'req', 'solution', 'calltype', 'active', 'deleted', 'createdbyuserid', 'updatedbyuserid'];

    public function Retailer() {
    	return $this->belongsTo('App\Retailer', 'retailer_id');
    }

	public function Orderdetail(){
		return $this->hasMany('App\Orderdetail', 'order_id');
	}
    
    public function CreatedBy() {
        return $this->belongsTo('App\User', 'createdbyuserid');
    }

    public function UpdatedBy() {
        return $this->belongsTo('App\User', 'updatedbyuserid');
    }
}
