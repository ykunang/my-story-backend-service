<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStoryRequest;
use App\Http\Services\StoryService;

class StoryServiceController extends Controller
{

    public function __construct(private StoryService $service)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stories = $this->service->getStories();
        return $this->responseSuccess(data: $stories->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateStoryRequest $request)
    {
        $result = $this->service->createStory(
            $request->safe()->except('photo'),
            $request->file('photo'),
            $request->user()->id
        );
        return $this->responseSuccess(data: $result, message: 'Create story successfull');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stories = $this->service->getStoryById($id);
        return $this->responseSuccess(data: $stories);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->deleteStoryById($id);
        return $this->responseSuccess(message: 'Delete story sucessfull');
    }
}
