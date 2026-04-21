---
name: chopping-code
description: "Activate when PHPCS reports line-length violations exceeding 120 characters that phpcbf could not automatically fix. Resolves those violations by restructuring code while preserving behavior and keeping formatting consistent."
---
# Chopping Down Code

Use this skill only when PHPCS reports a line-length violation and automatic fixers do not resolve it.

## Mandatory policy

- Keep runtime behavior identical; this skill is formatting-only.
- Bring violating lines to 120 characters or fewer.
- Prefer splits that make the most important logic easiest to scan.
- Match nearby formatting patterns in the same file when they are already consistent.

## Candidate Selection

When multiple split points are possible, apply these in order:

1. Break at natural semantic boundaries (method chaining, argument boundaries, array items).
2. Keep the part of the expression that communicates intent most visible.
3. Minimize diff noise; avoid restructuring unrelated code.
4. Avoid awkward one-off wrapping that makes peers look inconsistent.

```php
// Avoid: this emphasizes less important details.
$foo = str(Http::get(
    'https://example.com/search',
    ['term' => $term, 'orderBy' => $order_by],
)->response()->body())->slug()->after('foo')->beforeLast('bar');

// Better: this highlights the request lifecycle.
$foo = str(
    Http::get('https://example.com/search', ['term' => $term, 'orderBy' => $order_by])
        ->response()
        ->body()
)->slug()->after('foo')->beforeLast('bar');

// Best: this highlights how the final value is transformed.
$foo = str(Http::get('https://example.com/search', ['term' => $term, 'orderBy' => $order_by])->response()->body())
    ->slug()
    ->after('foo')
    ->beforeLast('bar');
```

## Maintain consistency

If all peer entries in the same structure are multi-line, split short peers to match.
If peers are mixed and no pattern is dominant, only split the violating line.

```php
return [
    'foo' => [
        \App\Some\Very\Long\NamespaceThatRequires\ChoppingDown\Foo::class,
        \App\Some\Very\Long\NamespaceThatRequires\ChoppingDown\Bar::class,
        \App\Some\Very\Long\NamespaceThatRequires\ChoppingDown\Baz::class,
    ],
    'bar' => [
        \App\Medium\LengthNamespace\Foo::class => \App\Medium\LengthNamespace\Fizz::class,
        \App\Medium\LengthNamespace\Bar::class => \App\Medium\LengthNamespace\Buzz::class,
        \App\Medium\LengthNamespace\Baz::class => \App\Medium\LengthNamespace\Bing::class,
    ],
    // Keep this multi-line because peer arrays are already multi-line.
    'baz' => [
        1,
        2,
        3,
    ],
];
```
