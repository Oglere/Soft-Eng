<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRepository extends Model
{
    use HasFactory;

    protected $table = 'document_repositories';
    protected $primaryKey = 'document_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'title',
        'abstract',
        'student_id',
        'teacher_id',
        'approved_by',
        'authors',
        'citation',
        'metadata',
        'file',
        'status',
        'date_submitted',
        'date_reviewed',
        'study_type',
        'abandoned_date',
        'recovered_date',
        'lost_date',
        'archived',
    ];

    protected $casts = [
        'date_submitted' => 'datetime',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'user_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'user_id');
    }
}
