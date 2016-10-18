#!/usr/bin/env php
<?php

require_once __DIR__. '/vendor/autoload.php';

define('BASE_APP', __DIR__);

use Symfony\Component\Console\Application;
use Modalnetworks\EsModal\Console\CoreKernel;

$mapping = require_once BASE_APP .'/config/elasticmapping.php';
$config = require_once BASE_APP .'/config/esabcd.php';

\Modalnetworks\EsModal\Config::set('esabcd', $config);
\Modalnetworks\EsModal\Config::set('elasticmapping', $mapping);


$application = new Application();

//register consoles
$application->add((new Modalnetworks\EsModal\Console\AbcdSyncToEsCommand));
$application->add((new Modalnetworks\EsModal\Console\IndicesOperatingCommand));

$application->run();
