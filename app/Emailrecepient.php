<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emailrecepient extends Model
{
    protected $fillable = ['template_id', 'address', 'type', 'createdbyuserid', 'updatedbyuserid'];

    public function CreatedBy() {
        return $this->belongsTo('App\User', 'createdbyuserid');
    }

    public function UpdatedBy() {
        return $this->belongsTo('App\User', 'updatedbyuserid');
    }
}
