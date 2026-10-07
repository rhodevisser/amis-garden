<?php

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Photo;
use App\Models\PhotoSnack;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects guests away from the engagement endpoints', function () {
    $photo = Photo::factory()->create();
    $comment = Comment::factory()->for($photo)->create();

    $this->post(route('photos.snack', $photo))->assertRedirect(route('login'));
    $this->post(route('comments.store', $photo))->assertRedirect(route('login'));
    $this->post(route('comments.like', $comment))->assertRedirect(route('login'));
    $this->delete(route('comments.destroy', $comment))->assertRedirect(route('login'));
});

it('gives a snack to a photo', function () {
    $user = User::factory()->create();
    $photo = Photo::factory()->create();

    $this->actingAs($user)->post(route('photos.snack', $photo));

    $this->assertDatabaseHas('photo_snacks', [
        'user_id' => $user->id,
        'photo_id' => $photo->id,
    ]);
});

it('takes back a snack when the same user snacks twice', function () {
    $user = User::factory()->create();
    $photo = Photo::factory()->create();
    PhotoSnack::factory()->for($user)->for($photo)->create();

    $this->actingAs($user)->post(route('photos.snack', $photo));

    $this->assertDatabaseMissing('photo_snacks', [
        'user_id' => $user->id,
        'photo_id' => $photo->id,
    ]);
});

it('shows the snack count on the photo overview', function () {
    $user = User::factory()->create();
    $photo = Photo::factory()->create();
    PhotoSnack::factory()->count(3)->for($photo)->create();

    $this->actingAs($user)
        ->get(route('photos.index'))
        ->assertSee('Give this photo a snack')
        ->assertSee('>3<', escape: false);
});

it('stores a comment on a photo', function () {
    $user = User::factory()->create();
    $photo = Photo::factory()->create();

    $this->actingAs($user)->post(route('comments.store', $photo), [
        'content' => 'What a lovely garden!',
    ]);

    $this->assertDatabaseHas('comments', [
        'user_id' => $user->id,
        'photo_id' => $photo->id,
        'parent_id' => null,
        'content' => 'What a lovely garden!',
    ]);
});

it('stores a reply to an existing comment', function () {
    $user = User::factory()->create();
    $photo = Photo::factory()->create();
    $parent = Comment::factory()->for($photo)->create();

    $this->actingAs($user)->post(route('comments.store', $photo), [
        'content' => 'I agree!',
        'parent_id' => $parent->id,
    ]);

    $this->assertDatabaseHas('comments', [
        'photo_id' => $photo->id,
        'parent_id' => $parent->id,
        'content' => 'I agree!',
    ]);
});

it('rejects a reply to a comment on another photo', function () {
    $user = User::factory()->create();
    $photo = Photo::factory()->create();
    $otherComment = Comment::factory()->create();

    $this->actingAs($user)
        ->post(route('comments.store', $photo), [
            'content' => 'I agree!',
            'parent_id' => $otherComment->id,
        ])
        ->assertSessionHasErrors('parent_id');

    $this->assertDatabaseMissing('comments', ['content' => 'I agree!']);
});

it('requires comment content', function () {
    $user = User::factory()->create();
    $photo = Photo::factory()->create();

    $this->actingAs($user)
        ->post(route('comments.store', $photo), ['content' => ''])
        ->assertSessionHasErrors('content');
});

it('lets the author delete their own comment', function () {
    $user = User::factory()->create();
    $comment = Comment::factory()->for($user)->create();

    $this->actingAs($user)->delete(route('comments.destroy', $comment));

    $this->assertSoftDeleted($comment);
});

it('forbids deleting someone elses comment', function () {
    $comment = Comment::factory()->create();

    $this->actingAs(User::factory()->create())
        ->delete(route('comments.destroy', $comment))
        ->assertForbidden();

    $this->assertNotSoftDeleted($comment);
});

it('shows a deleted comment as a tombstone when it still has replies', function () {
    $user = User::factory()->create();
    $photo = Photo::factory()->create();
    $parent = Comment::factory()->for($photo)->create(['content' => 'Original comment']);
    Comment::factory()->replyTo($parent)->create(['content' => 'Surviving reply']);

    $parent->delete();

    $this->actingAs($user)
        ->get(route('photos.show', $photo))
        ->assertSee('[deleted]')
        ->assertDontSee('Original comment')
        ->assertSee('Surviving reply');
});

it('hides a deleted comment that has no replies', function () {
    $user = User::factory()->create();
    $photo = Photo::factory()->create();
    $comment = Comment::factory()->for($photo)->create(['content' => 'Original comment']);

    $comment->delete();

    $this->actingAs($user)
        ->get(route('photos.show', $photo))
        ->assertDontSee('[deleted]')
        ->assertDontSee('Original comment');
});

it('shows the comment thread on the photo detail page', function () {
    $user = User::factory()->create();
    $photo = Photo::factory()->create();
    $parent = Comment::factory()->for($photo)->create(['content' => 'Top level comment']);
    Comment::factory()->replyTo($parent)->create(['content' => 'Nested reply']);

    $this->actingAs($user)
        ->get(route('photos.show', $photo))
        ->assertSeeInOrder(['Top level comment', 'Nested reply']);
});

it('offers a reply form on root comments only', function () {
    $user = User::factory()->create();
    $photo = Photo::factory()->create();
    $parent = Comment::factory()->for($photo)->create();
    Comment::factory()->replyTo($parent)->create();

    $content = $this->actingAs($user)
        ->get(route('photos.show', $photo))
        ->getContent();

    expect(substr_count($content, 'Post reply'))->toBe(1);
});

it('likes a comment', function () {
    $user = User::factory()->create();
    $comment = Comment::factory()->create();

    $this->actingAs($user)->post(route('comments.like', $comment));

    $this->assertDatabaseHas('comment_likes', [
        'user_id' => $user->id,
        'comment_id' => $comment->id,
    ]);
});

it('removes the like when the same user likes a comment twice', function () {
    $user = User::factory()->create();
    $comment = Comment::factory()->create();
    CommentLike::factory()->for($user)->for($comment)->create();

    $this->actingAs($user)->post(route('comments.like', $comment));

    $this->assertDatabaseMissing('comment_likes', [
        'user_id' => $user->id,
        'comment_id' => $comment->id,
    ]);
});

it('does not let a user like a deleted comment', function () {
    $user = User::factory()->create();
    $comment = Comment::factory()->create();
    $comment->delete();

    $this->actingAs($user)
        ->post(route('comments.like', $comment))
        ->assertNotFound();
});
