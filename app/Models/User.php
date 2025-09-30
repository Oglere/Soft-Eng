<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // so you can still use Auth
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id'; // custom PK // why faller??? why custom pk?? when u can just use the id? and do hash manager *facepalm* -- norben
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
        'profile_picture',
        'last_login',
        'is_active',
    ];

    protected $hidden = [
        'password_hash',
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
