# pedroac\routing for PHP

[![Build Status](https://travis-ci.org/pedroac/routing4php.svg?branch=master)](https://travis-ci.org/pedroac/routing4php)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/626ac4d19104499d88692b7e1232ae3b)](https://app.codacy.com/app/pedroac/routing4php?utm_source=github.com&utm_medium=referral&utm_content=pedroac/routing4php&utm_campaign=badger)
[![Support via PayPal](https://img.shields.io/badge/Donate-PayPal-green.svg)](http://paypal.me/pedroac)

A flexible routing library that maps HTTP requests to a set of variables and callables.

## Running the tests

Run from the library root folder:

`php/vendor/bin/phpunit php/tests/ -c php/tests/configuration.xml`

If the tests were successful, `php/tests/coverage-html` should have the code coverage report.

## Generating HTML documentation

Run from the library root folder:

`sh scripts/generate-docs.sh`

If the documentation was generated successfully, the folder `docs` should have the HTML documentation.

## Examples

- [Hash path router](php/examples/hash-path-router.php)
- [Regex path router](php/examples/regex-path-router.php)
- [Pattern path router](php/examples/pattern-path-router.php)
- [Custom pattern path router](php/examples/custom-pattern-path-router.php)

## Versioning

It should be used [SemVer](http://semver.org/) for versioning.

## Authors

- Pedro Amaral Couto - Initial work - https://github.com/pedroac

## License

pedroac/routing is released under the MIT public license.  
See the enclosed [LICENSE](LICENSE) for details.
