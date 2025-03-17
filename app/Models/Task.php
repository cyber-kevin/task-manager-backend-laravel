<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['title', 'description', 'status', 'end_date', 'user_id'];

    public static array $status = ['todo', 'doing', 'done', 'pending'];

    public function user(): HasOne {
        return $this->hasOne(User::class);
    }
}
