# Review and non-goals

- Do not write tests for seeders or migrations unless they are likely to run in production, likely to change, and non-trivial.
- It is acceptable to point to existing tests that already cover the behavior.
- It is acceptable to explain why a new test is unnecessary instead of writing a bad test.
- If the intended behavior is unclear, ask for clarification before writing a test.
