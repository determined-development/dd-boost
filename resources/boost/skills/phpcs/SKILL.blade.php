---
name: phpcs
description: "Use this skill for checking and correcting coding style violations. Trigger before finalizing changes to ensure your code matches the project's expected style. Trigger when the user requests that you fix the code style."
---
@php
    /** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp
# PHP Code Sniffer

The PHP Code Sniffer tool is a code quality tool that consists of two parts:
* `phpcs` - PHP Code Sniffer: the code sniffer.
* `phpcbf` -  PHP Code Beautifier and Fixer: the automated style fixing tool.

## PHP Code Sniffer

This tool will report all code style violations.

### Usage:
The basic command is: `phpcs [options] <file|directory>`

- Use `./` as the directory to scan all files in the project.
- Use the option `--basepath=./` to remove the full system path from reported violations.
- Use the option `-q` to reduce unnecessary output.
- Use the option `--report=full` to see all found violations.

Example:
```bash
$ {{ $assist->binCommand('phpcs') }} --basepath=./ -q ./

FILE: app/Models/User.php
---------------------------------------------------------------------------------
FOUND 3 ERRORS AND 1 WARNING AFFECTING 3 LINES
---------------------------------------------------------------------------------
196 | ERROR   | [x] Space after opening parenthesis of function call prohibited
198 | ERROR   | [x] Expected 0 spaces before closing parenthesis; 3 found
198 | WARNING | [ ] Line exceeds 120 characters; contains 128 characters
203 | ERROR   | [x] Blank line found at end of control structure
---------------------------------------------------------------------------------
PHPCBF CAN FIX THE 3 MARKED SNIFF VIOLATIONS AUTOMATICALLY
---------------------------------------------------------------------------------

FILE: app/Services/FooService.php
----------------------------------------------------------------------
FOUND 0 ERRORS AND 1 WARNING AFFECTING 1 LINE
----------------------------------------------------------------------
6 | WARNING | Line exceeds 120 characters; contains 129 characters
----------------------------------------------------------------------

FILE: tests/Unit/SomeServiceTest.php
------------------------------------------------------------------------------
FOUND 3 ERRORS AFFECTING 3 LINES
------------------------------------------------------------------------------
89 | ERROR | [x] Whitespace found at end of line
91 | ERROR | [x] Expected 0 spaces before closing parenthesis; 1 found
92 | ERROR | [x] Space after opening parenthesis of function call prohibited
------------------------------------------------------------------------------
PHPCBF CAN FIX THE 3 MARKED SNIFF VIOLATIONS AUTOMATICALLY
------------------------------------------------------------------------------
```

## PHP Code Beautifier and Fixer

This program will attempt to automatically fix code violations. It accepts most of the same options as `phpcs`.

### Pass Results

A `phpcbf` run is considered a pass if there were no violations.

If there were no violations, the output will look like:
```bash
$ {{ $assist->binCommand('phpcbf') }} --basepath=./ -q ./

No violations were found
```

### Fail Results

A `phpcbf` run is considered a fail if there were violations found, regardless of if they have been fixed or not.

If some violations were fixed but others could not be, the output will look like:
```bash
$ {{ $assist->binCommand('phpcbf') }} --basepath=./ -q ./

PHPCBF RESULT SUMMARY
-----------------------------------------------------------------------------------
FILE                                                               FIXED  REMAINING
-----------------------------------------------------------------------------------
/var/www/html/app/Models/User.php                                  3      1
/var/www/html/tests/Unit/SomeServiceTest.php                       3      0
-----------------------------------------------------------------------------------
A TOTAL OF 6 ERRORS WERE FIXED IN 2 FILES
-----------------------------------------------------------------------------------
```

If violations were found, but none of them could be fixed, the output will look like:
```bash
$ {{ $assist->binCommand('phpcbf') }} --basepath=./ -q ./

No fixable errors were found
```

**NB**: It is important to note that a file will only appear in this list if it contained violations that could be fixed. Files with _only_ unfixable violations will not appear in this list.
