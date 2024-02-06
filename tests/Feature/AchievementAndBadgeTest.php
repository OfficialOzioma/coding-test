<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use Illuminate\Support\Str;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Models\AchievementList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use App\Listeners\UnlockLessonAchievementListener;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Listeners\UnlockCommentAchievementListener;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AchievementAndBadgeTest extends TestCase
{

    use DatabaseTransactions;

    public function testCommentWrittenEvents()
    {
        Event::fake();

        // Create a user
        $user = User::factory()->create();

        // Simulate writing a comment
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        // Dispatch event for comment written
        Event::dispatch(new CommentWritten($comment));

        // Assert that the event was dispatched
        Event::assertDispatched(function (CommentWritten $event) use ($comment) {
            return $event->comment->id === $comment->id;
        });

        // Assert that the listener is listening for the CommentWritten event
        Event::assertListening(
            CommentWritten::class,
            UnlockCommentAchievementListener::class,
        );
    }

    public function testLessonWatchedEvent()
    {
        // Fake event
        Event::fake();

        // Create a user
        $user = User::factory()->create();

        // Simulate watching a lesson
        $lesson = Lesson::factory()->create();
        $user->watched()->attach($lesson, ['watched' => true]);

        // Dispatch event for lesson watched
        Event::dispatch(new LessonWatched($lesson, $user));

        // Assert that the event was dispatched
        Event::assertDispatched(function (LessonWatched $event) use ($lesson) {
            return $event->lesson->id === $lesson->id;
        });

        // Assert that the listener is listening for the LessonWatched event
        Event::assertListening(
            LessonWatched::class,
            UnlockLessonAchievementListener::class,
        );
    }
}
