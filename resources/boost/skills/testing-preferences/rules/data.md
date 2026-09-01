# Setup, factories, and datasets

- Prefer model factories over direct database writes.
- Use direct model or database setup only when a factory cannot represent the state you need.
- If a setup is shared across tests, build it into factories or move it into a trait under `tests/Support`.
- Do not add helper functions inside Pest files unless the repository already uses that pattern for the same kind of setup.
- Keep one-off setup inline.
- Build only the records needed for the path under test.
- Use minimal competing records when a test depends on fallback, preference, or selection logic.
- Use datasets only for variations of the same behavior path.
- Split datasets if they would require conditionals inside the test.
- Keep allowed and denied outcomes in separate tests or separate datasets.
- Include a default case when the code under test has fallback behavior.
