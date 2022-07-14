<?php
declare(strict_types=1);

namespace FH\Bundle\CookieGuardBundle\Tests\DependencyInjection;

use FH\Bundle\CookieGuardBundle\DependencyInjection\FHCookieGuardExtension;
use FH\Bundle\CookieGuardBundle\Twig\CookieGuardExtension;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Evert Harmeling <evert@freshheads.com>
 */
final class FHCookieGuardExtensionTest extends TestCase
{
    private ?ContainerBuilder $container;
    private ?FHCookieGuardExtension $extension;

    public function setUp(): void
    {
        $this->container = new ContainerBuilder();
        $this->extension = new FHCookieGuardExtension();
    }

    public function testExtensionLoadedDefaults(): void
    {
        $this->extension->load([], $this->container);

        Assert::assertEquals('cookies-accepted', $this->container->getParameter('fh_cookie_guard.cookie_name'));
        Assert::assertContains(CookieGuardExtension::class, $this->container->getServiceIds());

        Assert::assertTrue($this->container->hasDefinition(CookieGuardExtension::class));
    }

    public function tearDown(): void
    {
        unset($this->container, $this->extension);
    }
}
