# Changelog

All notable changes to `redsys-php` will be documented in this file.

## 3.0.2 - 2025-02-25

### What's Changed

* Bump dependabot/fetch-metadata from 2.2.0 to 2.3.0 by @dependabot in https://github.com/creagia/redsys-php/pull/35
* Add PHP 8.4 tests by @dtorras in https://github.com/creagia/redsys-php/pull/37
* refactors to use '||' and '&&' instead of 'and' and 'or' operators by @ordago in https://github.com/creagia/redsys-php/pull/32

**Full Changelog**: https://github.com/creagia/redsys-php/compare/3.0.1...3.0.2

## 3.0.1 - 2024-07-09

### What's Changed

* fix: Allow requests with amount 0 by @dtorras in https://github.com/creagia/redsys-php/pull/34

**Full Changelog**: https://github.com/creagia/redsys-php/compare/3.0.0...3.0.1

## 3.0.0 - 2024-06-02

### New features:

- POST requests responses are now handled by the package.

### Breaking changes

- Renamed exceptions: All the exceptions have been renamed to include the `*Exception` suffix.
- Renamed `RedsysNotification` as `RedsysResponse`.
- POST requests responses returns `NotificationParameters` or a `PostRequestError`.

### Low impact changes

- Drop spatie/data-transfer-object dependency

## 2.0.1 - 2023-05-16

Fixes tests compatibility

## 2.0.0 - 2023-05-16

This version is a complete rewrite. Though there are lots of breaking changes, all features of v1 are retained.
Notable changes and additions:

- Currency amounts handled in cents as integer
- Every request parameter documented by Redsys is available
- Credential-On-File (token) helpers
- Redirection and REST integration methods

## 1.0.1 - 2022-01-29

- Cast `amount` to float from Redsys notification

## 1.0.0 - 2022-01-25

Initial release
