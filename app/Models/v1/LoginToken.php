<?php

namespace App\Models\v1;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginToken extends Model
{
    use HasFactory;
    use UuidTrait;

    protected $guarded = [];
    protected $dates = [
        'expires_at', 'consumed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isValid()
    {
        return !$this->isExpired() && !$this->isConsumed();
    }

    public function isExpired()
    {
        return $this->expires_at->isBefore(now());
    }

    public function isConsumed()
    {
        return $this->consumed_at !== null;
    }

    public function consume()
    {
        $this->consumed_at = now();
        $this->save();
    }
}
