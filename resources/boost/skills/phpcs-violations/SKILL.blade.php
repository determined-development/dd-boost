---
name: phpcs-violations
description: "Use this skill only when a PHPCS violation is unclear after running phpcs with --report=full -s. Prefer PHPCS docs first, inspect sniff code only if docs are missing or insufficient, and stop early when PHPCS or the required standard is not installed."
---
# PHPCS Violation Lookup

Load this skill only when the `phpcs` message and sniff code are not enough to determine a safe fix.

## Quick gate (run first)

1. Confirm PHPCS is available in the project.
2. Extract the standard from the sniff code.
3. If the standard is not one of the default PHPCS standards (`Generic`, `PEAR`, `PSR1`, `PSR2`, `PSR12`, `Squiz`, `Zend`), confirm that standard is installed before any deeper lookup.
4. If PHPCS or the required standard is not installed, suggest adding it as a dev dependency and stop.

If PHPCS is missing, suggest:

```bash
composer require --dev squizlabs/php_codesniffer
```

If a non-default standard is missing, suggest installing the package that provides that standard as a dev dependency, then stop.

## Required inputs

Capture these from `phpcs --report=full -s` before using this skill:

- the file path
- the line number
- the violation message
- the full sniff code

## Decode the sniff code

For a sniff like `Squiz.WhiteSpace.SuperfluousWhitespace.EndLine`:

- `Squiz` is the PHPCS standard
- `WhiteSpace` is the category
- `SuperfluousWhitespace` is the sniff name
- `EndLine` is the specific violation code emitted by that sniff

Use the first three segments to derive likely lookup paths:

- Docs: `vendor/squizlabs/php_codesniffer/src/Standards/Squiz/Docs/WhiteSpace/SuperfluousWhitespaceStandard.xml`
- Sniff: `vendor/squizlabs/php_codesniffer/src/Standards/Squiz/Sniffs/WhiteSpace/SuperfluousWhitespaceSniff.php`

If the sniff code has more than four segments, treat everything after the third segment as the violation code and search for that exact code inside the sniff class.

## Docs-first lookup workflow

1. Read the PHPCS XML docs first at `vendor/squizlabs/php_codesniffer/src/Standards/<Standard>/Docs/<Category>/<Sniff>Standard.xml`.
2. If docs exist and clearly explain the fix, stop lookup and apply the code change.
3. Only if docs are missing or still ambiguous, read `vendor/squizlabs/php_codesniffer/src/Standards/<Standard>/Sniffs/<Category>/<Sniff>Sniff.php`.
4. Use the violation suffix (for example, `EndLine`) to focus on the relevant branch in the sniff.
5. Check `phpcs.xml`, `phpcs.xml.dist`, or `ruleset.xml` for local overrides and configuration before editing.

Avoid noisy broad scans in terminal (for example, recursive `grep` or `find`) when file paths are predictable. Prefer opening the exact likely files directly and interpreting them.

## Interpreting what you find

- Prefer the XML docs for the high-level intent of the rule.
- Prefer the sniff class only when docs are missing or not specific enough for a safe fix.
- If `addFixableError()` or `addFixableWarning()` is used for the reported code, the violation is designed to be auto-fixable when PHPCS can safely rewrite the file.
- If only `addError()` or `addWarning()` is used for the reported code, expect to make a manual edit.

## Custom or external standards

If the derived file paths do not exist under `vendor/squizlabs/php_codesniffer/src/Standards`:

- treat this as a missing-standard case first and suggest installing the package that provides that standard as a dev dependency
- stop lookup until that dependency is available
- after installation, continue with the same docs-first workflow

## Exit criteria

Return to the main `phpcs` skill once you can explain:

- what the sniff is enforcing
- why the reported line violates it
- whether the project overrides the default behavior
- what code change will satisfy the rule without changing behavior
