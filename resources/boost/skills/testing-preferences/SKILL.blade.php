---
name: testing-preferences
description: "Activate when a feature is added, a bug is fixed, tests are requested, or an existing test needs review. Use this skill to shape Laravel tests around behavior, coverage value, and the project's preferred test style."
license: MIT
---

# Testing Preferences

Use this skill when you need to write, review, or trim Laravel tests. Keep tests focused on current intentional behavior, not implementation details, and use the rule files below for the specific opinionated guidance.

## How to use this skill

1. Read the nearby tests and follow the project's local conventions first.
2. Pick the rule files that match the behavior or test design problem you are working on.
3. Keep the smallest set of tests that clearly separates distinct behavior paths.
4. If a test would only prove the absence of code or duplicate existing coverage, point that out instead of adding a bad test.
5. If the right test is unclear, ask for the behavior that should be proven.

## Rule index

| Subject | Rule File |
| --- | --- |
| Behavior, coverage, and what counts as a useful test | [`rules/behavior.md`](rules/behavior.md) |
| Names, file layout, and test grouping | [`rules/structure.md`](rules/structure.md) |
| Setup, factories, datasets, and shared fixtures | [`rules/data.md`](rules/data.md) |
| Auth, access, request boundaries, and framework wiring | [`rules/boundaries.md`](rules/boundaries.md) |
| Mocking, isolation, and external dependencies | [`rules/isolation.md`](rules/isolation.md) |
| What not to test and when to ask instead | [`rules/review.md`](rules/review.md) |
