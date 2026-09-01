<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'client_id', 'is_active', 'avatar', 'plan'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /** Super admin / SaaS owner — full platform access. */
    public const ROLE_SUPER_ADMIN = 'super_admin';

    /** Brand admin — manages a single client/brand (scoped by client_id). */
    public const ROLE_BRAND_ADMIN = 'brand_admin';

    /** Standard user / agency staff member. */
    public const ROLE_USER = 'user';

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the client/brand this user administers (nullable for super admins).
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isBrandAdmin(): bool
    {
        return $this->role === self::ROLE_BRAND_ADMIN;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function hasRole(array|string $roles): bool
    {
        return in_array($this->role, (array) $roles, true);
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    /**
     * Human-friendly label for the role badge.
     */
    public function roleLabel(): string
    {
        return match ($this->role) {
            self::ROLE_SUPER_ADMIN => 'Super Admin',
            self::ROLE_BRAND_ADMIN => 'Brand Admin',
            default => 'User',
        };
    }

    /**
     * Tailwind badge classes per role.
     */
    public function roleBadgeClass(): string
    {
        return match ($this->role) {
            self::ROLE_SUPER_ADMIN => 'bg-brand-100 text-brand-800 border-brand-200',
            self::ROLE_BRAND_ADMIN => 'bg-violet-100 text-violet-800 border-violet-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };
    }
}
