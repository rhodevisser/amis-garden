---
paths:
  - 'app/Models/**'
---

# Models

## Don't write scopes that alias built-in query methods
Never write a local scope that only renames an existing builder method. `latest()`, `oldest()`, `whereBelongsTo()`, `withCount()`, `withExists()` are built in — call them directly. `scopeNewest()` wrapping `orderBy('created_at', 'desc')` is a synonym, not an abstraction.

Write a scope when the name says something the query itself doesn't: it names a domain concept (`published()`, `root()`, `visibleTo($user)`), keeps schema detail out of call sites, or bundles constraints that should change in one place. Size is not the test — `root()` is a single `whereNull('parent_id')` and still earns its place, because "root comment" is domain vocabulary and the null-check is schema trivia.

If a scope earns its place: take the builder as a parameter, apply the constraint to it, and mark it `#[Scope]` (or use the `scopeX` prefix). A scope that calls `$this->orderBy(...)` on the model instead of `$query->...` starts a NEW query and silently discards every constraint chained before it.

## Soft deletes do not cascade - deleted comments are tombstones
`SoftDeletes` performs an UPDATE, so a `cascadeOnDelete()` foreign key never fires. Never rely on children disappearing along with a soft-deleted parent.

For `Comment` the chosen convention is the tombstone: `delete()` leaves the row and its `parent_id` intact and does not touch replies. Do not add a `deleting` event that soft-deletes replies as well.

Consequence for anyone loading the thread: use `withTrashed()`, otherwise the global scope filters the tombstone out and the replies are orphaned again. Note that `forceDelete()` is a real DELETE, so the cascade does fire then and takes the whole branch with it.
