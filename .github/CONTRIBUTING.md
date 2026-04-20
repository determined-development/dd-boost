# Contributing

Thanks for contributing to this Laravel Boost skill repository.

## Before you start

- Read `README.md` for project scope and layout.
- Review Laravel Boost docs: https://laravel.com/docs/13.x/boost
- Keep each change focused on one skill or one cohesive documentation update.

## Setup

```bash
composer install
```

## Skill authoring conventions

- Skills live at `resources/boost/skills/<skill-name>/SKILL.blade.php`.
- Keep runbooks action-oriented, explicit, and easy for agents to execute.
- Match existing formatting and section style used by nearby skills.
- Avoid broad or ambiguous instructions that can lead to inconsistent edits.
- When adding a new skill, include:
  - front matter (`name`, `description`)
  - a clear purpose statement
  - mandatory policy and/or execution workflow

## Pull request expectations

- Explain what changed and why.
- Note any tradeoffs or assumptions.
- Keep diffs minimal.


