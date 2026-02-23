# GitHub Workflows CI/CD Setup

This project includes automated CI/CD workflows using GitHub Actions.

## Workflows

### 1. CI (`ci.yml`)
Runs on `push` and `pull_request` to `main` and `develop` branches.

**Jobs:**
- **tests**: Runs the full test suite with Pest
  - Sets up PHP 8.5
  - Installs Composer and npm dependencies
  - Builds frontend assets
  - Runs database migrations
  - Executes all tests

- **code-quality**: Runs code quality checks
  - Pint formatting check
  - PHPStan static analysis
  - Rector dry-run for code modernization suggestions

### 2. Code Quality (`code-quality.yml`)
Dedicated workflow for detailed code quality checks.

**Jobs:**
- **formatting**: Validates Pint code formatting
- **static-analysis**: Runs PHPStan for type checking
- **rector**: Checks for code modernization opportunities

### 3. Security (`security.yml`)
Runs security vulnerability and dependency checks.

**Schedule:** Runs on push to `main`, on pull requests, and daily at 2 AM UTC.

**Jobs:**
- **security-check**: Composer audit for vulnerabilities
- **dependency-check**: Checks for outdated packages

## Local Testing

Before pushing, you can run the same checks locally:

```bash
# Run all tests
php artisan test --compact

# Check code formatting
vendor/bin/pint --check

# Run static analysis
vendor/bin/phpstan analyse

# Check with Rector
vendor/bin/rector process --dry-run

# Or use the test script
composer test
```

## Customization

### Branches
Modify the `on.push.branches` and `on.pull_request.branches` arrays to match your branch names.

### PHP Versions
To test against multiple PHP versions, expand the `matrix.php-version` array:

```yaml
php-version: [ '8.4', '8.5' ]
```

### Database
The CI workflow uses SQLite by default (via phpunit.xml). To use PostgreSQL or MySQL, adjust the services and environment variables accordingly.

## Status Badge

Add this to your README.md:

```markdown
[![CI](https://github.com/YOUR_ORG/prasnapatra-api/workflows/CI/badge.svg)](https://github.com/YOUR_ORG/prasnapatra-api/actions)
[![Code Quality](https://github.com/YOUR_ORG/prasnapatra-api/workflows/Code%20Quality/badge.svg)](https://github.com/YOUR_ORG/prasnapatra-api/actions)
[![Security](https://github.com/YOUR_ORG/prasnapatra-api/workflows/Security/badge.svg)](https://github.com/YOUR_ORG/prasnapatra-api/actions)
```
