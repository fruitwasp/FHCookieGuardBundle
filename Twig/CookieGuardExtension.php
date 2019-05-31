<?php
declare(strict_types=1);

namespace FH\Bundle\CookieGuardBundle\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CookieGuardExtension extends AbstractExtension
{
    private $request;
    private $requestStack;
    private $twig;
    private $cookieName;

    public function __construct(RequestStack $requestStack, \Twig_Environment $twig, string $cookieName)
    {
        $this->requestStack = $requestStack;
        $this->twig = $twig;
        $this->cookieName = $cookieName;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('cookie_guard', [$this, 'showIfCookieAccepted'], ['pre_escape' => 'html', 'is_safe' => ['html']])
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('cookie_settings_submitted', [$this, 'cookieSettingsSubmitted'], ['is_safe' => ['html']]),
            new TwigFunction('cookie_settings_accepted', [$this, 'cookieSettingsAreAccepted'])
        ];
    }

    public function showIfCookieAccepted(string $content): string
    {
        return $this->twig->render('FHCookieGuardBundle:CookieGuard:cookieGuardedContent.html.twig', [
            'content' => $content,
            'show' => $this->cookieSettingsAreAccepted()
        ]);
    }

    /**
     * @return mixed
     */
    public function cookieSettingsAreAccepted()
    {
        return $this->getRequest()->cookies->get($this->cookieName, false);
    }

    public function cookieSettingsSubmitted(): bool
    {
        return $this->getRequest()->cookies->has($this->cookieName);
    }

    private function getRequest(): Request
    {
        if ($this->request instanceof Request) {
            return $this->request;
        }

        $this->request = $this->requestStack->getMasterRequest();

        return $this->request;
    }

    public function getName(): string
    {
        return get_class($this);
    }
}
