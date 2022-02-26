<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelPost extends Model
{
    use HasFactory;

    protected $table = 'labels_posts';

    protected $fillable = [
        'label_id',
        'post_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function label()
    {
        return $this->belongsTo(Label::class, 'label_id', 'id');
    }

}
