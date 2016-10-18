<?php 

namespace Modalnetworks\EsModal\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Style\SymfonyStyle;


class IndicesOperatingCommand  extends Command{
    

    protected $io;

    protected $es;

    protected function configure()
    {   
          $this
              ->setName('index:op')
              ->setDescription('Operating in index')
              ->addOption(
                  'remap',
                  'rmp',
                  InputOption::VALUE_OPTIONAL,
                  'Remap all index',
                  false
              )
              
               ;
          
     }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
          $output->writeln('start index operating'); 
          $io = new SymfonyStyle($input, $output);
          $this->es = new \Modalnetworks\EsModal\ElasticRestore();
          $remap = (bool) $input->getOption('remap');

          if($remap)
             $this->es->remapIndex();
          
          $output->writeln('finish');  
           
                    
    }


   

}