<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayloadHistory extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $appends = [
        'callback_url',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'payload' => 'array',
        'request_headers' => 'array',
        'received' => 'boolean',
    ];

    public function getCallbackUrlAttribute()
    {
        return route('callback.url', $this->request_id);
    }
}
