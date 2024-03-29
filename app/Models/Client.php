<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Client extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    function tasks(int $projectId): BelongsToMany
    {
        return $this->belongsToMany(Task::class)->where('project_id', $projectId);
    }

    function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    function isEmployeeAssigned($projectId, $userId): bool
    {
        $options = [
            'client_id' => $this->id,
            'user_id' => $userId,
            'project_id' => $projectId,
        ];
        $item = DB::table('client_user')
            ->where($options)->first();

        return $item !== null;
    }

    function toggleTask($projectId, $taskId)
    {
        $task = $this->tasks($projectId)->withPivot('status')->wherePivot('task_id', $taskId)->first();
        $status = $task->pivot->status;
        $toggle = $this->tasks($projectId)->updateExistingPivot($taskId, [
            'status' => !$status
        ]);
        return $task;
    }
}
