<?php
namespace App\Tests;
use PHPUnit\Framework\TestCase;
use App\Parsers\ProductParser;
use App\Parsers\IndexParser;
use Symfony\Component\DomCrawler\Crawler;
/**
 * Simple tests for the Product parser class
 * @todo: should probably use a proper mock HTTP library for this, but lumeuse PHPUnit\Framework\TestCase;
n makes it easy enough to have
 * a couple of routes that load fixed test data on local URLs.
 */
class ProductParserTest extends TestCase
{
    /**
     * In the absence of a proper Mock, we'll get an arbitrary URL from the test
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * test the get_description function - that it returns a string of longer than 1 character
     * @return void
     */
    public function testGetDescription()
    {
        //$description = $this->parser->getDescription();
        $this->assertInternalType('string',$description);
        $this->assertGreaterThanOrEqual(1,strlen($description));
    }

    /**
     * test the get_size function  - that it returns a string of longer than 1 character
     * @return void
     */
    public function testGetSize()
    {
        //$size = $this->parser->getSize();
        $this->assertInternalType('string',$size);
        $this->assertGreaterThanOrEqual(1,strlen($size));   
    }
}