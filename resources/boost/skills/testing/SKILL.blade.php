---
name: testing
description: "Agent runbook for adding or updating Laravel tests with consistent structure, realistic setup, and clear scope."
---
# Test Authoring Runbook

Use this skill when creating or revising Laravel tests so they match the project's intended structure and level of isolation.

## Mandatory policy

- Prefer the smallest useful test that proves the behavior introduced by the change.
- Keep each test focused on one path or one coherent set of preconditions.
- Prefer realistic Laravel setup through factories, seeding, `actingAs(...)`, and support traits before reaching for custom shortcuts.
- Do not add helper functions directly inside test files.
- Do not make tests primarily about middleware stacks or request validation wiring when the goal is to validate business behavior.
- Set each test up with valid access preconditions so it reaches the code under test, and add explicit authorization checks when authorization is part of the behavior.
- Do not spend assertions proving that third-party packages or services work as documented.

## Test setup and support code

When test setup needs to be reused:

- Move that logic into traits or support classes under `tests/Support`.
- Keep those helpers in the test support namespace used by the project (for example `Tests\Support\...`).
- Prefer helpers that compose naturally in Pest with `uses(...)` or in PHPUnit with `use TraitName;`.
- If setup is only needed once and stays short, keep it inline in the test instead of extracting prematurely.

Avoid adding ad hoc helper functions inside a test file because they are harder to reuse and tend to drift between files.

## Data creation and fixtures

- Prefer model factories over direct database writes so required state and relationships stay realistic.
- Only bypass factories when the project already has a more appropriate shared test builder or fixture pattern.
- Build only the records needed for the path under test.
- Set failure preconditions directly (factories, seed data, support helpers, or targeted DB state) instead of calling the same endpoint or action once just to prepare a second assertion.
- For dates or other mutable environmental values, avoid hard-coded values; prefer helpers like `now()`, `Carbon::make('-1 month')`, `fake()->dateTimeBetween()`, or `$this->freezeSecond()` so behavior remains stable over time.
- Keep setup obvious from the test body; if setup becomes noisy, extract it to `tests/Support` rather than hiding it in local helpers.

## Mocking and external services

Mock external services only when at least one of these is true:

- the test must inspect side effects on the dependency
- the dependency requires real credentials
- the dependency can trigger effects outside the application under test
- the test must force a specific success, failure, or edge-case response
- the dependency may behave inconsistently between runs (for example, shared static state that can leak across tests)

Otherwise, prefer exercising real application code without mocking. Do not add assertions that merely re-test third-party behavior.

## Datasets

Use datasets when the same behavior should be verified across multiple meaningful inputs, such as enum cases, roles, or policy outcomes.

- Keep a dataset in the test file when it is only useful there.
- Move reusable datasets to `tests/Datasets` when multiple files benefit from the same cases.
- Include all inputs and expected outcomes in the dataset so the test body stays linear.
- If a dataset would force conditionals inside the test, split it into separate tests or separate datasets.
- If several inputs should all produce the same result, group only those cases together and keep differing outcomes in another test.

## Responsibility and path coverage

Within a file, cover behavior in the order a reader would expect:

1. the happy path
2. the most likely early failure path
3. the next likely invalid or denied path that is not already covered by framework validation
4. later failure paths such as precondition failures or dependency errors

Each feature test should prove one path clearly. Add additional tests for other important preconditions instead of branching heavily inside one test.

## Grouping and file layout

Group tests to mirror the application structure unless a stronger domain boundary is clearer.

Examples:

- `tests/Feature/Controllers/...`
- `tests/Feature/Services/...`
- `tests/Feature/{Domain}/Jobs/...`
- Keep unrelated classes in separate files unless one file is intentionally verifying a single shared concept across those classes.

Within a file:

- keep related tests together
- order them to follow the code path under test
- match nearby test structure when a file or directory already has an established pattern

## Test names

- Keep test names short and specific to the core behavior being proven.
- Let the file name, class name, and surrounding context carry the extra detail.
- Prefer concise names that describe the observable outcome instead of the full implementation story.

## Choosing feature vs unit tests

- If the framework container, facades, database layer, HTTP kernel, or other framework services are required to make the test meaningful, write a feature test.
- Reserve unit tests for code that can be exercised without framework bootstrapping.
- When internal or protected behavior must be observed in a unit test, prefer partial mocks or small test-specific subclasses over reshaping production code only for test access.
