Installation
============

1. Add the FHCookieGuardBundle repository to your composer.json:
    ```js
    // composer.json
    {
        "repositories": [
            {
                "type": "vcs",
                "url": "git@github.com:freshheads/FHCookieGuardBundle.git"
            }
        ]
    }
    ```

2. Install the FHCookieGuardBundle and it's dependencies:
    ```bash
    composer require freshheads/cookie-guard-bundle
    ```

3. Add the bundle and its dependencies (if not already present) to AppKernel.php:
   ```php
   // in AppKernel::registerBundles()
   $bundles = array(
       // ...
       new FH\Bundle\CookieGuardBundle\FHCookieGuardBundle(),
       // ...
   );
   ```

Now the bundle is ready to be [configured](configuration.md)!
