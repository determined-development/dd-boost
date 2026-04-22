---
name: testing
description: "Activate when a feature is added, a bug is fixed, or tests are requested. Add or update Laravel tests with realistic setup, focused behaviour coverage, and minimal unnecessary complexity."
---
# Test Authoring Runbook

Use this skill when creating or revising Laravel tests so they stay focused, realistic, and consistent with project patterns.

## Mandatory policy

- Prefer the smallest useful test that proves the behavior introduced by the change.
- Keep each test focused on one path or one coherent set of preconditions.
- Prefer realistic Laravel setup through factories, seeding, `actingAs(...)`, and support traits before reaching for custom shortcuts.
- Do not add helper functions directly inside test files.
- Do not make tests primarily about middleware stacks or request validation wiring when the goal is to validate business behavior.
- Set each test up with valid access preconditions so it reaches the code under test, and add explicit authorization checks when authorization is part of the behavior.
- Do not spend assertions proving that third-party packages or services work as documented.

## Setup and fixtures

- Move repeated, complex setup logic into traits or support classes under `tests/Support` (for example `Tests\Support\...`).
- Prefer helpers that compose naturally in Pest with `uses(...)` or in PHPUnit with `use TraitName;`.
- Keep one-off setup inline, even when it is a bit verbose.
- Prefer model factories over direct database writes; only bypass factories when an established shared builder or fixture pattern is more appropriate.
- Build only the records needed for the path under test.
- For fallback, preference, or selection logic, include minimal competing records so tests prove the correct choice was made rather than passing because no alternatives existed.
- Set preconditions directly (factories, seed data, support helpers, or targeted DB state) instead of calling the same endpoint first just to prepare later assertions.
- For dates or other mutable environmental values, avoid hard-coded values; prefer helpers like `now()`, `Carbon::make('-1 month')`, `fake()->dateTimeBetween()`, or `$this->freezeSecond()` so relative timing logic stays stable, including against current date/time.
- Extract setup to `tests/Support` when multiple tests need the same complex relationship graph or shared complex input payload.

## Mocking and external services

- Mock external services only when needed to inspect dependency side effects, avoid real credentials, prevent external effects, force specific responses, or stabilize inconsistent dependencies.
- Otherwise, prefer exercising real application code without mocking.
- Do not add assertions that merely re-test third-party behavior.

## Datasets

Use datasets when the same behaviour should be verified across multiple meaningful inputs (for example enum cases, roles, or policy outcomes).

- Use keyed dataset cases (`'school level' => [...]`) for readable failures.
- Keep a dataset with the test when it is only useful for one test.
- Refactor to a named, reusable dataset if the same data is used for multiple tests.
- Move reusable datasets to `tests/Datasets` when multiple files benefit from the same cases.
- Include all inputs and expected outcomes in the dataset so the test body stays linear.
- If a dataset would force conditionals inside the test, split it into separate tests or separate datasets.
- If several inputs should produce the same result, group only those cases together and keep differing outcomes in separate tests.
- Prefer one parameterized test with a named `dataset()` over duplicate tests when validating one behaviour across variants.
- Use one behaviour-focused test name and type test parameters when practical.
- If the code under test has fallback behaviour, include an explicit default case in the dataset.
- Keep each dataset scoped to one assertion shape; failure or denial paths belong in separate tests, even when setup is similar.

## Responsibility and path coverage

Within a file, cover behavior in the order a reader would expect:

1. the happy path
2. the most likely early failure path
3. the next likely invalid or denied path that is not already covered by framework validation
4. later failure paths such as precondition failures or dependency errors

Each feature test should prove one path clearly. Add additional tests for other important preconditions instead of branching heavily inside one test.

## Organization and naming

- Group tests to mirror the application structure unless a stronger domain boundary is clearer.
- Common layouts include `tests/Feature/Controllers/...`, `tests/Feature/Services/...`, and `tests/Feature/{Domain}/Jobs/...`.
- Keep unrelated classes in separate files unless one file intentionally verifies one shared concept across them.
- Within a file, keep related tests together, order them by code path, and match established nearby structure.
- Keep test names short and specific to the core behaviour being proven.
- Let file/class context carry extra detail; prefer names that describe observable outcomes over implementation narratives.

## Choosing feature vs unit tests

- If the framework container, facades, database layer, HTTP kernel, or other framework services are required to make the test meaningful, write a feature test.
- Reserve unit tests for code that can be exercised without framework bootstrapping.
- When internal or protected behavior must be observed in a unit test, prefer partial mocks or small test-specific subclasses over reshaping production code only for test access.
