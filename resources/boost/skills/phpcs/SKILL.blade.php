---
name: phpcs
description: "Activate before finalizing any PHP code changes or when the user asks to fix code style. Use PHPCS or PHPCBF to detect, classify, and fix style violations."
---

# PHPCS

Use this skill when the project is configured for PHPCS and you need to run the fixer, inspect a reported violation, or resolve a standard-specific issue.

## How to use this skill

1. Check the repo first. PHPCS is only relevant when the project already defines it.
2. Look for `phpcs.xml`, `phpcs.xml.dist`, and composer scripts that invoke PHPCS or PHPCBF.
3. Use the configured standard as the source of truth for what rules exist.
4. Run `phpcbf` first.
5. If `phpcbf` returns anything other than `No violations were found`, run `{{ $assist->binCommand('phpcs') }} --report=full -s`.
6. Use the rule files below when you need more depth on interpretation or a specific resolution.

## Basic commands

```bash
{{ $assist->binCommand('phpcbf') }}  --basepath=./ -q ./
{{ $assist->binCommand('phpcs') }} --basepath=./ --report=full -s ./
```

## Rule index

The files below add extra explanation for interpreting and resolving issues when the basic workflow is not enough.

| Subject | Rule File |
| --- | --- |
| Running PHPCS and PHPCBF | [`rules/workflow.md`](rules/workflow.md) |
| Interpreting violations and choosing a fix | [`rules/interpretation.md`](rules/interpretation.md) |

## Common mistakes

1. Chaining `phpcbf` and `phpcs` into one command instead of treating them as separate steps.
2. Treating `phpcbf` as a final pass when it still returned output other than `No violations were found`.
3. Running `phpcs` and stopping at the report instead of fixing the introduced violations.
