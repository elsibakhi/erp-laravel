<?php

namespace App\Domains\Project\Controllers;

use App\Domains\Project\Models\Project;
use App\Domains\Project\Models\Task;
use App\Domains\Project\Requests\StoreTaskRequest;
use App\Domains\Project\Resources\TaskResource;
use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Traits\TenantGuard;

class TaskController extends Controller
{
    //
    use TenantGuard;

    public function index(Project $project)
    {
        authorizePermission('view tasks', $this->getGuard());
        $tasks = $project->tasks()->paginate(10);

        return ApiResponse::success(
            TaskResource::collection($tasks),
            'Tasks retrieved successfully', 200, $tasks->nextPageUrl()
        );
    }

    public function store(StoreTaskRequest $request, Project $project)
    {
        authorizePermission('store tasks', $this->getGuard());
        $task = $project->tasks()->create($request->validated());

        return ApiResponse::success(
            new TaskResource($task),
            'Task created successfully',
            201
        );
    }

    public function update(StoreTaskRequest $request, $project, Task $task)
    {
        authorizePermission('update tasks', $this->getGuard());
        $task->update($request->validated());

        return ApiResponse::success(
            new TaskResource($task),
            'Task updated successfully'
        );
    }

    public function destroy($project, Task $task)
    {
        authorizePermission('destroy tasks', $this->getGuard());
        $task->delete();

        return ApiResponse::success(
            null,
            'Task deleted successfully'
        );
    }
}
