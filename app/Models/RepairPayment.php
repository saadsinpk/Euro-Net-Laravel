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
        return $this->hasMany(PaymentRequest::class, 'repair_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id')->where("verify", '1');
    }

    public function reply() {
        return $this->hasMany(RepairReply::class, 'repair_id');
    }

    public function notes() {
        return $this->hasMany(RepairNotes::class, 'repair_id');
    }

    public function bitmain() {
        return $this->belongsTo(BitMain::class, 'bitmain_id');
    }

    public function repairStatus() {
        return $this->belongsTo(RepairStatus::class, 'status');
    }
}
