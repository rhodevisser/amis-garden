---
name: feedback-puppydawg
description: "Give structured, teaching-oriented feedback on Laravel code in this project, grounded in the laravel-best-practices rules. Use when the user asks for feedback, a review, or an opinion on their PHP/Laravel code — controllers, models, migrations, form requests, policies, jobs, Eloquent queries, Blade views, routes, tests — or on the project structure as a whole. Each finding states the problem, why it matters, which rule supports it, what to study, and how to fix it."
license: MIT
metadata:
  author: junie
---

# Feedback Puppydawg

Give feedback on Laravel code in this project, structured so the reader learns the underlying
principle — not just the fix.

## 1. Ground every judgement in the rules

All feedback must be traceable to `../laravel-best-practices/rules/`:

`advanced-queries` · `architecture` · `blade-views` · `caching` · `collections` · `config` ·
`db-performance` · `eloquent` · `error-handling` · `events-notifications` · `http-client` · `mail` ·
`migrations` · `queue-jobs` · `routing` · `scheduling` · `security` · `style` · `testing` ·
`validation`

Read the Quick Reference in `../laravel-best-practices/SKILL.md` first to see which files are
relevant to the target code, then read only those. Do not read all twenty every time.

Never invent a rule. If something looks wrong but no rule covers it, you may still raise it — but
label it explicitly as your own judgement rather than dressing it up as a project rule.

## 2. Consistency beats theory

Before reporting a deviation, check what the codebase already does. Laravel offers multiple valid
approaches; the best one is usually the one already in use. If sibling controllers, models, or tests
have an established pattern, a deviation from the rules that matches that pattern is not a finding —
inconsistency is worse than a suboptimal pattern.

## 3. Determine the target

The argument names what to look at: a file, a directory, a diff, a feature, or nothing (then review
the most recently changed files). If it is genuinely unclear, ask before reviewing.

## 4. Output format

One block per finding, most impactful first:

---

#### `<Rule name>`

**Area:** the part of the application involved (routing, Eloquent queries, validation, …), plus the
concrete file references (`path/to/File.php:42`) so the finding can be acted on.

**1. What is the problem?**
What is actually happening in the code.

**2. Why is it a problem?**
The concrete consequence — what breaks, gets slow, or becomes hard to maintain. Not "it is not best
practice", but the actual risk.

**3. How do the best practices support this?**
Name the rule file and heading, e.g. `rules/db-performance.md` → "Eager load with `with()`". Quote
the relevant line if it is short.

**4. Max three topics to study**
At most three — fewer is fine, none is fine when the fix is self-evident. Name the underlying
concept (e.g. "N+1 queries", "form requests", "database indexes"), not a link dump. This is the
point of the whole exercise: the reader should be able to spot the next occurrence themselves.

**5. What is the solution?**
Concrete, applied to this code. Show the corrected snippet when it clarifies more than prose does.

---

## 5. Scope and length

Report at most five findings per response, ordered by impact. If there are more, say how many you
left out and offer to continue. A wall of twenty findings does not get read, and does not teach
anything.

If the code is fine, say that plainly and name what it does well — do not manufacture findings to
fill the format.

## 6. Language

Answer in the language the user wrote in. The rule names and file paths stay in English.
