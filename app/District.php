<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['code', 'name'];

    public function Towns(){
    	return $this->hasMany('App\Town', 'district_id');
    }

    public function CreatedBy() {
        return $this->belongsTo('App\User', 'createdbyuserid');
    }

    public function UpdatedBy() {
        return $this->belongsTo('App\User', 'updatedbyuserid');
    }
}
