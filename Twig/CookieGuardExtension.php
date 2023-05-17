<?php
declare(strict_types=1);

namespace FH\Bundle\CookieGuardBundle\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CookieGuardExtension extends AbstractExtension
{
    private ?Request $request = null;
    private RequestStack $requestStack;
    private Environment $twig;
    private string $cookieName;

    public function __construct(RequestStack $requestStack, Environment $twig, string $cookieName)
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
        return $this->twig->render('@FHCookieGuard/CookieGuard/cookieGuardedContent.html.twig', [
            'content' => $content,
            'show' => $this->cookieSettingsAreAccepted()
        ]);
    }

    public function cookieSettingsAreAccepted(): bool
    {
        return (bool) $this->getRequest()->cookies->get($this->cookieName, false);
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

        return $this->request =
            method_exists($this->requestStack, 'getMainRequest')
                ? $this->requestStack->getMainRequest()
                : $this->requestStack->getMasterRequest()
            ;
    }
}
