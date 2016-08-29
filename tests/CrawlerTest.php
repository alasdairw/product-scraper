<?php
use Mockery\Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Simple tests for the JSCrawler class
 * @todo: should probably use a proper mock HTTP library for this, but lumen makes it easy enough to have
 * a couple of routes that mock back the test data on local URLs.
 */
class CrawlerTest extends TestCase
{
    public function testGetURL()
    {
        
    }
}