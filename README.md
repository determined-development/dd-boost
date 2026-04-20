# Determined Development Laravel Boost Skills

[![Latest Version on Packagist](https://img.shields.io/packagist/v/determined-development/dd-boost.svg?style=flat-square)](https://packagist.org/packages/samlev/acl-for-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/determined-development/dd-boost.svg?style=flat-square)](https://packagist.org/packages/samlev/acl-for-laravel)

This repository contains custom Laravel Boost skills and guidance used by Determined Development projects.

## What this repository is

- A library of Boost skills that can be included in Laravel projects
- A place to maintain consistent agent behaviour for code style, static analysis, and testing
- Guidance for AI agents on how to use and operate tools consistent with how Determined Development typically uses tools
- Aimed at reducing token/context usage and unnecessary calls.

## What this repository is _not_

- An official Laravel package
- An official set of skills for any of the mentioned tools
- The only way to use these tools

## Laravel Boost references

- Laravel Boost package: https://github.com/laravel/boost
- Laravel Boost documentation: https://laravel.com/docs/13.x/boost

## Current Skills

- `larastan` - Guidance on how to use PHPStan and Larastan, including usage patterns.
- `phpcs` - Guidance on when and how to use `phpcs` and `phpcbf`.
- `phpcs-violations` - Guidance on how to find the appropriate documentation to resolve a PHPCS violation.
- `chopping-code` - Guidance on chopping down code to resolve line length issues.
- `testing` - Guidance on how to structure tests, and what things to test.

See contribution workflow details in `.github/CONTRIBUTING.md`.

