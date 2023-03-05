<?php

namespace Tests\Feature;

use App\Models\Story;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tests\TestCase;

class StoryControllerTest extends TestCase
{
    private function getUser(): User
    {
        return User::factory()->create();
    }
    /**
     * A basic feature test example.
     */
    public function test_get_stories_should_success(): void
    {
        /// stubs
        $this->actingAs($this->getUser());
        Story::factory()->count(3)->create();

        // act
        $response = $this->get('/api/stories', $this->header);

        // assert
        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));
    }


    public function test_create_story_should_sucess(): void
    {
        $this->actingAs($this->getUser());
        // act
        $response = $this->post('/api/stories', [
                'category_id' => random_int(1,4),
                'title' => 'title',
                'description'=> 'description',
                'photo' => UploadedFile::fake()->image('avatar.jpg'),
            ],
            headers: $this->header
        );
        /// assert
        $response->assertStatus(200);
        $this->assertNotNull($response->json('data'));
    }


    public function test_get_story_by_id_should_success(): void
    {
        // stub
        $this->actingAs($this->getUser());
        $expectedStory = Story::factory()->create();

        // act
        $id = $expectedStory->id;
        $response = $this->get("/api/stories/$id" , headers: $this->header);

        // assert
        $response->assertStatus(200);
        $this->assertSame($response->json('data.id'), $expectedStory->id);
        $this->assertSame($response->json('data.title'), $expectedStory->title);
        $this->assertSame($response->json('data.description'), $expectedStory->description);
    }

    public function test_get_story_should_throw_exception_when_no_data_found(): void
    {
        // stub
        $this->actingAs($this->getUser());

        // act
        $response = $this->get("/api/stories/2", headers: $this->header);

        // assert
        $response->assertStatus(400);
        $this->assertSame($response->json('message'), "Data story not found");
    }

    public function test_delete_story_by_id_should_success(): void
    {
        // stub
        $this->actingAs($this->getUser());
        $expectedStory = Story::factory()->create();

        // act
        $id = $expectedStory->id;
        $response = $this->delete("/api/stories/$id", headers: $this->header);

        // assert
        $response->assertStatus(200);
        $this->assertSame($response->json('message'),  "Delete story sucessfull");
    }

    public function test_delete_story_by_id_should_failure_when_no_data_found(): void
    {
        // stubs
        $this->actingAs($this->getUser());

        // act
        $response = $this->delete("/api/stories/10", headers: $this->header);

        // assert
        $response->assertStatus(400);
        $this->assertSame($response->json('message'), "Data story not found");
    }
}
