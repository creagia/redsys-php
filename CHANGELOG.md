# Changelog

All notable changes to `redsys-php` will be documented in this file.

## 3.0.0 - 2024-06-xx

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
