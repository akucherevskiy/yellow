<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once 'bootstrap.php';
require_once 'admin.php';
use Doctrine\DBAL\Connection;
$app->get('/', function () use ($app){
	return $app['twig']->render('index.twig', array(
	));
})
	->bind('main');

$app->get('/about', function () use ($app){
	$sql = "SELECT * FROM data WHERE alias IN ('about_1', 'about_2')";
	$data = $app['db']->fetchAll($sql);

	$sql = "SELECT * FROM img WHERE alias IN ('c1')";
	$datac1 = $app['db']->fetchAll($sql);

	$sql = "SELECT * FROM img WHERE alias IN ('c2')";
	$datac2 = $app['db']->fetchAll($sql);

	$sql = "SELECT * FROM img WHERE alias IN ('c3')";
	$datac3 = $app['db']->fetchAll($sql);

	$returnArray = array(
		'about_1'=> $data[0]['data'],
		'about_2'=> $data[1]['data'],
		'c1'=> $datac1,
		'c2'=> $datac2,
		'c3'=> $datac3,
	);

	return $app['twig']->render('about.twig', $returnArray);
})
	->bind('about');

$app->get('/coworking', function () use ($app){
	$sql = "SELECT * FROM data left JOIN img on img.user_id = data.id where img.alias='coworking' order by data.id limit 8";
	$dataimg = $app['db']->fetchAll($sql);
	return $app['twig']->render('coworking.twig', ['data' => $dataimg]);
})
	->bind('coworking');

$app->get('/lectorium', function () use ($app){
	$sql = "SELECT * FROM data left JOIN img on img.user_id = data.id where img.alias='lectorium' and type is null order by data.timestamp, type limit 4";
	$dataimg = $app['db']->fetchAll($sql);

	$calendar = [
		1 => 'January',
		2 => 'February',
		3 => 'March',
		4 => 'April',
		5 => 'May',
		6 => 'June',
		7 => 'Jule',
		8 => 'August',
		9 => 'September',
		10 => 'October',
		11 => 'November',
		12 => 'December',
	];
	$sql = "SELECT * FROM data WHERE alias IN ('lectorium_1')";
	$datac1 = $app['db']->fetchAll($sql);
	$res = [];
	foreach($dataimg as $item){
		$newQql = "SELECT * FROM img where img.alias='lectorium' and user_id = ". $item["user_id"]. "  and type = 1";
		$dataimgNew = $app['db']->fetchAll($newQql);
		$item['month'] = $calendar[$item['month']];
		$item['bigSrc'] = $dataimgNew[0]['dest'];
		$res [] = $item;
	}
	return $app['twig']->render('lectorium.twig', ['data' => $res, 'info' => $datac1[0]['data']]);
})
	->bind('lectorium');

$app->get('/shop', function () use ($app){
	$sql = "SELECT *, products.ids as ids FROM products left JOIN img on img.user_id = products.id where img.alias='shop' and products.is_concept = 0 and products.type = 1 order by products.id";
	$dataimg = $app['db']->fetchAll($sql);
	$data['chairs'] = $dataimg;

	$sql = "SELECT * FROM products.id as ids, * left JOIN img on img.user_id = products.id where img.alias='shop' and products.is_concept = 0 and products.type = 2 order by products.id";
	$dataimg = $app['db']->fetchAll($sql);
	$data['lighting'] = $dataimg;

	$sql = "SELECT * FROM products.id as ids, * left JOIN img on img.user_id = products.id where img.alias='shop' and products.is_concept = 0  and products.type = 3 order by products.id";
	$dataimg = $app['db']->fetchAll($sql);
	$data['bench'] = $dataimg;

	$sql = "SELECT * FROM products.id as ids, * left JOIN img on img.user_id = products.id where img.alias='shop' and products.is_concept = 0  and products.type = 4 order by products.id";
	$dataimg = $app['db']->fetchAll($sql);
	$data['storage'] = $dataimg;

	$sql = "SELECT * FROM products.id as ids, * left JOIN img on img.user_id = products.id where img.alias='shop' and products.is_popular = 1 and products.is_concept = 0";
	$popular = $app['db']->fetchAll($sql);

	return $app['twig']->render('shop.twig', ['data' => $data, 'popular'=> $popular]);
})->bind('shop');


$app->get('/product/{id}', function ($id) use ($app){
	$sql = "SELECT * FROM products left JOIN img on img.user_id = products.id where img.alias='shop' and products.id=". $id;
	$dataimg = $app['db']->fetchAll($sql);

	return $app['twig']->render('product.twig', ['data'=>$dataimg]);
})
	->bind('product');

$app->get('/concept', function () use ($app){
	$sql = "SELECT * FROM products left JOIN img on img.user_id = products.id where img.alias='shop' and products.is_concept = 1 order by products.id";
	$dataimg = $app['db']->fetchAll($sql);
var_dump($dataimg); die;
	return $app['twig']->render('concept.twig', ['data'=>$dataimg]);
})
	->bind('concept');

$app->get('/contacts', function () use ($app){
	return $app['twig']->render('contacts.twig', array(
	));
})
	->bind('contacts');

$app->run();
