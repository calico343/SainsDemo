<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Scrape extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'scrape:scrape';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command line Scraper Interface.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
            $scraper                        = App::make('Scraper\Creator');
        
            $returnArray                    = $scraper->executeScrape();

            //$this->info(Response::json($returnArray));
            
            $output                         = PHP_EOL . '----------------------------------------------------------------------------------------------------------------------------------' . PHP_EOL;
            $output                         .= json_encode($returnArray);
            $output                         .= PHP_EOL . '----------------------------------------------------------------------------------------------------------------------------------' . PHP_EOL;
            echo $output;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
