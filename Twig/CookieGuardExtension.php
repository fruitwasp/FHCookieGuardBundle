<?php

namespace FH\Bundle\CookieGuardBundle\Twig;

use Symfony\Component\HttpFoundation\RequestStack;

class CookieGuardExtension extends \Twig_Extension
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var string
     */
    private $cookieName;

    public function __construct(RequestStack $requestStack, \Twig_Environment $twig, $cookieName)
    {
        $this->requestStack = $requestStack;
        $this->twig = $twig;
        $this->cookieName = $cookieName;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('cookie_guard', [$this, 'showIfCookieAccepted'], ['pre_escape' => 'html', 'is_safe' => ['html']])
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('cookie_settings_submitted', [$this, 'cookieSettingsSubmitted'], ['is_safe' => ['html']])
        ];
    }

    /**
     * @param string $html
     * @return string
     */
    public function showIfCookieAccepted($html)
    {
        $request = $this->requestStack->getMasterRequest();

        $cookiesAccepted = $request->cookies->get($this->cookieName, false);

        return $this->twig->render('FHCookieGuardBundle:CookieGuard:cookieGuardedContent.html.twig', [
            'content' => $html,
            'show' => $cookiesAccepted
        ]);
    }

    /**
     * @return bool
     */
    public function cookieSettingsSubmitted()
    {
        $request = $this->requestStack->getMasterRequest();
        $cookiesAccepted = $request->cookies->get($this->cookieName, null);
        return !is_null($cookiesAccepted);
    }
}
