<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
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
    protected $with = ['payloadHistories'];

    /**
     * @var array
     */
    protected $casts = [
        'payload' => 'array',
        'request_headers' => 'array',
        'received' => 'boolean',
    ];

    /**
     * @return mixed
     */
    public function payloadHistories()
    {
        return $this->hasMany(PayloadHistory::class, 'webhook_id', 'id');
    }

    public function getCallbackUrlAttribute()
    {
        return route('callback.url', $this->request_id);
    }

}
