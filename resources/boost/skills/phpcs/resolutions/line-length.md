# Long-line code chopping

Use this resolution when PHPCS flags a long line and the fixer cannot make the code both valid and readable.

## What to optimize for

- Preserve behavior exactly.
- Make the important part of the code easy to scan first.
- Keep the result visually consistent with nearby code, even if the nearby code does not strictly need chopping.
- Prefer the smallest rewrite that improves clarity.

## How to chop code

1. Start by finding the part of the expression that carries the intent.
2. Break around natural semantic boundaries such as method chains, arguments, array items, or named parameters.
3. Keep supporting details grouped under the main operation instead of splitting them away first.
4. Use local variables, named arguments, or intermediate arrays only when they make the intent clearer.
5. If a peer structure in the same file is already split a certain way, match that style unless it makes the code harder to read.
6. If you split a method chain at one level, split the whole chain at that level so the wrapping looks deliberate rather than partial.

## When to split more than the minimum

- Split short peers to match nearby multi-line structures when the file already uses that pattern.
- Keep arrays, chains, and related expressions in the same visual shape when the surrounding code is consistent.
- Prefer consistency over a technically valid but awkward one-off wrap.
- If one hop in a chain is wrapped, prefer wrapping the rest of that chain consistently rather than leaving a mixed inline/multiline shape.

## What to avoid

- Do not chop code just to create more lines.
- Do not hide the main expression behind extra temporary variables unless that makes the code easier to understand.
- Do not rearrange unrelated code when a local wrap is enough.
