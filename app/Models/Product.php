<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function images_relationship(){ // liên kết với ảnh , bài 30
        return $this->hasMany(ImageProduct::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }

}
