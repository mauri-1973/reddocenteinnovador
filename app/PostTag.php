<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostTag extends Model
{
    
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $table = "post_tag";

    protected $fillable = ['post_id', 'tag_id'];
    
    protected $casts = [
        'created_at' => 'date:d-m-Y',
        'updated_at' => 'date:d-m-Y',
        'deleted_at' => 'date:d-m-Y',
    ]; 
    public function posts()
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }
}