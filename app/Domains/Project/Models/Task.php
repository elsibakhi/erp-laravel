<?php

namespace App\Domains\Project\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Task extends Model
{
    use UsesTenantConnection;

    protected $fillable = [
        'project_id',
        'assigned_to',
        'title',
        'description',
        'due_date',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
