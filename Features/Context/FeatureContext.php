<?php

namespace Alpha\VisitorTrackingBundle\Features\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    use KernelDictionary;

    /**
     * @Given /^the cookie "([^"]*)" has the value "([^"]*)"$/
     */
    public function theCookieHasTheValue($name, $value)
    {
        $this->getSession()->setCookie($name, $value);
    }
}
