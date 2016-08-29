<?php
namespace App\Tests;
use PHPUnit\Framework\TestCase;
use App\Parsers\ProductParser;
use App\Crawlers\JSProductCrawler;
use Symfony\Component\DomCrawler\Crawler;
use Mockery;
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
        $html = <<<EOD
<html>
    <head>
        <meta name="description" content="Buy Sainsbury&#039;s Conference Pears, Ripe &amp; Ready x4 (minimum) online from Sainsbury&#039;s, the same great quality, freshness and choice you&#039;d find in store. Choose from 1 hour delivery slots and collect Nectar points."/>
    </head>
    <body>
        <div class="productText">
            <p>Conference</p>
        </div>
    </body>
</html>
EOD;

        $crawler = Mockery::mock(JSProductCrawler::class);
        $crawler->shouldReceive('getURL')
                ->once()
                ->andReturn(new Crawler($html,'http://localhost'));
        $crawler->shouldReceive('getSize')
                ->once()
                ->andReturn(10000);
        $this->parser = new ProductParser($crawler);
    }

    /**
     * test the get_description function - that it returns a string of longer than 1 character
     * @return void
     */
    public function testGetDescription()
    {
        $description = $this->parser->getDescription();
        $this->assertInternalType('string',$description);
        $this->assertGreaterThanOrEqual(1,strlen($description));
        $this->assertEquals('Buy Sainsbury\'s Conference Pears, Ripe & Ready x4 (minimum) online from Sainsbury\'s, the same great quality, freshness and choice you\'d find in store. Choose from 1 hour delivery slots and collect Nectar points.',$description);
        
    }

    /**
     * test the get_size function  - that it returns a string of longer than 1 character
     * @return void
     */
    public function testGetSize()
    {
        $size = $this->parser->getSize();
        $this->assertInternalType('string',$size);
        $this->assertGreaterThanOrEqual(1,strlen($size));
        $this->assertEquals('9.77kb',$size);

    }
}