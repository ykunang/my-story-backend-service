<?php

namespace Tests\Unit;

use App\Http\Services\StoryService;
use App\Http\Services\StoryServiceImpl;
use App\Models\Story;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tests\TestCase;

class StoryServiceTest extends TestCase
{

    private StoryService $storyService;

    public function setUp():void
    {
        parent::setUp();
        $this->storyService = new StoryServiceImpl();
    }

    public function test_create_story_should_success()
    {
        $storyData = [
            'title' => 'title',
            'description' => 'description',
            'category_id' => 1,
        ];

        $user = User::factory()->create();
        $storyPhoto = UploadedFile::fake()->image('avatar.jpg');

        // act
        $story = $this->storyService->createStory($storyData, $storyPhoto, $user->id);

        // assert
        $this->assertNotNull($story);
        $this->assertSame($story['title'], $storyData['title']);
        $this->assertSame($story['description'], $storyData['description']);
        $this->assertSame($story['category_id'], $storyData['category_id']);
        $this->assertSame($story['user_id'], $user->id);
    }

    public function test_get_story_by_id_should_success()
    {
        // stubs
        $story = Story::factory()->create();
        // act
        $result = $this->storyService->getStoryById($story->id);

        // assert
        $this->assertSame($story->title, $result['title']);
        $this->assertSame($story->description, $result['description']);
        $this->assertSame($story->category_id, $result['category_id']);
        $this->assertSame($story->user_id, $result['user_id']);
    }

    public function test_get_story_by_id_should_failure()
    {
        // act
        $this->expectException(BadRequestHttpException::class);
        $result = $this->storyService->getStoryById(29);
        $this->assertNull($result);
    }

    public function test_delete_story_by_id_should_success()
    {
        // stubs
        $story = Story::factory()->create();
        $oldStory = Story::find($story->id);

        $this->assertNotNull($oldStory);
        // act
        $this->storyService->deleteStoryById($story->id);

        // assert
        $newStory = Story::find($story->id);
        $this->assertNull($newStory);
    }

    public function test_delete_story_should_failure()
    {
        // act
        $this->expectException(BadRequestHttpException::class);
        $result = $this->storyService->deleteStoryById(29);
        $this->assertNull($result);
    }
}
