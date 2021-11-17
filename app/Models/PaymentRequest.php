<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    use HasFactory;
    protected $table = "payment_request";
    protected $primaryKey = 'id';

    public function repairPayment() {
        return $this->belongsTo(RepairPayment::class, 'repair_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
