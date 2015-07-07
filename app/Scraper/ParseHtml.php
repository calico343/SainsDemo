<?php
namespace Scraper;

class ParseHtml implements ParseHtmlInterface
{
    /**
     * class property that will contain the specified structured data output
     * @var type 
     */
    public $returnArray =  array();
    
    /**
     * Parses main page using domparser, retrieves array of dom objects with class 'product' and extracts relevant info
     * @param string $html
     * @return array
     */
    public function scrapeMainPage($html)
    {
        $dom            = \HtmlDomParser::str_get_html($html);
        
        $result         = $dom->find('.product');
        
        $this->findUnitprice($result);
        $this->findTitle($result);
        $this->findLink($result);
        
        //echo json_encode($this->returnArray);
        
        return $this->returnArray;
    }
    
    /**
     * updates returnArray with price info for each product found
     * @param object $result
     */
    public function findUnitprice($result)
    {
        $counter        = 0;
        
        foreach($result as $k => $v)
        {
            $inner      = $v->find('.pricePerUnit');
            
            foreach($inner as $var)
            {
                $price  = $this->stripToDecimal($var);
            }
            
            $this->returnArray[$counter]['unit_price']       =  $price;             
            $counter++;
        }
    }
    
    /**
     * updates returnArray with title info for each product found
     * @param object $result
     */
    public function findTitle($result)
    {
        $counter        = 0;
        
        foreach($result as $k => $v)
        {
            $infoInner      = $v->find('.productInfo');
            
            foreach($infoInner as $ivar)
            {
                $ivarInner = $ivar->innertext;
                
                $title  = $this->striptToTitle($ivarInner);
            }
           
            $this->returnArray[$counter]['title']       =  $title; 
             
            $counter++;
        }
    }
    
    /**
     * updates returnArray with link url for each product found
     * @param object $result
     */
    public function findLink($result)
    {
        $counter        = 0;
        
        foreach($result as $k => $v)
        {
            $infoInner      = $v->find('.productInfo');
            
            foreach($infoInner as $ivar)
            {
                $ivarInner  = $ivar->innertext;
                $link       = $this->everything_in_tags($ivarInner, 'h3');
                $splitLink  = explode("href", $link);
                $splitter   = explode('>', $splitLink[1]);
                $url        = explode('"', $splitter[0])[1];
            }
            
            $this->returnArray[$counter]['link']       =  $url; 
            $counter++;
        }
    }
    
    /**
     * Parses innerHtml of Title tags to get exact text
     * @param string $text
     * @return string
     */
    public function striptToTitle($text)
    {
        $string             = $this->everything_in_tags($text, 'a');
        $split              = explode('<', $string);
        //$start              = substr($split[0], 4, -4);
        return trim(preg_replace('/\t+/', '', $split[0]));
    }
    
    /**
     * Gets the innerHtml of any tag enclosed characters
     * @param string $string
     * @param string $tagname
     * @return string
     */
    function everything_in_tags($string, $tagname)
    {
        $pattern            = "#<\s*?$tagname\b[^>]*>(.*?)</$tagname\b[^>]*>#s";
        preg_match($pattern, $string, $matches);
        return $matches[1];
    }

    /**
     * Parses innerHtml of Price tags to get exact value
     * @param string $var
     * @return decimal
     */
    public function stripToDecimal($var)
    {
        $inner = $var->innertext;
        
        $inner = str_replace('<abbr title="per">/</abbr><abbr title="unit"><span class="pricePerUnitUnit">unit</span></abbr>', '', $inner);
        
        return $price = (substr($inner, 3));
    }
    
    /**
     * Takes Html of sublinks and processes it
     * @param object $result
     * @param interface $getter
     * @return type
     */
    public function processLinkPage($result, $getter)
    {
        $this->returnArray          = $result;
        $counter                    = 0;
        
        foreach($result as $k => $v)
        {
            $page                   = $getter->htmlGet($v['link']);
            
            $this->returnArray[$counter]['size']            = $page['size'];
            $this->returnArray[$counter]['description']     = $this->scrapeLinkPage($page['html']);
            
            $counter++;
        }
        
        return $this->returnArray;
    }
    
    /**
     * Takes Html of sub page and processes it
     * @param string $page
     * @return string
     */
    public function scrapeLinkPage($page)
    {
        $dom            = \HtmlDomParser::str_get_html($page);
        $result         = $dom->find('.productText');
        
        $x              = 0;
        foreach ($result as $k => $v)
        {
            if($x == 0)
            {
                $productText = $v->innertext;
            }
            $x++;
        }
        
        $returnText       = '';
        
        $parray           = \HtmlDomParser::str_get_html($productText);
        $parray           = $parray->find('p');
        
        foreach($parray as $k => $v)
        {
            $returnText .= $v->innertext;
        }
        
        $returnText     = str_replace('<br>', '', $returnText);
        
        return $returnText;
    }
    
    /**
     * Removes link info from array to match specification
     * @param array $result
     * @return array
     */
    public function resultCleanup($result)
    {
        $returnArray            = array();
        foreach ($result as $k => $v)
        {
            foreach ($v as $key => $var)
            {
                if($key != 'link')
                {
                    $returnArray[$k][$key]        = $var;
                }                
            }
        }        
        return $returnArray;
    }
}