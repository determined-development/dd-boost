# Behavior and coverage

- Test current intentional behavior, not historical behavior or implementation details.
- Prefer the smallest set of tests that clearly separates distinct behavior paths.
- Keep one test on one behavior path; use multiple assertions only when they all prove the same path.
- Do not add tests whose only value is proving that code was removed or that a behavior is absent.
- If a test would cover several semi-related behaviors at once, split it unless a dataset can describe the same path without conditionals.
- Use datasets to cover variants of the same behavior path, not to hide separate paths in one test.
- If the behavior change is already covered by existing tests, point to that coverage instead of writing another test.
- If it is unclear whether a new test is needed, ask what intentional behavior should be proven.
