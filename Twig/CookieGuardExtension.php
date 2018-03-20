<?php

namespace FH\Bundle\CookieGuardBundle\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CookieGuardExtension extends \Twig_Extension
{
    /**
     * @var Request
     */
    private $request;

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
        $cookiesAccepted = $this->getRequest()->cookies->get($this->cookieName, false);

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
        return $this->getRequest()->cookies->has($this->cookieName);
    }

    /**
     * @return Request
     */
    private function getRequest()
    {
        if ($this->request instanceof Request) {
            return $this->request;
        }

        $this->request = $this->requestStack->getMasterRequest();

        return $this->request;
    }
}
