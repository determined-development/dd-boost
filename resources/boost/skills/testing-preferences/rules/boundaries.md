# Boundaries and framework wiring

- Use realistic Laravel setup first: factories, `actingAs(...)`, support traits, and existing project helpers.
- Set authentication and authorization in the arrange step when they are required to reach the code under test.
- Unless the test is explicitly about authentication or authorization, keep those checks out of the assert step except for basic boundary assertions like `assertOk()`.
- Do not make tests primarily about middleware stacks or request validation wiring unless that is the behavior under test.
- Do not spend assertions proving that third-party packages or services work as documented.
- If framework bootstrapping is required for the test to be meaningful, write a feature test.
- Reserve unit tests for code that can be exercised without framework bootstrapping.
