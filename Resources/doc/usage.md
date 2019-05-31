Usage
=====

## Setting the "cookies-accepted" cookie:
This FHCookieGuardBundle itself does not set the "cookies-accepted" cookie, you need to set the cookie by your own, for example with javascript. The name of the cookie (default: "cookies-accepted") needs to be the same as configured in the configuration and the value needs to be ```1``` for accepted and ```0``` for 
refused.

## cookie_settings_submitted() twig function:
To check if there are cookie settings submitted by the user, you can use de cookie_settings_submitted() twig function. This function returns ```true``` if the cookie configured in the configuration (default: "cookies-accepted") is found, otherwise the function returns ```false```.

Below you find an example of the cookie_settings_submitted() function:

```html
    {% if not cookie_settings_submitted() %}
        {% include "templates/website/cookie/cookieSettings.html.twig" %}
    {% endif %}
```

## cookie_settings_accepted() twig function:
To check if the cookie settings are accepted by the user, you can use de cookie_settings_accepted() twig function.

Below you find an example of the cookie_settings_submitted() function:

```html
    {% if cookie_settings_accepted() %}
        {% include "templates/website/banner/advert.html.twig" %}
    {% endif %}
```

## cookie_guard twig filter:
If the use of cookies has been accepted, the filter makes sure your script wil be applied on the page, otherwise the script will be included as a meta tag. 

Below you find an example of Google Tag Manager in combination with cookie_guard:

```html
   {{ ("
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','0123456789');</script>
        <!-- End Google Tag Manager -->")|raw|cookie_guard
    }}
