<?php

namespace Scraper;

//ini_set('display_errors', 'on');
//error_reporting(E_ALL);

class Creator
{
    /**
     * Injects dependencies Curl class and Scrape class
     * @param \Scraper\GetHtmlInterface $getter
     * @param \Scraper\ParseHtmlInterface $parser
     */
    function __construct(GetHtmlInterface $getter, ParseHtmlInterface $parser) 
    {
        $this->getter           = $getter;
        $this->parser           = $parser;
        
        $scraper_config         = \Config::get('scraper_config');    
        $this->url              = $scraper_config['url'];
    }
    
    /**
     * Executes curl class, returns html chunk, and passes it to Scrape class for processing, returning array
     * @return array
     */
    public function executeScrape()
    {
        $result                 = $this->getter->htmlGet($this->url);
        
        //echo $result['html'];
        
        $result                 = $this->parser->scrapeMainPage($result['html']);
        
        $result                 = $this->parser->processLinkPage($result, $this->getter);
        
        $result                 = $this->parser->resultCleanup($result);
        
        return $result;
        
        //echo json_encode($result);
         
    }
}