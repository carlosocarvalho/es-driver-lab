<?php 

//console
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
use Monolog\Logger;
use Monolog\Handler\StreamHandler;




class AbcdSyncToEsCommand  extends Command{
    

    protected $io;

    protected $es;

    protected $logger;

    protected function configure()
    {   
          $this
              ->setName('abcd:restore')
              ->setDescription('Re-import all registers for elastic search')
              ->addOption(
                  'reset',
                  'e',
                  InputOption::VALUE_OPTIONAL,
                  'force reset all data',
                  false
              )
              ->addOption(
                  'no-index',
                  'i',
                  InputOption::VALUE_OPTIONAL,
                  'No force all delete all indices',
                  false
              )
              ->addOption(
                  'no-data',
                  null,
                  InputOption::VALUE_OPTIONAL,
                  'No create data',
                  false
              )
              ->addOption(
                  'path',
                  'p',
                  InputOption::VALUE_OPTIONAL,
                  'Set path files',
                  false
              )
              ->addOption(
                  'filename',
                  'f',
                  InputOption::VALUE_OPTIONAL,
                  'Set file for import',
                  false
              )
              ->addOption(
                  'limit',
                  'l',
                  InputOption::VALUE_OPTIONAL,
                  'Set limt for import bulk data',
                  2000
              )
              
               ->addOption(
                  'yes',
                  'y',
                  InputOption::VALUE_OPTIONAL,
                  'Set yes for restore all databases  use -y true',
                  false
                  
              )
               ;
          
     }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
          $output->writeln('start restore'); 
          
          $io = new SymfonyStyle($input, $output);
          $this->logger =  new Logger('logger_up');
          $this->logger->pushHandler(new StreamHandler( BASE_APP .'/logs/es/'.date('Y-m-d').'_notice.log', logger::NOTICE ) );
          $this->logger->pushHandler(new StreamHandler( BASE_APP .'/logs/es/'.date('Y-m-d').'_critical.log', logger::CRITICAL ));
          //$this->logger->pushHandler(new StreamHandler( BASE_APP .'/logs/es/'.date('Y-m-d').'_error.log', logger::ERROR ));
          //$this->logger->pushHandler(new StreamHandler( BASE_APP .'/logs/es/'.date('Y-m-d').'_info.log', logger::INFO ));
          $this->es = new \Modalnetworks\EsModal\ElasticRestore($this->logger);

         
          $forceDelete = (bool) $input->getOption('reset');
          $createIndex = (bool) !$input->getOption('no-index');

          $limit = $input->getOption('limit');


          $filename = $input->getOption('filename');

          $path = $input->getOption('path') ? $input->getOption('path') : BASE_APP ;
          $climate = new \League\CLImate\CLImate;  
          $this->createAllIndices($forceDelete, $createIndex, $io, $input );
          
          $restore = $this->es; 
          //running each data for file
          $i = 0; 
          $output->writeln('Filename read ' . $filename); 
          dump( $filename );
          $this->logger->addNotice('Stared up ' . $filename);
         
          if( ! $input->getOption('no-data')){

              $params = ['body' => []];
                    $this->es->execute( $path , $filename, function($row) use ($output , &$restore, $climate, &$i, & $params, $limit) {
                           
                            if(!$row) return;
                           
                            $data = $row->toArray();
                            
                            if( $this->validateArgumentsFor($data)  ) {
                               $params['body'][] = [
                                   'index' => [
                                       '_index' => $data['index'],
                                       '_type' => $data['type'],
                                   ]
                               ];
                               $params['body'][] = $data['body'];
                               if ($i > 0 && $i % $limit == 0) {
                                    dump($i);
                                   $responses = $restore->bulk($params);
                                   $params = ['body' => []];
                                   unset($responses);

                               }
                               $i+=1;
                           }

                        });
            }
            $this->logger->addNotice('Finish up ' . $filename);
             if(count($params ['body']) > 0){
                 dump($i);
                 $restore->bulk($params);
             }
            $output->writeln('finish');  
           
                    
    }


    private function createAllIndices( $forceDelete , $createIndex, $io, $input){
                 
                 $yes = (bool) $input->getOption('yes');

                if ( $yes  )
                {
                      if($createIndex && $forceDelete )
                              $this->es->createIndex( $forceDelete );
                      if ($createIndex && ! $forceDelete )
                              $this->es->createIndex( $forceDelete );        
                    return;
                }

            if( $createIndex !== false){
                 if($forceDelete !== false){
                     
                    if($io->confirm('Deseja apagar todos os dados ?')){
                        $this->es->createIndex( $forceDelete );
                        $io->success('indices recreating');
                    }
                 }
                if(!$forceDelete){
                      $this->es->createIndex();
                      $io->success('Creating new indices');
                }
                   
                 
                 
            }     

    }


    private function validateArgumentsFor($row){
        
        $data = $row;

        if(!isset($data['index']) OR  !$data['index']  OR empty($data['index']) ) {
             $this->logger->addCritical('not argument index', $data);
             return false;
        }

        if(!isset($data['body']) OR  !$data['body'] OR empty($data['body'])  OR is_null(extractArgument($data,'body') )  ) {
            //$this->logger->addError('not argument body', $data); 
             return false;
        }



        return true;     

    }

}