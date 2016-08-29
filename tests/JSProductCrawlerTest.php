<?php
namespace App\Tests;
use Mockery\Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use App\Crawlers\JSProductCrawler;

/**
 * Class JSProductCrawlerTest
 * @package App\Tests
 */
class JSProductCrawlerTest extends TestCase
{
    /**
     * Test the specific GET URL function
     * I think we actually specifically want this to make a proper GET request, externally, since
     * the purpose of this test is to actually check that we can - after all the application will
     * fail if that's not possible for any reason.
     * 
     * @return void
     */
    public function testGetURL()
    {
        $crawler = new JSProductCrawler();
        $response = $crawler->getURL('http://google.com');
        $this->assertInstanceOf(Crawler::class,$response);
    }
}