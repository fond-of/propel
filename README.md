This package is mainly used to extend and fix the Propel 2 package in environments where it is not possible to update to a newer version.

## Usage
### Override PostgreSQL Platform
Set the platformClass in the generator to `\FondOf\Propel\Generator\Platform\PgsqlPlatform`

## Fixes
Elements which are fixed by this package

- Drop of unique indices
  - Before: `ALTER TABLE...`, After: `DROP INDEX...`
