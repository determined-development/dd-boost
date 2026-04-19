---
name: chopping-code
description: "Use this skill for chopping down long lines of code that are not able to be automatically chopped down by automated tools. Trigger when PHPCS reports a line length violation."
---
# Chopping down code

When lines are over 120 characters long, they should be chopped down. The goal when chopping down long lines is to maintain readability and consistency.

## Candidate Selection
When chopping down a long line with multiple candidates, emphasise readability of the most important part of the code.

```php
// Less understandable - focus is on the parts that are least likely to break. 
$foo = str(Http::get(
    'https://example.com/search',
    ['term' => $term, 'orderBy' => $order_by],
)->response()->body())->slug()->after('foo')->beforeLast('bar');

// Better - focus is on the HTTP Request lifecycle
$foo = str(
    Http::get('https://example.com/search', ['term' => $term, 'orderBy' => $order_by])
        ->response()
        ->body()
)->slug()->after('foo')->beforeLast('bar');

// Best - the focus is now on what is happening with the result
$foo = str(Http::get('https://example.com/search', ['term' => $term, 'orderBy' => $order_by])->response()->body())
    ->slug()
    ->after('foo')
    ->beforeLast('bar');
```

## Maintain consistency
If _all other_ peers are chopped down, then chop down short entities to maintain consistency.
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
    // Before: 'baz' => [1, 2, 3],
    'baz' => [
        1,
        2,
        3,
    ],
];
```
