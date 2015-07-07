<?php

class ScraperTest extends TestCase 
{
    protected $scraper;

    public function setUp()
    {
        $this->scraper = App::make('Scraper\ParseHtml');
    }

    
    public function testTagInnerContentGetter()
    {
        $tagString          = "<p>Test</p>";
        
        $resultString       = $this->scraper->everything_in_tags($tagString, 'p');
        
        $this->assertEquals ($resultString, "Test");
    }
     
}
