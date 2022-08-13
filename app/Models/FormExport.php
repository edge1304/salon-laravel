<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormExport extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function details(){ // liên kết với chi tiết
        return $this->hasMany(ExportDetail::class);
    }
}
