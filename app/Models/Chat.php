<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable = [
        'user1_id',
        'user2_id',
    ];

    /**
     * Get the user associated with the chat.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user($id): BelongsTo
    {
        return $this->belongsTo(User::class, 'user' . $id . '_id');
    }

    /**
     * Get the messages associated with the chat.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}