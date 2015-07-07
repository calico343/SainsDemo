<?php

namespace Scraper;

class GetHtml implements GetHtmlInterface
{
    
    /**
     * Curl function that retrieves page html, calculates page size, and returns both in an array
     * @param string $url
     * @return array
     */
    public function htmlGet($url)
    {
        $root               =  $_SERVER['DOCUMENT_ROOT'];
        $cookie_file_path   = ".$root/public/cookie/cookie.txt"; 
        $cookie_file_path   = realpath($cookie_file_path); 

        $ch                 = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        //curl_setopt($ch, CURLOPT_USERAGENT, 'cURL');

        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path); 
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path); 

        curl_setopt($ch, CURLOPT_VERBOSE, TRUE); 
        //$agent = $_SERVER["HTTP_USER_AGENT"];
        $agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.130 Safari/537.36';
        //
        curl_setopt($ch, CURLOPT_USERAGENT, $agent); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); 

        $output         = curl_exec($ch); 

        $info = curl_getinfo($ch); 
         
        curl_close($ch);    

        return array('html' => $output, 'size' => $info['size_download']);
    }
}