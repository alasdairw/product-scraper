<?php

namespace App\Parsers;
use App\Parsers\Parser;
use App\Crawlers\JSProductCrawler;

class ProductParser implements Parser
{

    public function __construct(JSProductCrawler $crawler)
    {
        $this->markup = $crawler->getURL();
    }

    public function getParsedData()
    {
    }
    
    /**
     * Get the product description
     * @todo Detemine whether the test meant the META description or the text displayed in a certain part of the rendered page.
     * The specification simple said "description" and what was contained in the example JSON looks a lot more like what's in the meta
     * description than what is rendered on the page, so there's ambiguity.  It's easy enough to chance here, simple change 
     * the filterXPath to filter->('.productText') and ->attr('content') to just ->text()
     * @todo Would this require sanitising?
     * @return string String containing the description data.
     */
    public function getDescription()
    {
        $description = $this->markup->filterXPath('//meta[@name="description"]')->attr('content');
        //If I've chosen the wrong description element here, then the alternate is:
        //$description = trim($this->markup->filter('.productText')->text());
        return $description;
    }

    /**
     * Get the human-formatted size in b/kb/mb etc for the requested page
     * @return string String containing size data for requested page
     */
    public function getSize()
    {
        $size_in_bytes = $this->client->getInternalResponse()->getHeader('Content-Length');
        return $this->formatSizeData($size_in_bytes);
    }

    /**
     * Formet the size string to the required format.  Very unlikely to be the high end
     * of the possible formats, but let's not assume...
     * @param int $size_in_bytes integer value of bytes
     * @return string formatted string with appropriate suffix
     */
    private function formatSizeData($size_in_bytes)
    {
        $unit=array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
        return @round($size_in_bytes / pow(1024, ($i = floor(log($size_in_bytes, 1024)))), 2).$unit[$i];
    }
}