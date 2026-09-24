# Spec: Photo Engagement Feature

## Database Schema

### `photo_snacks` table
- `id` (primary key)
- `user_id` (foreign key to `users`, constrained, index)
- `photo_id` (foreign key to `photos`, constrained, index)
- `timestamps`
- Unique constraint on `[user_id, photo_id]`

### `comments` table
- `id` (primary key)
- `user_id` (foreign key to `users`, constrained)
- `photo_id` (foreign key to `photos`, constrained)
- `parent_id` (foreign key to `comments`, nullable, constrained)
- `content` (text)
- `timestamps`
- `deleted_at` (soft deletes)

### `comment_likes` table
- `id` (primary key)
- `user_id` (foreign key to `users`, constrained)
- `comment_id` (foreign key to `comments`, constrained)
- `timestamps`
- Unique constraint on `[user_id, comment_id]`

## Models

### `PhotoSnack`
- Belongsto `User`
- BelongsTo `Photo`

### `Comment`
- BelongsTo `User`
- BelongsTo `Photo`
- BelongsTo `Parent` (Comment)
- HasMany `Replies` (Comment)
- HasMany `Likes` (CommentLike)
- Scope `root()` for top-level comments

### `CommentLike`
- BelongsTo `User`
- BelongsTo `Comment`

## API / Web Routes
- `POST /photos/{photo}/snack` -> `PhotoSnackController@toggle`
- `POST /photos/{photo}/comments` -> `CommentController@store`
- `POST /comments/{comment}/reply` -> `CommentController@reply`
- `POST /comments/{comment}/like` -> `CommentLikeController@toggle`
- `DELETE /comments/{comment}` -> `CommentController@destroy`

## Authorization
- Only logged-in users can snack, comment and like.
- Only the author of a comment can delete it.
