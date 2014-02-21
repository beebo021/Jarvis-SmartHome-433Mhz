<?php
require_once 'Class/Mysql.php';
require_once 'Things/ThingController.php';

require_once 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->get('/', function () 
{    
    echo "OK";
});

$app->get('/things/updated', function () use ($app) 
{	
	$response = array();
	
	$controller = new ThingController();
	
	$updatedAt = $app->request->get('updatedAt');

	$result = $controller->thingsUpdated($updatedAt);
	
	foreach ($result as &$thing) 
	{
    	$response[] = $thing->description();
	}
	
	$return = array();
	$return["response"] = $response;
	$json = json_encode($return);
	
	$app->response->setStatus(200);
	$app->response->headers->set('Content-Type', 'application/json');
	$app->response->setBody($json);});

$app->get('/things/parent/:cod_area', function ($cod_area) use ($app) 
{	
	$response = array();
	
	$controller = new ThingController();
	
	$result = $controller->thingsWithParent($cod_area);
	
	foreach ($result as &$thing) 
	{
    	$response[] = $thing->description();
	}
	
	$return = array();
	$return["response"] = $response;
	$json = json_encode($return);
	
	$app->response->setStatus(200);
	$app->response->headers->set('Content-Type', 'application/json');
	$app->response->setBody($json);
});

$app->post('/things/:cod_thing/cmds/:cmd', function ($cod_thing, $cmd) use ($app) 
{	
	$r = array();
	
	$controller = new ThingController();
	$thing = $controller->thingWithCod($cod_thing);

	$thing->addCmd(0, $cmd, 0);
	
	usleep(500000);
	
	$thing2 = $controller->thingWithCod($cod_thing);
	
	$r["response"] = $thing2->description();
	
	$json = json_encode($r);
	
	$app->response->setStatus(200);
	$app->response->headers->set('Content-Type', 'application/json');
	$app->response->setBody($json);
});

$app->get('/things/:cod_thing/cmds/:cmd', function ($cod_thing, $cmd) use ($app) 
{	
	$r = array();
	
	$controller = new ThingController();
	$thing = $controller->thingWithCod($cod_thing);

	$thing->addCmd(0, $cmd, 0);
	
	usleep(500000);
	
	$thing2 = $controller->thingWithCod($cod_thing);
	
	$r["response"] = $thing2->description();
	
	$json = json_encode($r);
	
	$app->response->setStatus(200);
	$app->response->headers->set('Content-Type', 'application/json');
	$app->response->setBody($json);
});

$app->get('/things/:cod_thing', function ($cod_thing) use ($app) 
{	
	$r = array();
	
	$controller = new ThingController();
	$thing = $controller->thingWithCod($cod_thing);

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

$app->post('/things/:cod_thing/update', function ($cod_thing) use ($app) 
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

$app->get('/things/:cod_thing/rules/timely', function ($cod_thing) use ($app) 
{	
	$r = array();
	
	$controller = new ThingController();
	$thing = $controller->thingWithCod($cod_thing);
	
	$result = $thing->getRules(1); //1 = Timely
	
	foreach ($result as &$rule) 
	{
    	$r["response"][] = $rule->description();
	}
	
	$json = json_encode($r);
	
	$app->response->setStatus(200);
	$app->response->headers->set('Content-Type', 'application/json');
	$app->response->setBody($json);
});


$app->get('/things/:cod_thing/rules/notimely', function ($cod_thing) use ($app) 
{	
	$r = array();
	
	$controller = new ThingController();
	$thing = $controller->thingWithCod($cod_thing);
	
	$result = $thing->getRules(0); //0 = NO Timely
	
	foreach ($result as &$rule) 
	{
    	$r["response"][] = $rule->description();
	}
	
	$json = json_encode($r);
	
	$app->response->setStatus(200);
	$app->response->headers->set('Content-Type', 'application/json');
	$app->response->setBody($json);
});

$app->get('/things/:cod_thing/rules/timely/new', function ($cod_thing) use ($app) 
{	
	
});

$app->get('/things/:cod_thing/rules/timely/update', function ($cod_thing) use ($app) 
{	
	
});

$app->get('/things/:cod_thing/rules/timely/delete', function ($cod_thing) use ($app) 
{	
	
});

$app->get('/things/:cod_thing/rules/notimely/new', function ($cod_thing) use ($app) 
{	
	
});

$app->get('/things/:cod_thing/rules/notimely/update', function ($cod_thing) use ($app) 
{	
	
});

$app->get('/things/:cod_thing/rules/notimely/delete', function ($cod_thing) use ($app) 
{	
	
});

$app->run();
?>