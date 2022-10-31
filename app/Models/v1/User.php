<?php

namespace App\Models\v1;

use App\Mail\v1\MagicLoginLink;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    use UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'display_name',
        'email',
        'account_type',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function loginTokens()
    {
        return $this->hasMany(LoginToken::class);
    }

    public function sendLoginLink()
    {
        $plaintext = Str::random(32);
        $token = $this->loginTokens()->create(
            [
                'token' => hash('sha256', $plaintext),
                'expires_at' => now()->addMinutes(15),
            ]
        );
        Mail::to($this->email)->queue(new MagicLoginLink($plaintext, $token->expires_at));
    }
}
