<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TransactionItem extends Model
{
    use HasFactory, HasUuids;

   
    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    protected $fillable = [
        'id_transaction', 'id_product', 'quantity', 'subtotal'
    ];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transaction');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
