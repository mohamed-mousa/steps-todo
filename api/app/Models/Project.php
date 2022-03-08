<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_name',
        'user_id',
        'color',
    ];

    /**
     *
     */
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    /**
     *
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
