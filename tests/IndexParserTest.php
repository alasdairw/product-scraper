<?php
use Mockery\Mockery;
use PHPUnit\Framework\TestCase;
use App\Parsers\IndexParser;
use Symfony\Component\DomCrawler\Crawler;
/**
 * Simple tests for the Base parser class
 * @todo: should probably use a proper mock HTTP library for this, but lumen makes it easy enough to have
 * a couple of routes that mock back the test data on local URLs.
 */
class IndexParserTest extends TestCase
{
    
    /**
     * In the absence of a proper mock, let's create a parser object and some raw data, for use in
     * all methods that need them, rather than repeatedly creating them.  
     * @todo a proper mock object  
     * 
     */
    public function setUp()
    {
        parent::setUp();
        $this->get('/test-index');
        $html = $this->response->getContent();
        $this->parser = new IndexParser();
        //Crawler requires a base url, even though the links in the content are actually to full 
        //URLS beginning with http://
        $this->parser->base_request = new Crawler($html,'http://test.app');
    }

    /**
     * Test the specific GET request function
     * @return void
     */
    public function testGetProducts()
    {
        $response = $this->parser->getProducts();
        $this->assertArrayHasKey('results',$response);
        $this->assertArrayHasKey('total',$response);
    }

    /**
     * Test the data that is extracted from the products
     * Since I'm not using a proper mock for this, I'm going to rely on testGetProducts passing for now.
     * @return void
     */
    public function testExtractProductData()
    {
        $product = $this->parser->base_request->filter('.productInner')->eq(1);
        $output = $this->parser->extractProductData($product);
        $this->assertArrayHasKey('title',$output);
        $this->assertArrayHasKey('size',$output);
        $this->assertArrayHasKey('unit_price',$output);
        $this->assertArrayHasKey('description',$output);
    }

    /**
     * Test that the getTitle method returns a string of at least 1 character length
     * If and when we have a proper mock, check for a known value
     * @return void
     */
    public function testGetTitle()
    {
        $output = $this->parser->getTitle($this->parser->base_request->filter('.productInner')->eq(0));
        $this->assertInternalType('string',$output);
        $this->assertGreaterThanOrEqual(1,strlen($output));
    }

    /**
     * Test that the result of getUnitPrice is a a float
     * @return void
     */
    public function testGetUnitPrice()
    {
        $output = $this->parser->getUnitPrice($this->parser->base_request->filter('.productInner')->eq(0));
        $this->assertInternalType('float',$output);
    }

    public function testGetDescriptionAndSize()
    {
        $output = $this->parser->getDescriptionAndSize($this->parser->base_request->filter('.productInner')->eq(0));
        $this->assertArrayHasKey('size',$output);
        $this->assertArrayHasKey('description',$output);
    }
}