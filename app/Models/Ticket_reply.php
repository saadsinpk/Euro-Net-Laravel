<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket_reply extends Model
{
    use HasFactory;

    protected $table = "tickets_reply";

    protected $fillable = [
        'description',
        'ticket_id',
        'user_id',
        'file_name',
        'updated_at',
        'created_at',
    ];

    public function ticket() {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
