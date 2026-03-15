<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements JWTSubject    
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'is_super_admin',
        'designation'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        # 'remember_token',
    ];

    public function createRefreshToken(): string
    {
        try {
            $simpleToken = Str::random(60);

            $maxAllowableRefreshTokens = 5;

            # delete expired refresh tokens
            $this->refreshTokens()->where('expires_at', '<', now())->delete();

            $refreshTokens = $this->refreshTokens()->get();

            if ($refreshTokens->count() > $maxAllowableRefreshTokens) {
                $refreshTokens->oldest()->first()->delete();
            }

            RefreshToken::create([
                'user_id' => $this->id,
                'token' => hash('sha256', $simpleToken),
                'expires_at' => now()->addDays(30), 
            ]);

            return $simpleToken;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function refreshTokens() : HasMany 
    {
        return $this->hasMany(RefreshToken::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier () 
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims() 
    {
        return [];
    }
}
