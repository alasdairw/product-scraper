<?php
namespace App\Tests;
use Mockery\Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use App\Crawlers\JSProductCrawler;

/**
 * Simple tests for the JSProductCrawler class
 * @todo: 
 */
class JSProductCrawlerTest extends TestCase
{
    /**
     * Test the specific GET URL function
     * @todo Mock this?
     * @return void
     */
    public function testGetURL()
    {
        $crawler = new JSProductCrawler();
        $response = $crawler->getURL('http://google.com');
        $this->assertInstanceOf(Crawler::class,$response);
    }
}