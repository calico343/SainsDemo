<?php

ini_set('display_errors', 'on');
error_reporting(E_ALL);

class HomeController extends BaseController 
{
    public $html;
    
    
    public function copycat()
    {
                $source                 = 'http://www.sainsburys.co.uk/webapp/wcs/stores/servlet/CategoryDisplay?listView=true&orderBy=FAVOURITES_FIRST&parent_category_rn=12518&top_category=12518&langId=44&beginIndex=0&pageSize=20&catalogId=10137&searchTerm=&categoryId=185749&listId=&storeId=10151&promotionId=#langId=44&storeId=10151&catalogId=10137&categoryId=185749&parent_category_rn=12518&top_category=12518&pageSize=20&orderBy=FAVOURITES_FIRST&searchTerm=&beginIndex=0&hideFilters=true';
        //$source                 = 'http://www.google.com/';
        
        $html                    = $this->getcurl($source);
        //$html                    = file_get_contents('source');
        
        $dom = HtmlDomParser::str_get_html($html);
        
        $result = $dom->find('.product');
        
        foreach($result as $k => $v)
        {
            $inner =  $v->find('.pricePerUnit');
            
            foreach($inner as $var)
            {
                echo $var;
            }
        }
        //$cat = new Copycat();

        //var_dump($cat);
    }
    
    public function getcurl($source)
    {
        $cookie_file_path = 'cookie.txt'; 
        $cookie_file_path = realpath($cookie_file_path); 

        $ch             = curl_init();

        curl_setopt($ch, CURLOPT_URL, $source); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        //curl_setopt($ch, CURLOPT_USERAGENT, 'cURL');

        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path); 
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path); 

        curl_setopt($ch, CURLOPT_VERBOSE, TRUE); 
        $agent = $_SERVER["HTTP_USER_AGENT"];
        curl_setopt($ch, CURLOPT_USERAGENT, $agent); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); 


        $output         = curl_exec($ch); 

        $info = curl_getinfo($ch);

        if(curl_errno($ch))
        {
            echo 'Curl error: ' . curl_error($ch);
        }

        //echo $info['CURLINFO_SIZE_DOWNLOAD'];
        
        echo ($info['size_download']);
        
        curl_close($ch);    

        return $output;
    }

}
