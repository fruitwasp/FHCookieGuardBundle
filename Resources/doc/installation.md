Installation
============

1. Install the FHCookieGuardBundle and it's dependencies:
    ```bash
    composer require freshheads/cookie-guard-bundle
    ```

2. Add the bundle and its dependencies (if not already present) to AppKernel.php:
   ```php
   // in AppKernel::registerBundles()
   $bundles = [
       // ...
       new FH\Bundle\CookieGuardBundle\FHCookieGuardBundle(),
       // ...
   ];
   ```

Now the bundle is ready to be [configured](configuration.md)!
