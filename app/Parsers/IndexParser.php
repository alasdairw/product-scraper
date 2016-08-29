<?php

namespace App\Parsers;
use App\Parsers\Parser;
use Symfony\Component\DomCrawler\Crawler;
use App\Crawlers\JSProductCrawler;
use App\Crawlers\JSCrawler;

/**
 * Class to parse the Index and extra relevant data for assembly
 */
class IndexParser implements Parser
{
    public function __construct(JSCrawler $crawler)
    {
        $this->markup = $crawler->getURL();
    }

    /**
     * Function to get the correct product data listed on the index page
     * @return  array Array of data to be converted to JSON.
     */
    public function getParsedData()
    {
        $output = $this->markup->filter('.productInner')->each(function (Crawler $product)
            {
                return $this->extractProductData($product);
            });


        //calculate the total value using PHP 5.4
        $total = 0;
        foreach($output as $product)
        {
            $total += $product['unit_price'];
        }

        //The test specified PHP 5.4+ - if 5.5+ is acceptable, then this is a quicker way
        //$total = array_sum(array_column($output,'unit_price'));
        return array('results'=>$output,'total'=>number_format($total,2));
    }
    
    /**
     * Method to extract the required base data from each product and convert to array elements;
     * @param  DOMElement $product DOMElement matching the product info
     * @return array               extracted data for the product
     */
    public function extractProductData(Crawler $product)
    {
        $title = $this->getTitle($product);
        $unit_price = $this->getUnitPrice($product);      
        return array_merge(['title'=>$title,'unit_price'=>number_format($unit_price,2)],$this->getDescriptionAndSize($product));
    }

    /**
     * 
     * @param  Crawler $product Crawler containing product HTML for extraction
     * @return string name of product
     */
    public function getTitle(Crawler $product)
    {
        $title = $product->filter('.productInfo h3 a')->text();
        return trim($title);
    }

    /**
     * Get the unit price as a float.  PHP will helpfully transform it to an integer if it's .00
     * @param  Crawler $product Crawler containing product HTML for extraction
     * @return float               price of product as float
     */
    public function getUnitPrice(Crawler $product)
    {
        $price = $product->filter('.addToTrolleytabBox .pricePerUnit')->text();
        $price = (float) str_replace(['&pound', '/unit'], '', trim($price));
        return $price;
    }

    /**
     * Get the meta decription and size of the linked page - single method to reduce HTTP overhead
     * @param  Crawler $product Crawler containing product HTML for extraction
     * @return array array containing description and link fields as text
     */
    public function getDescriptionAndSize(Crawler $product)
    {
        

        $link_url = $product->selectLink($this->getTitle($product))->link()->getUri();
        $product_parser = new ProductParser(new JSProductCrawler($link_url));
        $description = $product_parser->getDescription();
        $size = $product_parser->getSize();

        return array('description' => $description,'size'=>$size);
    }

}