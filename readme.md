## Web Scraper demo application. 

This demo app is written in Laravel 4.2, and requires PHP >5.4 to run. 

INSTALLATION



1   Using Composer, create a new Laravel 4.2 application. 
2   Copy the /app directory enclosed here into the project, overwriting the default /app folder and files. 
3   Create a new folder "cookie" in the /public folder, and create within it a file "cookie.txt"
4   Copy routes.php enclosed here to the application root, overwriting the default file
5   Run "composer update" at the command line to update all dependencies and class loaders.

USE

The Scraper demo runs from either a web browser or the command-line.

Browser: open <path to webroot>/public/domtest (EG: http://localhost/SainsDem/public/domtest)

Console: navigate to the application's root folder and run this command: php artisan scrape:scrape

TESTS

Unit Tests can be run by navigating to the application root folder in console and running the command: phpunit



