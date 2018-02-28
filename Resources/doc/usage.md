Usage
=====

## cookie_guard twig filter
After installing this bundle you can use the cookie_guard twig filter. If the use of cookies has been accepted, the filter makes sure your script wil be applied on the page, otherwise the script will be included as a meta tag. 

Below you find an example of Google Tag Manager in combination with cookie_guard:

```html
   {{ ("
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','0123456789');</script>
        <!-- End Google Tag Manager -->") | raw | cookie_guard
    }}
