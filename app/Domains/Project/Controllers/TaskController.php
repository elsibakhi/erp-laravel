<?php

namespace App\Domains\Project\Controllers;

use App\Domains\Project\Models\Project;
use App\Domains\Project\Models\Task;
use App\Domains\Project\Requests\StoreTaskRequest;
use App\Domains\Project\Resources\TaskResource;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

class TaskController extends Controller
{
    //
    use ApiResponse;

    public function index(Project $project)
    {

        $tasks = $project->tasks()->get();

        return $this->successResponse(
            TaskResource::collection($tasks),
            'Tasks retrieved successfully'
        );
    }

    public function store(StoreTaskRequest $request, Project $project)
    {

        $task = $project->tasks()->create($request->validated());

        return $this->successResponse(
            new TaskResource($task),
            'Task created successfully',
            201
        );
    }

    public function update(StoreTaskRequest $request, $project, Task $task)
    {

        $task->update($request->validated());

        return $this->successResponse(
            new TaskResource($task),
            'Task updated successfully'
        );
    }

    public function destroy($project, Task $task)
    {

        $task->delete();

        return $this->successResponse(
            null,
            'Task deleted successfully'
        );
    }
}
