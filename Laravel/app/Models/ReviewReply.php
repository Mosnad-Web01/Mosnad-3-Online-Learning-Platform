<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id', 'user_id', 'reply_text', 'parent_id'
    ];

    // العلاقة مع المراجعة
    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    // العلاقة مع المستخدم الذي كتب الرد
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع الردود الأصلية (الردود المتداخلة)
    public function parent()
    {
        return $this->belongsTo(ReviewReply::class, 'parent_id');
    }

    // العلاقة مع الردود التي تكون تحت هذا الرد
    public function children()
    {
        return $this->hasMany(ReviewReply::class, 'parent_id');
    }


}