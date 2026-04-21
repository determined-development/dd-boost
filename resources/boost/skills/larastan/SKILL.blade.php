---
name: larastan
description: "Activate before finalizing whenever one or more PHP files have been created or modified. Runs PHPStan/Larastan static analysis, identifies findings introduced by the current changes, and resolves them without suppressions or baseline entries."
---
@php
    /** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp
# PHPStan/Larastan Agent Runbook

Use this skill when PHP files change and static analysis must be validated with PHPStan/Larastan.

## Mandatory policy

- If any PHP files are modified, run `{{ $assist->binCommand('phpstan') }} analyze --error-format json`.
- Never add exclusions to `phpstan.neon` and never use a baseline to ignore errors.
- Do not fix existing PHPStan errors that were not introduced by your changes.
- Do not use manual bypasses such as `@phpstan-ignore`.
- Use `/** @var Type $variable */` only when the type is absolutely known and cannot be inferred correctly by existing mechanisms.

## Canonical command

```bash
{{ $assist->binCommand('phpstan') }} analyze --error-format json
```

## Execution procedure

1. Confirm whether any PHP files were changed.
2. If no PHP files changed, skip this skill.
3. Run PHPStan once with `--error-format json`.
4. Build a worklist from the JSON output using `file`, `line`, `message`, and `identifier` when present.
5. Classify each finding:
   - introduced by current changes
   - pre-existing and unrelated
6. Fix only findings introduced by current changes.
7. Re-run the same command to verify a clean result for change-related issues.
8. If there were pre-existing violations, report these to the user, but do not attempt to resolve them.

## Interpreting reported errors

- Treat the reported file and line as the entry point, then inspect nearby symbols and inferred types before editing.
- Use `identifier` to understand the exact rule category and to find official guidance.
- Prefer real type improvements (native type hints, precise return types, accurate generics) over workaround annotations.
- If a violation depends on framework behavior, check Larastan guidance first, then apply the least invasive code change.
- If uncertain whether an error is new, report the violation to the user and seek guidance if it needs to be resolved. Justify why you feel it is or is not related to your changes.

## Interpreting configuration safely

Check project configuration in this order, if present:

1. `phpstan.neon`
2. `phpstan.neon.dist`
3. included NEON files referenced by `includes`

When reading config, focus on:

- active analysis level and paths
- Larastan extension includes
- `bootstrapFiles`, `scanFiles`, and `stubFiles`
- project type aliases and custom dynamic return type extensions

Do not weaken analysis to pass checks:

- do not add `ignoreErrors`
- do not add excludes for reported paths
- do not add or regenerate a baseline

## Project-specific PHPStan extensions

Create a custom PHPStan extension only when the same annotations or ignores are repeatedly used and an extension would be significantly clearer.

- First prefer regular fixes: stronger native types, better PHPDoc, Larastan-supported patterns, or targeted stubs.
- If repeated local workarounds still appear, extract that logic into a reusable extension instead of adding more inline annotations.
- Keep extension classes out of the `App` namespace; use a dedicated analysis namespace (for example `Dev\\PHPStan\\`).
- Register extension classes in `composer.json` under `autoload-dev` so they remain development-only.

```json
{
  "autoload-dev": {
    "psr-4": {
      "Dev\\PHPStan\\": "phpstan/extensions/"
    }
  }
}
```

- After updating `autoload-dev`, run `composer dump-autoload`.
- Wire the extension through the existing PHPStan configuration (for example `services` in NEON) without broad suppressions.

## Stub files for third-party libraries

Use stubs only when third-party library metadata is insufficient and a real code fix is not possible in project code.

1. Confirm the issue is due to missing or incorrect vendor type information.
2. Create or update a project stub file (for example under `phpstan/stubs/`) that declares only the required signatures.
3. Keep stubs minimal and accurate: correct namespaces, class names, method signatures, generics, nullability, and return types.
4. Register the stub through existing `stubFiles` configuration if needed.
5. Re-run PHPStan and ensure the stub resolves only the intended typing gap.

## References

- Larastan: `https://github.com/larastan/larastan`
- PHPStan documentation: `https://phpstan.org/documentation`
