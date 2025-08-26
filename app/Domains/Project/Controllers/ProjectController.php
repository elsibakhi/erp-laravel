<?php

namespace App\Domains\Project\Controllers;

use App\Domains\Project\Models\Project;
use App\Domains\Project\Requests\StoreProjectRequest;
use App\Domains\Project\Resources\ProjectResource;
use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Traits\TenantGuard;

class ProjectController extends Controller
{
    //
    use TenantGuard;

    public function index()
    {
        authorizePermission('view projects', $this->getGuard());
        $projects = Project::with('tasks')->paginate(10);

        return ApiResponse::success(
            ProjectResource::collection($projects),
            'projects retrieved successfully', 200, $projects->nextPageUrl()
        );
    }

    public function store(StoreProjectRequest $request)
    {
        authorizePermission('store projects', $this->getGuard());
        $project = Project::create($request->validated());

        return ApiResponse::success(
            new ProjectResource($project),
            'Project created successfully',
            201
        );
    }

    public function update(StoreProjectRequest $request, Project $project)
    {
        authorizePermission('update projects', $this->getGuard());
        $project->update($request->validated());

        return ApiResponse::success(
            new ProjectResource($project),
            'Project updated successfully'
        );
    }

    public function destroy(Project $project)
    {
        authorizePermission('destroy projects', $this->getGuard());
        $project->delete();

        return ApiResponse::success(
            null,
            'Project deleted successfully'
        );
    }
}
