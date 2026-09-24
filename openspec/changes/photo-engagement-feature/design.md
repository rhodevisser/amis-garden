# Design: Photo Engagement Feature

## Goal
Extend the photo gallery with interactive elements: snacks (likes) and comments (including replies and likes on comments).

## Concept
- **Snacks**: Instead of a standard 'like', users can give a photo a 'snack'. The emoji for this is a fish (🐟).
- **Comments**: Users can comment on photos.
- **Replies**: Users can reply to each other's comments (nested structure).
- **Comment Likes**: Users can like other people's comments.

## User Experience
- Only logged-in users can perform actions.
- A user can give at most 1 snack per photo (toggle action).
- Comments are displayed chronologically below the photo.
- Replies are displayed indented below the corresponding comment.

## Data Model
- `PhotoSnack`: `user_id`, `photo_id`
- `Comment`: `user_id`, `photo_id`, `parent_id` (nullable), `content`
- `CommentLike`: `user_id`, `comment_id`

## UI Elements
- Fish button (🐟) on each photo with a counter.
- Comment section below the photo detail page.
- "Reply" button on each comment that opens an input field.
- Heart button on each comment for likes.
