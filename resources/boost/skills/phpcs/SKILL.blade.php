---
name: phpcs
description: "Activate before finalizing whenever one or more PHP files have been created or modified. Runs phpcbf to auto-fix coding standard violations, then runs phpcs to check for remaining issues, and invokes the phpcs-violations skill only when a remaining violation requires deeper interpretation."
---
@php
    /** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp
# PHPCS Agent Runbook

Use this skill for autonomous style enforcement on PHP changes.

## Mandatory policy

- If any PHP files were modified, run `{{ $assist->binCommand('phpcbf') }} --basepath=./ -q ./` first.
- Do not run `phpcs` unless that `phpcbf` run returns a non-pass state.
- After the first non-pass `phpcbf` run, run `phpcs` once to collect actionable violations, then fix code before re-running either command.

## Canonical commands

```bash
{{ $assist->binCommand('phpcbf') }} --basepath=./ -q ./
{{ $assist->binCommand('phpcs') }} --basepath=./ --report=full -s -q ./
```

## Execution procedure

1. Run `phpcbf` first.
2. If output is `No violations were found`, stop; style is clean.
3. Otherwise, run `phpcs` once with `--report=full -s`.
4. Build a violation worklist from `file`, `line`, `message`, and `sniff code`.
5. Fix all reported issues in code.
6. Do not re-run `phpcbf` or `phpcs` during active fixing; re-run after all known violations are addressed.
7. Re-run `phpcbf` to verify final pass.

## Understanding non-fixable violations

When `phpcbf` cannot fully resolve issues (`No fixable errors were found` or remaining violations):

- Treat `phpcs --report=full -s` output as the source of truth for `file`, `line`, `message`, and `sniff code`.
- If the fix is obvious from the message and surrounding code, apply it directly.
- If the violation meaning, intent, or safe fix is unclear, invoke the `phpcs-violations` skill before editing.
- Use `phpcs-violations` to inspect the local PHPCS standard docs, sniff class, and ruleset overrides for that specific sniff.

## Report strategy for agents

- Prefer `--report=full -s` when `phpcs` is needed because it provides file, line, message, and sniff code for deterministic fixes.
- Avoid `--report=summary` for fixing loops; it is shorter but omits violation-level detail and increases follow-up cycles.
- Avoid reports like `--report=json` which often include all scanned files and increase tokens for agent workflows.

## Result handling

Treat `phpcbf` outcomes as:
- **Pass**: `No violations were found`.
- **Non-pass**: violations exist, regardless of whether some were auto-fixed.
- **Non-fixable**: `No fixable errors were found`; if the fix is not already clear, invoke `phpcs-violations`, understand the sniff, then make edits.

## Formatter interaction

If the project uses Pint, run it after PHPCS violations are resolved:

```bash
{{ $assist->binCommand('pint') }} --dirty --format agent
```

Then run final PHPCS verification again:

```bash
{{ $assist->binCommand('phpcbf') }} --basepath=./ -q ./
```

If Pint and PHPCS conflict, prioritize the rules that CI enforces. If both cannot pass together, stop and report the conflicting files/sniffs instead of looping.
