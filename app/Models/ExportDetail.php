<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    function product(){
        return $this->belongsTo(Product::class);
    }
    function employee(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
