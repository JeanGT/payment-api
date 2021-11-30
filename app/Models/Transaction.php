<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type',
        'value',
        'account_id'
    ];

    public static function createTransaction($transaction){
        //TODO -> validation and trigger account creation
        return Transaction::create($transaction);
    }

    public function account(){
        return $this->belongsTo(Account::class);
    }
}
