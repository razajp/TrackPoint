<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'type',
        'date',
        'amount',
        'cheque_no',
        'bank',
        'issue_date',
        'clear_date',
        'slip_no',
        'party',
        't_id'
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id')->where('status', 'active');
    }
}
