<?php namespace Laravel\Homestead;

use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpCommand extends Command {

	/**
	 * Configure the command options.
	 *
	 * @return void
	 */
	protected function configure()
	{
		$this->setName('up')
                  ->setDescription('Start the Homestead machine');
	}

	/**
	 * Execute the command.
	 *
	 * @param  \Symfony\Component\Console\Input\InputInterface  $input
	 * @param  \Symfony\Component\Console\Output\OutputInterface  $output
	 * @return void
	 */
	public function execute(InputInterface $input, OutputInterface $output)
	{
		$command = 'vagrant up';
		
		if($this->option('provision'))
			$command .= ' --provision';
			
		$process = new Process($command, realpath(__DIR__.'/../'), null, null, null);

		$process->run(function($type, $line) use ($output)
		{
			$output->write($line);
		});
	}
	
	/**
	 * Get the console command options.
	 * 
	 * @return array
	 */
	public function getOptions()
	{
		return array(
			array('provision', null, InputOption::VALUE_NONE, 'Provision the Homestead machine.', false),	
		);
	}

}
