# Not a Framework 0.0

Master: [![Build Status](https://secure.travis-ci.org/ajcrites/not-a-framework.png?branch=master)](http://travis-ci.org/ajcrites/not-a-framework)

Not-a-framework is a PHP Non-framework that focuses on
code organization and flexibility.

It's goal is to provide simple organization of and
implementation for boilerplate code that will allow
developers to set up web application projects quickly.

NaF offers very few components, makes no claims for
speed, probably implements MVC incorrectly, and is
brand new.  As such it should not be used by anyone.

## NaF Breakdown

NaF uses the namespace `Naf` (lower-cased "f" on purpose
for convenience) and follows the PSR-0 standard for
autoloading.

## NaF Directories

### `test`
Unit test files go here.

#### `help`
Helper files for unit tests

#### `integrate`
Large-scale and/or cross-components tests

#### `unit`
Tests of individual classes and their dependencies.

### `src`
All NaF coponents go here.  NaF projects should link
`system` to this directory

#### `di`
Dependency-injection related components

#### `http`
Components for handling HTTP requests and responses
