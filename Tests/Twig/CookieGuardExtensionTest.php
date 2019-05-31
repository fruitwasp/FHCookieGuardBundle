<?php
declare(strict_types=1);

namespace FH\Bundle\CookieGuardBundle\Tests\Twig;

use FH\Bundle\CookieGuardBundle\Twig\CookieGuardExtension;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * @author Evert Harmeling <evert@freshheads.com>
 */
final class CookieGuardExtensionTest extends TestCase
{
    private const COOKIE_NAME = 'test-cookie';

    public function testFilterExistence(): void
    {
        // arrange
        $extension = $this->createCookieGuardExtension();

        $filterNames = [];
        /** @var \Twig_Filter $filter */
        foreach ($extension->getFilters() as $filter) {
            Assert::assertInstanceOf(TwigFilter::class, $filter);
            $filterNames[] = $filter->getName();
        }

        Assert::assertContains('cookie_guard', $filterNames);
    }

    public function testFunctionExistence(): void
    {
        // arrange
        $extension = $this->createCookieGuardExtension();

        $functionNames = [];
        /** @var \Twig_Function $filter */
        foreach ($extension->getFunctions() as $function) {
            Assert::assertInstanceOf(TwigFunction::class, $function);
            $functionNames[] = $function->getName();
        }

        Assert::assertContains('cookie_settings_submitted', $functionNames);
        Assert::assertContains('cookie_settings_accepted', $functionNames);
    }

    public function testCookieSettingsAreNotAccepted(): void
    {
        // arrange
        $extension = $this->createCookieGuardExtension();

        // act && assert
        Assert::assertFalse($extension->cookieSettingsAreAccepted());
    }

    public function testCookieSettingsAreAccepted(): void
    {
        // arrange
        $request = $this->createRequestWithCookie();
        $extension = $this->createCookieGuardExtension($this->createRequestStackMock($request));

        // act && assert
        Assert::assertTrue($extension->cookieSettingsAreAccepted());
    }

    public function testCookieSettingsAreNotSubmitted(): void
    {
        // arrange
        $extension = $this->createCookieGuardExtension();

        // act && assert
        Assert::assertFalse($extension->cookieSettingsSubmitted());
    }

    public function testCookieSettingsAreSubmitted(): void
    {
        // arrange
        $request = $this->createRequestWithCookie();
        $extension = $this->createCookieGuardExtension($this->createRequestStackMock($request));

        // act && assert
        Assert::assertTrue($extension->cookieSettingsSubmitted());
    }

    public function testShowIfCookieIsNotAccepted(): void
    {
        // arrange
        $extension = $this->createCookieGuardExtension();

        // act && assert
        Assert::assertEquals(
            sprintf('<meta class="js-cookie-guarded" data-content="%s" />', 'cookie not accepted'),
            $extension->showIfCookieAccepted('cookie not accepted')
        );
    }

    public function testShowIfCookieAccepted(): void
    {
        // arrange
        $extension = $this->createCookieGuardExtension(null, $this->createTwigEnvironmentMock('cookie accepted', true));

        // act && assert
        Assert::assertEquals('cookie accepted', $extension->showIfCookieAccepted('cookie accepted'));
    }

    public function testName(): void
    {
        // arrange
        $extension = $this->createCookieGuardExtension();

        // act && assert
        Assert::assertEquals(CookieGuardExtension::class, $extension->getName());
    }

    private function createRequestWithCookie(): Request
    {
        return new Request([], [], [], [
            self::COOKIE_NAME => true
        ]);
    }

    private function createCookieGuardExtension(RequestStack $requestStack = null, MockObject $twigEnvironment = null): CookieGuardExtension
    {
        return new CookieGuardExtension(
            $requestStack ?? $this->createRequestStackMock(),
            $twigEnvironment ?? $this->createTwigEnvironmentMock(),
            self::COOKIE_NAME
        );
    }

    private function createRequestStackMock(Request $request = null): RequestStack
    {
        $requestStack = new RequestStack();
        $requestStack->push($request ?? Request::createFromGlobals());

        return $requestStack;
    }

    /**
     * @return MockObject|Environment
     */
    private function createTwigEnvironmentMock(string $content = 'cookie not accepted', bool $show = false): MockObject
    {
        $twigEnvironmentMock = $this->getMockBuilder(Environment::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'render'
            ])
            ->getMock();

        if (!$show) {
            $content = sprintf('<meta class="js-cookie-guarded" data-content="%s" />', $content);
        }

        $twigEnvironmentMock
            ->method('render')
            ->willReturn($content);

        return $twigEnvironmentMock;
    }
}
