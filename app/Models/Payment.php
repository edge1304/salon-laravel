<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function acounting_entry(){
        return $this->belongsTo(AccountingEntry::class);
    }
    public function fundbook(){
        return $this->belongsTo(Fundbook::class);
    }
}
