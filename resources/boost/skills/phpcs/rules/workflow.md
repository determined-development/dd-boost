# Running PHPCS and PHPCBF

1. Check `phpcs.xml`, `phpcs.xml.dist`, and composer scripts before doing anything else.
2. Treat the configured standard as the source of truth.
3. Run `phpcbf` first.
4. If `phpcbf` returns anything other than `No violations were found`, run `phpcs --report=full -s`.
5. Use the configured standard, not project-specific opinion, to decide what the reported violation means.
6. After fixing any violations, run `phpcs --report=full -s` again.
7. If the same violation keeps returning after a reasonable fix attempt, stop and ask the user for guidance instead of spinning.
