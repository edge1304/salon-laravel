<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function fundbook(){
        return $this->belongsTo(Fundbook::class,'fundbook_id','id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
