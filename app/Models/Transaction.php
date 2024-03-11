<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory, HasUuids;

   
    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    protected $fillable = [
        'transaction_date', 'total_amount', 'payment_method'
    ];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public function items()
    {
        return $this->hasMany(TransactionItem::class, 'id_transaction');
    }
}
