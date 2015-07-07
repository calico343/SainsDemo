<?php
namespace Scraper;

interface ParseHtmlInterface
{
    public function scrapeMainPage($html);
    //public function scrapeLinkPage($html);
    //public function countPageSize($html);
    public function stripToDecimal($var);
}