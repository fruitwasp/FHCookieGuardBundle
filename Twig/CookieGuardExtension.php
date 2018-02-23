<?php

namespace FH\Bundle\CookieGuardBundle\Twig;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Nash van Gool <nash.van.gool@freshheads.com>
 */
class CookieGuardExtension extends \Twig_Extension
{
    const COOKIE_NAME = 'cookies-accepted';

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(RequestStack $requestStack, \Twig_Environment $twig)
    {
        $this->requestStack = $requestStack;
        $this->twig = $twig;
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

    public function showIfCookieAccepted($html)
    {
        $request = $this->requestStack->getMasterRequest();
        $cookiesAccepted = $request->cookies->get(self::COOKIE_NAME, false);
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
        $cookiesAccepted = $request->cookies->get(self::COOKIE_NAME, null);
        return !is_null($cookiesAccepted);
    }
}
