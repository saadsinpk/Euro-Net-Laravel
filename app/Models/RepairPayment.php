<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairPayment extends Model
{
    use HasFactory;

    protected $table = "repair_payments";

    protected $primaryKey = 'id';

    public function request() {
        return $this->hasMany(paymentRequest::class, 'repair_id');
    }

}
