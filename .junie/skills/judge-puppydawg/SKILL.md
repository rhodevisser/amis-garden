---
name: judge-puppydawg
description: "Judge code against the architecture rules defined in architecture.md and output a structured list of suggestions describing how the code deviates and how to fix it. Use when reviewing PHP/Laravel code for architectural compliance (Action classes, dependency injection, interfaces, default sort order, atomic locks, mb_* functions, defer(), Context, Concurrency::run(), convention over configuration)."
license: MIT
metadata:
  author: junie
---

# Judge Puppydawg

Evaluates code against the rules in `../laravel-best-practices/rules/architecture.md` and reports violations as a list of actionable suggestions.

## The Algorithm

1. Read `../laravel-best-practices/rules/architecture.md` to load the current rule set (each heading plus its Incorrect/Correct examples).
2. Identify the target code to review — the file(s), directory, or diff the user pointed at.
3. For each rule, check whether the target code follows the "Correct" pattern or matches the "Incorrect" pattern.
4. For each rule, record: the rule name, the general application area involved (no file names or line numbers), a finding describing what's actually happening there, and the risk if the rule is ignored.
5. Output one entry per rule, using the rule name as the heading.

## Output Format

For each rule:

#### Rule Name

Area: general area of the application involved (e.g., routing, controllers, queries).

Finding: what's actually happening in that area relative to the rule.

Risk if ignored: what could break or become harder to maintain if the rule is disregarded.

Put space between every rule for structure.
