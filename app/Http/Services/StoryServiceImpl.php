<?php

namespace App\Http\Services;

use App\Models\Story;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

interface StoryService
{
    function createStory(Request $request);
    function getStories();
    function getStoryById($id);
    function deleteStoryById($id);
}

class StoryServiceImpl implements StoryService
{
    public function createStory(Request $request)
    {
        $story = $request->safe()->all();

        if ($request->has('photo')) {
            $photo = $request->file('photo')->store('public/stories');
            $story = array_merge($story, ['user_id' => $request->user()->id, 'photo' => $photo]);
        }

        return Story::create($story)->load('user', 'category')->toArray();
    }

    public function getStories()
    {
        return Story::with('user', 'category')->get();
    }

    public function getStoryById($id)
    {
        $story =  Story::with('user', 'category')->find($id);
        return !is_null($story) ? $story->toArray() : throw new BadRequestHttpException('Data story not found');
    }

    public function deleteStoryById($id)
    {
        $story = Story::find($id);
        return !is_null($story) ? $story->delete(): throw new BadRequestHttpException(message: 'Data story not found');
    }
}

