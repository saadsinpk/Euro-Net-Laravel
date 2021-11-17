<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairReply extends Model
{
    use HasFactory;

    
    protected $table = "repair_reply";

    protected $primaryKey = 'id';

    public function repair() {
        return $this->belongsTo(RepairPayment::class, 'repair_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
