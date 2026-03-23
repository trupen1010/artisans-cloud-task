<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4
- laravel/framework (LARAVEL) - v13
- laravel/prompts (PROMPTS) - v0
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/pail (PAIL) - v1
- laravel/pint (PINT) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12

## Skills Activation

This project has domain-specific skills available. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

- `pest-testing` — Use this skill for Pest PHP testing in Laravel projects only. Trigger whenever any test is being written, edited, fixed, or refactored — including fixing tests that broke after a code change, adding assertions, converting PHPUnit to Pest, adding datasets, and TDD workflows. Always activate when the user asks how to write something in Pest, mentions test files or directories (tests/Feature, tests/Unit, tests/Browser), or needs browser testing, smoke testing multiple pages for JS errors, or architecture tests. Covers: it()/expect() syntax, datasets, mocking, browser testing (visit/click/fill), smoke testing, arch(), Livewire component tests, RefreshDatabase, and all Pest 4 features. Do not use for factories, seeders, migrations, controllers, models, or non-test PHP code.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

- Laravel Boost is an MCP server that comes with powerful tools designed specifically for this application. Use them.

## Artisan Commands

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`, `php artisan tinker --execute "..."`).
- Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.

## URLs

- Whenever you share a project URL with the user, you should use the `get-absolute-url` tool to ensure you're using the correct scheme, domain/IP, and port.

## Debugging

- Use the `database-query` tool when you only need to read from the database.
- Use the `database-schema` tool to inspect table structure before writing migrations or models.
- To execute PHP code for debugging, run `php artisan tinker --execute "your code here"` directly.
- To read configuration values, read the config files directly or run `php artisan config:show [key]`.
- To inspect routes, run `php artisan route:list` directly.
- To check environment variables, read the `.env` file directly.

## Reading Browser Logs With the `browser-logs` Tool

- You can read browser logs, errors, and exceptions using the `browser-logs` tool from Boost.
- Only recent browser logs will be useful - ignore old logs.

## Searching Documentation (Critically Important)

- Boost comes with a powerful `search-docs` tool you should use before trying other approaches when working with Laravel or Laravel ecosystem packages. This tool automatically passes a list of installed packages and their versions to the remote Boost API, so it returns only version-specific documentation for the user's circumstance. You should pass an array of packages to filter on if you know you need docs for particular packages.
- Search the documentation before making code changes to ensure we are taking the correct approach.
- Use multiple, broad, simple, topic-based queries at once. For example: `['rate limiting', 'routing rate limiting', 'routing']`. The most relevant results will be returned first.
- Do not add package names to queries; package information is already shared. For example, use `test resource table`, not `filament 4 test resource table`.

### Available Search Syntax

1. Simple Word Searches with auto-stemming - query=authentication - finds 'authenticate' and 'auth'.
2. Multiple Words (AND Logic) - query=rate limit - finds knowledge containing both "rate" AND "limit".
3. Quoted Phrases (Exact Position) - query="infinite scroll" - words must be adjacent and in that order.
4. Mixed Queries - query=middleware "rate limit" - "middleware" AND exact phrase "rate limit".
5. Multiple Queries - queries=["authentication", "middleware"] - ANY of these terms.

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.

## Constructors

- Use PHP 8 constructor property promotion in `__construct()`.
    - `public function __construct(public GitHub $github) { }`
- Do not allow empty `__construct()` methods with zero parameters unless the constructor is private.

## Type Declarations

- Always use explicit return type declarations for methods and functions.
- Use appropriate PHP type hints for method parameters.

<!-- Explicit Return Types and Method Params -->
```php
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
```

## Enums

- Typically, keys in an Enum should be TitleCase. For example: `FavoritePerson`, `BestLake`, `Monthly`.

## Comments

- Prefer PHPDoc blocks over inline comments. Never use comments within the code itself unless the logic is exceptionally complex.

## PHPDoc Blocks

- Add useful array shape type definitions when appropriate.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

## Database

- Always use proper Eloquent relationship methods with return type hints. Prefer relationship methods over raw queries or manual joins.
- Use Eloquent models and relationships before suggesting raw database queries.
- Avoid `DB::`; prefer `Model::query()`. Generate code that leverages Laravel's ORM capabilities rather than bypassing them.
- Generate code that prevents N+1 query problems by using eager loading.
- Use Laravel's query builder for very complex database operations.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

### APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## Controllers & Validation

- Always create Form Request classes for validation rather than inline validation in controllers. Include both validation rules and custom error messages.
- Check sibling Form Requests to see if the application uses array or string based validation rules.

## Authentication & Authorization

- Use Laravel's built-in authentication and authorization features (gates, policies, Sanctum, etc.).

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Queues

- Use queued jobs for time-consuming operations with the `ShouldQueue` interface.

## Configuration

- Use environment variables only in configuration files - never use the `env()` function directly outside of config files. Always use `config('app.name')`, not `env('APP_NAME')`.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

=== psr rules ===

# PHP PSR Rules — Sr. Software Engineer Standards

## PSR-1 — Basic Coding Standard

1. Files MUST use only `<?php` or `<?=` tags
2. Files MUST use only UTF-8 without BOM for PHP code
3. A file SHOULD either declare symbols OR cause side-effects, but MUST NOT do both
4. Namespaces and classes MUST follow PSR-4 autoloading standard
5. Class names MUST be declared in `StudlyCaps` / `PascalCase`
6. Class constants MUST be declared in `ALL_UPPER_CASE` with underscore separators
7. Method names MUST be declared in `camelCase`

## PSR-4 — Autoloading Standard

8. Each class MUST be in a file by itself
9. Each class MUST be in a namespace of at least one level (top-level vendor name)
10. The namespace and class structure MUST map directly to the file path

## PSR-12 — Extended Coding Style Guide

### Files

11. All PHP files MUST use Unix LF (linefeed) line ending only
12. All PHP files MUST end with a non-blank line, terminated with a single LF
13. The closing `?>` tag MUST be omitted from files containing only PHP
14. There MUST NOT be a hard limit on line length
15. The soft limit on line length MUST be 120 characters
16. Lines SHOULD NOT be longer than 80 characters
17. There MUST NOT be trailing whitespace at the end of lines
18. There MUST NOT be more than one statement per line
19. Code MUST use 4 spaces for indentation — MUST NOT use tabs

### Keywords & Types

20. All PHP reserved keywords and types MUST be in lower case
21. Short form type keywords MUST be used: `bool`, `int`, `str` (not `boolean`, `integer`)

### File Header Order

Each block separated by one blank line:

22. Opening `<?php` tag
23. File-level DocBlock
24. `declare` statements
25. Namespace declaration
26. Class/function/constant `use` import statements
27. Import statements MUST never begin with a leading backslash
28. Compound namespaces with a depth of more than two MUST NOT be used

### Classes

29. `extends` and `implements` keywords MUST be declared on the same line as the class name
30. The opening brace for the class MUST go on its own line
31. The closing brace for the class MUST go on the next line after the body
32. Opening braces MUST NOT be preceded or followed by a blank line
33. Closing braces MUST NOT be preceded by a blank line
34. When instantiating a new class, parentheses MUST always be present even with no arguments: `new Foo()`
35. `implements` list MAY be split across multiple lines with one interface per line

### Traits

36. `use` keyword for traits MUST be declared on the next line after the class opening brace
37. Each individual trait imported into a class MUST be one-per-line with its own `use` statement

### Properties

38. Visibility (`public`, `protected`, `private`) MUST be declared on all properties
39. The `var` keyword MUST NOT be used to declare a property
40. There MUST NOT be more than one property declared per statement
41. Property names MUST NOT be prefixed with a single underscore to indicate visibility
42. There MUST be a space between type declaration and property name

### Methods & Functions

43. Visibility MUST be declared on all methods
44. Method names MUST NOT be prefixed with a single underscore
45. Method/function names MUST NOT have a space after the name before the opening parenthesis
46. Opening brace of a method MUST go on its own line
47. Closing brace of a method MUST go on the next line following the body
48. There MUST NOT be a space after the opening parenthesis or before the closing parenthesis
49. In argument lists, there MUST NOT be a space before each comma, and MUST be one space after each comma
50. Arguments with default values MUST go at the end of the argument list
51. Return type declaration MUST have one space after the colon, on the same line as the closing parenthesis
52. In nullable type declarations, there MUST NOT be a space between `?` and the type
53. No space after the reference operator `&` before an argument
54. No space between the variadic `...` operator and the argument name

### abstract / final / static

55. `abstract` and `final` MUST precede the visibility declaration
56. `static` MUST come after the visibility declaration

### Method & Function Calls

57. No space between the method/function name and the opening parenthesis
58. No space after the opening parenthesis and no space before the closing parenthesis

### Control Structures

59. There MUST be one space after the control structure keyword
60. There MUST NOT be a space after the opening parenthesis or before the closing parenthesis
61. The opening brace MUST be on the same line as the closing parenthesis
62. The body MUST be on the next line after the opening brace
63. The closing brace MUST be on the next line after the body
64. The body of each control structure MUST be enclosed by braces
65. `elseif` SHOULD be used instead of `else if`
66. `else` and `elseif` MUST be on the same line as the closing brace of the earlier body
67. In `switch`, the `case` statement MUST be indented once from `switch`
68. The `break` keyword MUST be indented at the same level as the `case` body
69. Intentional fall-through in `case` MUST have a `// no break` comment
70. Boolean operators between multi-line conditions MUST always be at the beginning OR end of the line — not mixed

### Operators

71. The increment/decrement operators (`++`/`--`) MUST NOT have any space between the operator and operand
72. Type casting operators MUST NOT have any space within the parentheses: `(int) $val`
73. All binary arithmetic, comparison, assignment, bitwise, logical, string, and type operators MUST be surrounded by at least one space
74. Ternary operator `?` and `:` MUST be preceded and followed by at least one space

### Closures

75. Closures MUST be declared with a space after the `function` keyword
76. A space MUST be placed before and after the `use` keyword in closures
77. The opening brace of a closure MUST go on the same line; the closing brace on the next line after the body
78. Closure arguments with default values MUST go at the end of the argument list

### Anonymous Classes

79. Anonymous classes MUST follow the same guidelines and principles as closures
80. The opening brace MAY be on the same line as the `class` keyword if the `implements` list does not wrap; if it wraps, the brace MUST be on the line immediately following the last interface

=== engineering principles ===

# Additional Engineering Principles

## DRY — Don't Repeat Yourself

1. Every piece of knowledge/logic MUST have a single, unambiguous representation in the codebase
2. Reuse Eloquent scopes, Blade partials, and service classes instead of duplicating logic
3. Extract repeated code into helper methods, traits, or base classes
4. Do NOT DRY unrelated things — similarity alone is not a reason to merge code

## SOLID Principles

5. **S — Single Responsibility:** Every class/method MUST have only one reason to change
6. **O — Open/Closed:** Classes MUST be open for extension but closed for modification
7. **L — Liskov Substitution:** Subclasses MUST be replaceable for their parent classes without breaking functionality
8. **I — Interface Segregation:** Clients MUST NOT be forced to depend on interfaces they do not use
9. **D — Dependency Inversion:** High-level modules MUST NOT depend on low-level modules; both MUST depend on abstractions

## KISS — Keep It Simple, Stupid

10. Code MUST be written in the simplest possible way — avoid over-engineering
11. One method SHOULD handle one use case — do NOT build a single method with multiple boolean params for every case
12. Code MUST be easy to read, debug, and maintain by any other developer

## YAGNI — You Aren't Gonna Need It

13. Do NOT add functionality until it is actually needed
14. Do NOT write code speculatively for future requirements
15. Focus only on immediate user needs — add features iteratively as they become genuinely necessary

## Law of Demeter (LoD)

16. A module MUST NOT know the inner details of objects it manipulates
17. A method SHOULD only call methods of: itself, its own fields, objects it creates, or its parameters — avoid chaining like `$a->getB()->getC()->doSomething()`

## Laravel-Specific Sr. Dev Rules

18. Use **Fat Models, Skinny Controllers** — business logic belongs in models/services, not controllers
19. Business logic MUST be centralized in **Service Classes**
20. Validation MUST be done using **Form Request classes**, not inline in controllers
21. Use `$request->validated()` instead of `$request->all()` after validation
22. MUST use **Dependency Injection** to manage class dependencies instead of hardcoding them
23. **Never execute queries inside Blade templates** — use eager loading to avoid N+1 problems
24. Prefer **Eloquent over raw Query Builder or raw SQL** where possible
25. Prefer **Collections over plain arrays** for data manipulation
26. Use **mass assignment** protection (`$fillable` / `$guarded`) on all models

## General Clean Code Rules

27. Follow **Meaningful Naming Conventions** — variables, methods, and classes MUST clearly describe their purpose
28. Methods MUST do just one thing
29. Avoid magic numbers/strings — use **named constants or config values**
30. Code MUST be self-documenting; comments should explain *why*, not *what*

</laravel-boost-guidelines>
