CHANGELOG
=========

This changelog references the relevant changes (bug and security fixes) done.

To get the diff for a specific change, go to https://github.com/freshheads/FHCookieGuardBundle/commit/XXX where XXX is the change hash
To get the diff between two versions, go to https://github.com/freshheads/FHCookieGuardBundle/compare/1.1.0...1.2.0

* __1.4.0__ ([code comparison](https://github.com/freshheads/FHCookieGuardBundle/compare/1.3.0...1.4.0))

  * Dropped Symfony 4.4 support
  * Added support for PHP 8.0.2 and upwards
  * Added Symfony 6 support
  * Dropped `fh_cookie_guard.twig.cookie_guard_extension` service alias, in favor of the `FH\Bundle\CookieGuardBundle\Twig\CookieGuardExtension` class directly

* __1.3.0__ ([code comparison](https://github.com/freshheads/FHCookieGuardBundle/compare/1.2.1...1.3.0))

  * Dropped PHP 7.1.3 support, minimal required PHP version 7.2.5
  * Added Symfony 5 support

* __1.2.1__ ([code comparison](https://github.com/freshheads/FHCookieGuardBundle/compare/1.2.0...1.2.1))

  * Fixed Twig template reference deprecation

* __1.2.0__ ([code comparison](https://github.com/freshheads/FHCookieGuardBundle/compare/1.1.0...1.2.0))

  * Dropped PHP 5.6 support, minimal required PHP version 7.1.3
  * Dropped Symfony 2.8 support, minimal required Symfony version 3.4.0
  * Added PHPUnit tests
  * Added [Travis CI](https://travis-ci.org/freshheads/FHCookieGuardBundle)
  * Made code more strict (added return types, added `final` keywords)
  * Added `autowiring` and `autoconfiguring`
  * Cleaned up code

* __1.1.0__ ([code comparison](https://github.com/freshheads/FHCookieGuardBundle/compare/1.0.0...1.1.0))

  * Bundle made publicly available on [Packagist](https://packagist.org/packages/freshheads/cookie-guard-bundle)
  * Updated documentation
  * Added `cookie_settings_accepted` Twig function
  * Added Symfony 2.8 support

* __1.0.0__ Initial version
