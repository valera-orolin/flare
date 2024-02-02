<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory;

    public $fillable = [
        'user1_id',
        'user2_id',
    ];

    public function user($id): BelongsTo
    {
        return $this->belongsTo(User::class, 'user' . $id . '_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
