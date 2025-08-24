<?php

namespace App\Domains\Project\Controllers;

use App\Domains\Project\Models\Project;
use App\Domains\Project\Requests\StoreProjectRequest;
use App\Domains\Project\Resources\ProjectResource;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

class ProjectController extends Controller
{
    //
    use ApiResponse;

    public function index()
    {

        $projects = Project::all();

        return $this->successResponse(
            ProjectResource::collection($projects),
            'projects retrieved successfully'
        );
    }

    public function store(StoreProjectRequest $request)
    {

        $project = Project::create($request->validated());

        return $this->successResponse(
            new ProjectResource($project),
            'Project created successfully',
            201
        );
    }

    public function update(StoreProjectRequest $request, Project $project)
    {

        $project->update($request->validated());

        return $this->successResponse(
            new ProjectResource($project),
            'Project updated successfully'
        );
    }

    public function destroy(Project $project)
    {

        $project->delete();

        return $this->successResponse(
            null,
            'Project deleted successfully'
        );
    }
}
