<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Models\AchievementList;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AchievementAndBadgeTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function testUserEarnsAchievementOnCommentWritten()
    {
        Event::fake();

        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);
        // $achievementList = AchievementList::whereCategory('comment')->get();

        Event::dispatch(new CommentWritten($comment));

        $this->assertDatabaseHas('user_achievements', [
            'user_id' => $user->id,
            // 'achievement_id' => $achievementList[0]->id,
            // assert that the appropriate achievement has been earned
            // You can add more assertions based on your application logic
        ]);
    }

    public function testUserEarnsBadgeOnLessonWatched()
    {
        Event::fake();

        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();

        Event::dispatch(new LessonWatched($lesson, $user));

        $this->assertDatabaseHas('user_badges', [
            'user_id' => $user->id,
            // assert that the appropriate badge has been earned
            // You can add more assertions based on your application logic
        ]);
    }

    public function testMultipleCommentsEarnMultipleAchievements()
    {
        Event::fake();

        $user = User::factory()->create();

        // Create multiple comments for the user
        $comments = Comment::factory()->count(3)->create(['user_id' => $user->id]);

        foreach ($comments as $comment) {
            Event::dispatch(new CommentWritten($comment));
        }

        $this->assertDatabaseCount('user_achievement', 3); // assert that the user has earned 3 achievements
    }

    public function testMultipleLessonsWatchedEarnsBadge()
    {
        Event::fake();

        $user = User::factory()->create();

        // Create multiple lessons
        $lessons = Lesson::factory()->count(5)->create();

        foreach ($lessons as $lesson) {
            Event::dispatch(new LessonWatched($lesson, $user));
        }

        $this->assertDatabaseHas('user_badges', [
            'user_id' => $user->id,
            // assert that the appropriate badge has been earned
            // You can add more assertions based on your application logic
        ]);
    }
}
