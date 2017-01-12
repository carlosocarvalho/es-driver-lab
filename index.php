<?php 

require_once __DIR__. '/vendor/autoload.php';

define('BASE_APP', __DIR__);



use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Modalnetworks\EsModal\Repositories\DiscoveryRepository;

$mapping = require_once BASE_APP .'/config/elasticmapping.php';
$config = require_once BASE_APP .'/config/esabcd.php';

Modalnetworks\EsModal\Config::set('esabcd', $config);
Modalnetworks\EsModal\Config::set('elasticmapping', $mapping);

$app = new Silex\Application;
$app['debug'] = true;
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/app/views',
));


$app->get('/',function(Request $request)use($app){
    
       
      return $app['twig']->render('home.twig', ['q'=>'']);
       /*
        $search = new DiscoveryRepository;
        if($request->get('type', false) == 'phrase')
            $search->isPhrase();
                  
         
    return  $app->json( $search->setLimit($request->get('limit', null))->setRelevance($request->get('relevance', null))->setCurrentPage($request->get('cursor',1))->search( $request->get('q', ''))->hits());
    */
});

$app->get('search',function(Request $request)use($app){
    
       
        $search = new DiscoveryRepository;
        //$search->setOrderBy('245A','asc');
        //$search->setOrderBy('777','desc');
         

        
        if($request->get('typeSearch', false) == 'phrase')
            $search->isPhrase();

        if($request->get('label', '_all') !== '_all'){
             $field = $request->get('label');            
             $search->byFields([$field]);
        }
                  
       $search->setTransformer( new Modalnetworks\EsModal\Transformers\EsBaseTransformer() );
         
    $data =  $search->setLimit($request->get('limit', null))
                    ->setRelevance($request->get('relevance', null))
                    ->setCurrentPage($request->get('cursor', 1))
                    ->search( $request->get('q', ''))
                    ->hits();
     

     dump($search->lastParams());
    $patternUri = preg_replace('#(\&cursor=[0-9]{1,})+#','',$request->getRequestUri());
    //$data['paginator']->setUrlPattern($patternUri);
    //dump($data['paginator']);  
    

    $data['currentUri'] = $patternUri;

    
    return $app['twig']->render('search.twig', ['data'=> $data, 'q'=> $request->get('q')]);
});



$app->run();

/*
//$search =  $es->get(['id'=>'AVekoRE_0dpvymz71M8t','index'=>'discovery','type'=>'movies']);

//$search = $es->byField();

$s = isset($_GET['q']) ? $_GET['q'] : '*';

$cursor = isset($_GET['cursor']) ? $_GET['cursor'] : 1;
$limit = isset($_GET['limit']) ? $_GET['limit'] : null;

$data  = $search->setLimit($limit)->setCurrentPage($cursor)->search( $s )->hits();

header('content-type:text/json;charset=utf-8');

echo json_encode($data);*/