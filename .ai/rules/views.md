---
paths:
  - 'resources/views/**'
---

# Views

## Render deleted comments as a tombstone
A soft-deleted comment stays in place to hold the thread together. When `$comment->trashed()`, render only a placeholder ("[deleted]") - no author, content, reply button or like button.

Do not render a tombstone that has no surviving replies; otherwise every deletion leaves litter behind.

The controller must supply the thread with `withTrashed()`, otherwise the parent is missing and the nesting breaks.
