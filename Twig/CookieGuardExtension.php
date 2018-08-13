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
            new \Twig_SimpleFunction('cookie_settings_submitted', [$this, 'cookieSettingsSubmitted'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('cookie_settings_accepted', [$this, 'cookieSettingsAreAccepted'])
        ];
    }

    /**
     * @param string $html
     * @return string
     */
    public function showIfCookieAccepted($html)
    {
        return $this->twig->render('FHCookieGuardBundle:CookieGuard:cookieGuardedContent.html.twig', [
            'content' => $html,
            'show' => $this->cookieSettingsAreAccepted()
        ]);
    }

    public function cookieSettingsAreAccepted()
    {
        return $this->getRequest()->cookies->get($this->cookieName, false);
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

    /**
     * @return string
     */
    public function getName()
    {
        return get_class($this);
    }
}
