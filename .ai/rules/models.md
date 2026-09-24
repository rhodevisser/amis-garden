---
paths:
  - 'app/Models/**'
---

# Models

## Don't write scopes that alias built-in query methods
Never write a local scope that only renames an existing builder method. `latest()`, `oldest()`, `whereBelongsTo()`, `withCount()`, `withExists()` are built in — call them directly. `scopeNewest()` wrapping `orderBy('created_at', 'desc')` is a synonym, not an abstraction.

Write a scope when the name says something the query itself doesn't: it names a domain concept (`published()`, `root()`, `visibleTo($user)`), keeps schema detail out of call sites, or bundles constraints that should change in one place. Size is not the test — `root()` is a single `whereNull('parent_id')` and still earns its place, because "root comment" is domain vocabulary and the null-check is schema trivia.

If a scope earns its place: take the builder as a parameter, apply the constraint to it, and mark it `#[Scope]` (or use the `scopeX` prefix). A scope that calls `$this->orderBy(...)` on the model instead of `$query->...` starts a NEW query and silently discards every constraint chained before it.
