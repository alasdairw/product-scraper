<?php
//use Laravel\Lumen\Testing\DatabaseTransactions;

use PHPUnit\Framework\TestCase;
use App\Parsers\Parser;
use Symfony\Component\DomCrawler\Crawler;
/**
 * Simple tests for the Base parser class
 * TODO: should probably use a proper mock HTTP library for this, rather than just relying on being able to access google. :)
 */
class ParserTest extends TestCase
{
    /**
     * Test the specific GET request function
     * @return void
     */
    public function testGetURL()
    {
        $parser = new Parser();
        $response = $parser->getURL('http://google.com');
        $this->assertInstanceOf(Crawler::class,$response);
    }
}