<?php


class ScrapeController extends BaseController 
{
    
    //public $source                  = 'http://www.sainsburys.co.uk/webapp/wcs/stores/servlet/CategoryDisplay?listView=true& orderBy=FAVOURITES_FIRST&parent_category_rn=12518&top_category=12518&lang Id=44&beginIndex=0&pageSize=20&catalogId=10137&searchTerm=&categoryId=1857 49&listId=&storeId=10151&promotionId=#langId=44&storeId=10151&catalogId=10137& categoryId=185749&parent_category_rn=12518&top_category=12518&pageSize=20&o rderBy=FAVOURITES_FIRST&searchTerm=&beginIndex=0&hideFilters=true';
    
    
    public function execute()
    {
        $scraper                       = App::make('Scraper\Creator');
        
        $result                        = $scraper->executeScrape();
        
        return Response::json($result);
    }
}

?>

