<?php

namespace App\Domains\Project\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Project extends Model
{
    use UsesTenantConnection;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
