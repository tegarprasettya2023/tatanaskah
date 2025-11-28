<?php
// ============================================
// FILE: app/Models/User.php - SIMPLIFIED
// ============================================

namespace App\Models;

use App\Enums\ConfigEnum;
use App\Enums\Role;
use App\Models\Config;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'is_active',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Accessor untuk default avatar
     */
    public function getProfilePictureAttribute($value)
    {
        // Jika ada foto custom
        if (!empty($value)) {
            return $value;
        }
        
        // Default: avatar dengan initial nama (seperti Google)
        return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . 
               "&color=fff&background=696cff&size=120&bold=true";
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRole($query, Role $role)
    {
        return $query->where('role', $role->status());
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query, $find) {
            return $query
                ->where('name', 'LIKE', $find . '%')
                ->orWhere('phone', $find)
                ->orWhere('email', $find);
        });
    }

    public function scopeRender($query, $search)
    {
        return $query
            ->search($search)
            ->whereIn('role', [
                Role::STAFF->status(),
                Role::STAFF_PENGAWAS->status(),
            ])
            ->paginate(Config::getValueByCode(ConfigEnum::PAGE_SIZE))
            ->appends([
                'search' => $search,
            ]);
    }
}

