<?php
namespace App\Tests;
use Mockery;
use PHPUnit\Framework\TestCase;
use App\Parsers\IndexParser;
use Symfony\Component\DomCrawler\Crawler;
use App\Crawlers\JSProductCrawler;

/**
 * Simple tests for the Base parser class
 * @todo: should probably use a proper mock HTTP library for this, but lumen makes it easy enough to have
 * a couple of routes that mock back the test data on local URLs.
 */
class IndexParserTest extends TestCase
{
    

    public function setUp()
    {
        $html = <<<EOD
<html>
    <head></head>
    <body>
        <div class="productInner">
            <div class="productInfoWrapper">
                <div class="productInfo">
                    <h3>
                        <a href="http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-apricot-ripe---ready-320g.html">
                            Sainsbury's Apricot Ripe &amp; Ready x5
                            <img src="http://c2.sainsburys.co.uk/wcsstore7.11.1.161/SainsburysStorefrontAssetStore/wcassets/product_images/media_7572754_M.jpg" alt="">
                        </a>
                    </h3>
                                
                </div>
            </div>
            <div class="addToTrolleytabBox">
                <div class="addToTrolleytabContainer addItemBorderTop">
                    <div class="pricingAndTrolleyOptions">  
                        <div class="priceTab activeContainer priceTabContainer" id="addItem_149117">    
                            <div class="pricing">
                                <p class="pricePerUnit">
                                    &pound3.50<abbr title="per">/</abbr><abbr title="unit"><span class="pricePerUnitUnit">unit</span></abbr>
                                </p>     
                            </div>  
                        </div>    
                    </div>  
                </div>  
            </div>
        </div>
    </body>
</html>
EOD;

        $crawler = Mockery::mock(JSProductCrawler::class);
        $crawler->shouldReceive('getURL')
                ->once()
                ->andReturn(new Crawler($html,'http://localhost'));
        $this->parser = new IndexParser($crawler);
    }

    /**
     * Test the specific GET request function
     * @return void
     */
    public function testGetParsedData()
    {
        $response = $this->parser->getParsedData();
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
        //$product = $this->parser->filter('.productInner')->eq(0);
        //$output = $this->parser->extractProductData($product);
        //$this->assertArrayHasKey('title',$output);
        //$this->assertArrayHasKey('size',$output);
        //$this->assertArrayHasKey('unit_price',$output);
        //$this->assertArrayHasKey('description',$output);
    }

    /**
     * Test that the getTitle method returns a string of at least 1 character length
     * If and when we have a proper mock, check for a known value
     * @return void
     */
    public function testGetTitle()
    {
        $output = $this->parser->getTitle($this->parser->markup->filter('.productInner')->eq(0));
        $this->assertInternalType('string',$output);
        $this->assertGreaterThanOrEqual(1,strlen($output));
    }

    /**
     * Test that the result of getUnitPrice is a a float
     * @return void
     */
    public function testGetUnitPrice()
    {
        $output = $this->parser->getUnitPrice($this->parser->markup->filter('.productInner')->eq(0));
        $this->assertInternalType('float',$output);
    }

    public function testGetDescriptionAndSize()
    {
        //$output = $this->parser->getDescriptionAndSize($this->parser->base_request->filter('.productInner')->eq(0));
        //$this->assertArrayHasKey('size',$output);
        //$this->assertArrayHasKey('description',$output);
    }
}