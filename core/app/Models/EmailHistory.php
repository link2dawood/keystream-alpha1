<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailHistory extends Model
{
    protected $casts = [
        'schedule' => 'datetime'
    ];
    public function smtp()
    {
        return $this->belongsTo(Smtp::class, 'email_host_id');
    }
}
