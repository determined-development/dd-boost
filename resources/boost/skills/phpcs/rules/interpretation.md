# Interpreting violations

Use this file when `phpcs --report=full -s` reports a violation and the fix is not obvious from the message alone.

## What to inspect

- The file path and line number.
- The violation message.
- The full sniff code.
- The nearby code around the reported line.
- The project’s PHPCS config and any local overrides.

## How to read the sniff

1. Read the PHPCS docs for the sniff first when they exist.
2. Use the sniff code to identify the category and sniff name.
3. If the docs are clear, follow them and stop looking deeper.
4. If the docs are not enough, inspect the sniff class for the exact branch that emitted the violation.
5. Check whether the project overrides the default behavior before editing.

## How to choose a fix

- Prefer the smallest change that satisfies the configured standard.
- Preserve behavior exactly.
- If the fix is ambiguous, choose the clearest readable option and note the tradeoff.
- If the violation is standard behavior, follow the standard rather than inventing a new opinion.

## When to use the resolution files

Use the resolution table below when the configured standard leaves room for a specific rewrite style.

| Resolution | When to use it |
| --- | --- |
| [`resolutions/line-length.md`](../resolutions/line-length.md) | When PHPCS reports a long-line violation and the fix needs code chopping that preserves readability, consistency, and the important expression shape. |
