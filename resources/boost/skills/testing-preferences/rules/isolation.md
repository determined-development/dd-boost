# Isolation and dependencies

- Mock external services only when you need to inspect side effects, avoid real credentials, prevent external effects, force specific responses, or stabilize inconsistent dependencies.
- Otherwise, prefer exercising real application code without mocking.
- Do not add assertions that merely re-test third-party behavior.
