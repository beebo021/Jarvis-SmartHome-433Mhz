<?php
require_once 'class/Mysql.php';
require_once 'Things/ThingController.php';
require_once 'Things/Thing.php';

require_once 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->get('/', function () 
{    
    echo "OK";
});

$app->get('/things/parent/:cod_parent', function ($cod_parent) use ($app) 
{	
	$r = array();
	
	$controller = new ThingController();
	
	$result = $controller->thingsWithParent($cod_parent);
	
	foreach ($result as &$thing) 
	{
    	$r["response"][] = $thing->description();
	}
	
	$json = json_encode($r);
	
	
	$app->response->setStatus(200);
	$app->response->headers->set('Content-Type', 'application/json');
	$app->response->setBody($json);

});

$app->post('/things/:cod_thing/cmds/:cmd', function ($cod_thing, $cmd) use ($app) 
{	
	$r = array();
	
	$controller = new ThingController();
	$thing = $controller->thingWithCod($cod_thing);

	$thing->sendCmd($cmd, 0);
	
	$r["response"] = $thing->description();
	
	$json = json_encode($r);
	
	$app->response->setStatus(200);
	$app->response->headers->set('Content-Type', 'application/json');
	$app->response->setBody($json);
});

$app->post('/things/:kind/new', function ($kind) use ($app) 
{	
	$r = array();
	
	$controller = new ThingController();
	$thing = $controller->newThingWithKind($kind);

	$r["response"] = $thing->description();
	
	$json = json_encode($r);
	
	$app->response->setStatus(200);
	$app->response->headers->set('Content-Type', 'application/json');
	$app->response->setBody($json);
	
});

$app->post('/things/update/:cod_thing', function ($cod_thing) use ($app) 
{	
	$r = array();
	
	$controller = new ThingController();
	$thing = $controller->thingWithCod($cod_thing);
	
	$thing->updateWithPost();
	$thing->save();

	$r["response"] = $thing->description();
	
	$json = json_encode($r);
	
	$app->response->setStatus(200);
	$app->response->headers->set('Content-Type', 'application/json');
	$app->response->setBody($json);
	
});

$app->post('/things/:cod_thing/delete', function ($cod_thing) use ($app) 
{	
	$r = array();
	
	$controller = new ThingController();
	$thing = $controller->deleteThingWithCod($cod_thing);
	
	$r["response"] = "Deleted";
	
	$json = json_encode($r);
	
	$app->response->setStatus(200);
	$app->response->headers->set('Content-Type', 'application/json');
	$app->response->setBody($json);
	
});

$app->run();
?>