<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'first_name',
        'last_name',
        'usn',
        'password_hash',
        'email',
        'phone_number',
        'role',
        'locked_until',
        'attempts',
        'last_login',
        'is_active',
        'is_deleted',
    ];

    protected $hidden = [
        'password_hash',
    ];

    // ✅ Automatically convert timestamps to Carbon instances
    protected $casts = [
        'locked_until' => 'datetime',
        'last_login' => 'datetime',
        'is_active' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    // Relationships
    public function studentDocuments()
    {
        return $this->hasMany(DocumentRepository::class, 'student_id', 'user_id');
    }

    public function teacherDocuments()
    {
        return $this->hasMany(DocumentRepository::class, 'teacher_id', 'user_id');
    }

    public function approvedDocuments()
    {
        return $this->hasMany(DocumentRepository::class, 'approved_by', 'user_id');
    }
}
