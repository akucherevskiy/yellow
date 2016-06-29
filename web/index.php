<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once 'bootstrap.php';
//require_once 'admin.php';
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
	$sql = "SELECT *, products.id as ids, products.name as sname FROM products left JOIN img on img.user_id = products.id where img.alias='shop' and products.is_concept = 0 and products.type = 1 and img.type = 1 order by products.id";
	$dataimg = $app['db']->fetchAll($sql);
	$data['chairs'] = $dataimg;

	$sql = "SELECT *, products.id as ids, products.name as sname FROM products  left JOIN img on img.user_id = products.id where img.alias='shop' and products.is_concept = 0 and products.type = 2 and img.type = 1  order by products.id";
	$dataimg = $app['db']->fetchAll($sql);
	$data['lighting'] = $dataimg;

	$sql = "SELECT *, products.id as ids, products.name as sname FROM products  left JOIN img on img.user_id = products.id where img.alias='shop' and products.is_concept = 0  and products.type = 3 and img.type = 1 order by products.id";
	$dataimg = $app['db']->fetchAll($sql);
	$data['bench'] = $dataimg;

	$sql = "SELECT *, products.id as ids, products.name as sname FROM products  left JOIN img on img.user_id = products.id where img.alias='shop' and products.is_concept = 0  and products.type = 4 and img.type = 1 order by products.id";
	$dataimg = $app['db']->fetchAll($sql);
	$data['storage'] = $dataimg;

	$sql = "SELECT *, products.id as ids, products.name as sname FROM products  JOIN img on img.user_id = products.id where img.alias='shop' and products.is_popular = 1 and products.is_concept = 0  and img.type = 1 ";
	$popular = $app['db']->fetchAll($sql);

	return $app['twig']->render('shop.twig', ['data' => $data, 'popular'=> $popular]);
})->bind('shop');


$app->get('/product/{id}', function ($id) use ($app){
	$sql = "SELECT *,products.name as sname FROM products left JOIN img on img.user_id = products.id where img.alias='shop' and products.id=". $id;
	$dataimg = $app['db']->fetchAll($sql);

	$sql = "SELECT *, products.id as ids, products.name as sname FROM products  left JOIN img on img.user_id = products.id where img.alias='shop' and products.is_concept = 0  and img.type = 1 and products.type = " . $dataimg[0]['type']. " order by products.id";
	$also = $app['db']->fetchAll($sql);

	return $app['twig']->render('product.twig', ['data'=>$dataimg, 'also' => $also]);
})
	->bind('product');

$app->get('/concept', function () use ($app){
	$sql = "SELECT *, products.id as ids, products.name as sname FROM products left JOIN img on img.user_id = products.id where img.alias='shop' and products.is_concept = 1   and products.type = 1 and img.type = 1 order by products.id";
	$dataimg = $app['db']->fetchAll($sql);
	$data['chairs'] = $dataimg;

	$sql = "SELECT *, products.id as ids, products.name as sname FROM products  left JOIN img on img.user_id = products.id where img.alias='shop' and products.is_concept = 1  and products.type = 2 and img.type = 1  order by products.id";
	$dataimg = $app['db']->fetchAll($sql);
	$data['lighting'] = $dataimg;

	$sql = "SELECT *, products.id as ids, products.name as sname FROM products  left JOIN img on img.user_id = products.id where img.alias='shop' and products.is_concept = 1  and products.type = 3  and img.type = 1 order by products.id";
	$dataimg = $app['db']->fetchAll($sql);
	$data['bench'] = $dataimg;

	$sql = "SELECT *, products.id as ids, products.name as sname FROM products  left JOIN img on img.user_id = products.id where img.alias='shop' and products.is_concept = 1  and products.type = 4 and img.type = 1 order by products.id";
	$dataimg = $app['db']->fetchAll($sql);
	$data['storage'] = $dataimg;


	return $app['twig']->render('concept.twig', ['data'=>$data]);
})
	->bind('concept');

$app->get('/contacts', function () use ($app){
	return $app['twig']->render('contacts.twig', array());
})
	->bind('contacts');

$app->get('/basket', function () use ($app){
	return $app['twig']->render('basket.twig', array());
})
	->bind('basket');



$app->get('/adm/', function () use ($app){
	return $app['twig']->render('admin/main.twig', array());
})
	->bind('admin');

$app->post('/adm/edit', function () use ($app){
	$data = $_REQUEST['data'] ?:  NULL;
	$name = $_REQUEST['name'] ?: NULL;
	$id = $_REQUEST['id'] ?: NULL;
	if ($data) {
		$sql = "UPDATE data SET data = ?, name=? WHERE id = ?";
		$app['db']->executeUpdate($sql, array($data, $name, $id));
	}
	return $app['twig']->render('admin/main.twig', array());
})
	->bind('admin_edit');

$app->post('/adm/add/', function () use ($app){
	$item = $_REQUEST['item'] ?:  null;
	$name = $_REQUEST['name'] ?: null;
	$date = $_REQUEST['date'] ?: null;
	$month = $_REQUEST['month'] ?: null;
	$id = $_REQUEST['id'] ?: null;
	$time = mktime(0,0,0,(int)$month, (int)$date);
	if ($item) {
		$sql = "INSERT INTO data (alias, name, data, day, month, timestamp) values (?,?,?,?,?,?)";
		$app['db']->executeQuery($sql, array($id, $name, $item, $date, $month, $time));
	}
	return $app['twig']->render('admin/main.twig', array());
})
	->bind('admin_add');

$app->post('/adm/img/add/', function () use ($app){
	$uploaddir = __DIR__.'/src/img/about/imgs/'.$_REQUEST['id'] .'/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	$uploadfilesql = '../../src/img/about/imgs/'.$_REQUEST['id'] .'/' . basename($_FILES['userfile']['name']);
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
	} else {
	}

	$name = $_REQUEST['name'] ?: null;
	$id = $_REQUEST['id'] ?: null;
	$sql = "INSERT INTO img (alias, name, dest) values (?,?,?)";
	$app['db']->executeQuery($sql, array($id, $name, $uploadfilesql));

	return $app['twig']->render('admin/main.twig', array());
})
	->bind('admin_img_add');

$app->get('/adm/img/delete/{id}', function ($id) use ($app){
	$sql = "select * from img where id=".$id;
	$data = $app['db']->fetchAll($sql);
	unlink(substr($data[0]['dest'], 3));
	$sql = "delete from img where id=".$id;
	$app['db']->executeQuery($sql);

	return $app['twig']->render('admin/main.twig', array());
})
	->bind('admin_img_delete');

//===============================================

$app->get('/adm/about/', function () use ($app){
	$sql = "SELECT * FROM data WHERE alias IN ('about_1', 'about_2')";
	$data = $app['db']->fetchAll($sql);
	$returnArray = array(
		'about_1'=> $data[0]['data'],
		'about_2'=> $data[1]['data'],
	);
	return $app['twig']->render('admin/about.twig', $returnArray);
})
	->bind('admin_about');

$app->get('/adm/about/{id}', function ($id) use ($app){
	$sql = "SELECT * FROM data WHERE id = " . $id;
	$data = $app['db']->fetchAll($sql);
	$returnArray = array(
		'item' => $data[0]['data'],
		'id' => $id,
	);
	return $app['twig']->render('admin/about_item.twig', $returnArray);
});

$app->get('/adm/about_img/{alias}', function ($alias) use ($app){
	$sql = "SELECT * FROM img WHERE alias IN ('" . $alias . "')";
	$data = $app['db']->fetchAll($sql);
	$returnArray =
		['data' =>
			['item' => $data,
				'alias' => $alias
			]
		];
	return $app['twig']->render('admin/about_img.twig', $returnArray);
})->bind('admin_img');

$app->get('/adm/about_add/{id}', function ($id) use ($app){
	return $app['twig']->render('admin/about_add.twig', ['alias'=>$id]);
})
	->bind('admin_about_add');

//===============================================

$app->get('/adm/coworking/', function () use ($app){
	$sql = "SELECT * FROM data WHERE alias IN ('coworking_1')";
	$data = $app['db']->fetchAll($sql);

	return $app['twig']->render('admin/coworking.twig', ['data' =>$data]);
})
	->bind('admin_coworking');

$app->get('/adm/coworking/{id}', function ($id) use ($app){
	$sql = "SELECT * FROM data WHERE id = " . $id;
	$data = $app['db']->fetchAll($sql);
	$returnArray = array(
		'item' => $data[0]['data'],
		'id' => $id,
	);
	return $app['twig']->render('admin/coworking_item.twig', $returnArray);
});

$app->get('/adm/coworking_edit/{id}', function ($id) use ($app){
	$sql = "SELECT * FROM data WHERE id = ". $id . "";
	$data = $app['db']->fetchAll($sql);

	$sql = "SELECT * FROM img WHERE user_id = ". $id . "";
	$dataimg = $app['db']->fetchAll($sql);

	$returnArray = array(
		'item' => $data[0]['data'],
		'name' => $data[0]['name'],
		'id' => $id,
		'src' => $dataimg[0]['dest']
	);
	return $app['twig']->render('admin/coworking_edit.twig', $returnArray);
})
	->bind('admin_coworking_edit');

$app->get('/adm/coworking_add/{id}', function ($id) use ($app){
	return $app['twig']->render('admin/coworking_add.twig', array());
})
	->bind('admin_coworking_add');

$app->post('/adm/coworking/img/add/', function () use ($app){

	$uploaddir = __DIR__.'/src/img/coworking/imgs/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	$uploadfilesql = '../src/img/coworking/imgs/' . basename($_FILES['userfile']['name']);
	move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);

	$user_id = $_REQUEST['alias'] ?: null;
	$name = $_REQUEST['name'] ?: null;
	$data = $_REQUEST['data'] ?: null;

	if ($_FILES['userfile']['size'] > 0) {
		$sql = "delete from img where user_id = " . $user_id;
		$app['db']->executeQuery($sql);
	}
	$sql = "INSERT INTO img (alias, name, dest, user_id) values (?,?,?,?)";
	$app['db']->executeQuery($sql, array('coworking', $name, $uploadfilesql, $user_id));

	$sql = "Update  data set name= ?, data = ? where id = $user_id";
	$app['db']->executeQuery($sql, array($name, $data));

	return $app['twig']->render('admin/main.twig', array());
})
	->bind('admin_coworking_img_add');

//===============================================

$app->post('/adm/lectorium/img/add/', function () use ($app){

	$uploaddir = __DIR__.'/src/img/lectorium/imgs/';

	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	$uploadfileBig = $uploaddir . basename($_FILES['userfileBig']['name']);

	$uploadfilesql = '../src/img/lectorium/imgs/' . basename($_FILES['userfile']['name']);
	$uploadfilesqlBig = '../src/img/lectorium/imgs/' . basename($_FILES['userfileBig']['name']);

	$newImg = (bool)move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
	$newImgBig = (bool)move_uploaded_file($_FILES['userfileBig']['tmp_name'], $uploadfileBig);

	$user_id = $_REQUEST['alias'] ?: null;
	$name = $_REQUEST['name'] ?: null;
	$day = $_REQUEST['date'] ?: null;
	$month = $_REQUEST['month'] ?: null;
	$data = $_REQUEST['data'] ?: null;
	$time = mktime(0,0,0,(int)$month, (int)$day);
	if ($_FILES['userfile']['size'] > 0) {
		$sql = "delete from img where user_id = " . $user_id;
		$app['db']->executeQuery($sql);
	}
	if ($newImg) {
		$sql = "INSERT INTO img (alias, name, dest, user_id) values (?,?,?,?)";
		$app['db']->executeQuery($sql, array('lectorium', $name, $uploadfilesql, $user_id));
	}
	if ($newImgBig) {
		$sql = "INSERT INTO img (alias, name, dest, user_id, type) values (?,?,?,?,?)";
		$app['db']->executeQuery($sql, array('lectorium', $name, $uploadfilesqlBig, $user_id, 1));
	}

	$sql = "Update  data set name= ?, data = ?, day=?, month=?, timestamp = ? where id = $user_id";
	$app['db']->executeQuery($sql, array($name, $data, $day, $month, $time));

	return $app['twig']->render('admin/main.twig', array());
})
	->bind('admin_lectorium_img_add');

$app->get('/adm/lectorium/', function () use ($app){
	$sql = "SELECT * FROM data WHERE alias IN ('lectorium_1', 'lectorium') order by timestamp ";
	$data = $app['db']->fetchAll($sql);

	return $app['twig']->render('admin/lectorium.twig', ['data' =>$data]);
})
	->bind('admin_lectorium');

$app->get('/adm/lectorium/delete/{id}', function ($id) use ($app){
	$sql = "delete FROM data WHERE id = ". $id;
	$app['db']->executeQuery($sql);

	$sql = "delete from img WHERE user_id = ". $id;
	$app['db']->executeQuery($sql);

	return $app['twig']->render('admin/main.twig');
})
	->bind('admin_lectorium_delete');

$app->get('/adm/lectorium_edit/{id}', function ($id) use ($app){
	$sql = "SELECT * FROM data WHERE id = ". $id;
	$data = $app['db']->fetchAll($sql);

	$sql = "SELECT * FROM img WHERE user_id = ". $id;
	$dataimg = $app['db']->fetchAll($sql);

	$returnArray = array(
		'item' => $data[0]['data'],
		'day' => $data[0]['day'],
		'month' => $data[0]['month'],
		'name' => $data[0]['name'],
		'id' => $id,
		'src' => $dataimg[0]['dest']
	);
	return $app['twig']->render('admin/lectorium_edit.twig', $returnArray);
})
	->bind('admin_lectorium_edit');

$app->get('/adm/lectorium_add/', function () use ($app){
	return $app['twig']->render('admin/lectorium_add.twig');
})
	->bind('admin_lectorium_add');

$app->get('/adm/lectorium/{id}', function ($id) use ($app){
	$sql = "SELECT * FROM data WHERE id = " . $id;
	$data = $app['db']->fetchAll($sql);
	$returnArray = array(
		'item' => $data[0]['data'],
		'id' => $id,
	);
	return $app['twig']->render('admin/lectorium_item.twig', $returnArray);
});

//===============================================

$app->get('/adm/shop', function () use ($app){
	$sql = "SELECT * FROM products";
	$data = $app['db']->fetchAll($sql);

	return $app['twig']->render('admin/shop.twig', ['data' =>$data]);
})->bind('admin_shop');

$app->get('/adm/shop/addform/', function () use ($app){
	return $app['twig']->render('admin/shop_add_form.twig', array());
})->bind('admin_shop_add_form');

$app->post('/adm/shop/add/', function () use ($app){
	$name = $_REQUEST['name'] ?: null;
	$price = $_REQUEST['price'] ?: null;
	$is3d = $_REQUEST['is3d'] == 'on' ? 1: 0;
	$is_popular = $_REQUEST['is_popular'] == 'on' ? 1: 0;
	$is_concept = $_REQUEST['is_concept'] == 'on' ? 1: 0;
	$type = $_REQUEST['type'] ?: null;
	$desc = $_REQUEST['descr'] ?: null;
	$year = $_REQUEST['year'] ?: null ;

	$sql = "INSERT INTO products (name, price, descr, is3d, is_popular, type, year,is_concept) values (?,?,?,?,?,?,?,?)";
	$app['db']->executeQuery($sql, array($name, $price,  $desc, $is3d, $is_popular, $type, $year,$is_concept));

	return $app['twig']->render('admin/main.twig', array());
})->bind('admin_shop_add');

$app->get('/adm/shop/edit/{id}', function ($id) use ($app){
	$sql = "SELECT * FROM products WHERE id = ". $id;
	$data = $app['db']->fetchAll($sql);

	$sql = "SELECT * FROM img WHERE user_id = ". $id;
	$dataimg = $app['db']->fetchAll($sql);

	$returnArray = array(
		'name' => $data[0]['name'],
		'price' => $data[0]['price'],
		'is3d' => $data[0]['is3d'],
		'descr' => $data[0]['descr'],
		'type' => $data[0]['type'],
		'year' => $data[0]['year'],
		'is_popular' => $data[0]['is_popular'],
		'is_concept' => $data[0]['is_concept'],
		'id' => $id,
		'src' => $dataimg[0]['dest']
	);

	return $app['twig']->render('admin/shop_edit.twig', $returnArray);
})->bind('admin_shop_edit');

$app->get('/adm/shop/delete/{id}', function ($id) use ($app){
	$sql = "delete from img where user_id = " . $id;
	$app['db']->executeQuery($sql);

	$sql = "delete from products where id = " . $id;
	$app['db']->executeQuery($sql);
	return $app['twig']->render('admin/main.twig', array());
})->bind('admin_shop_delete');


$app->post('/adm/shop/img/add/', function () use ($app){

	$uploaddir = __DIR__.'/src/img/shop/imgs/';

	$uploadfile1 = $uploaddir . basename($_FILES['userfile1']['name']);
	$uploadfilesql1 = '../src/img/shop/imgs/' . basename($_FILES['userfile1']['name']);
	$newImg1 = (bool)move_uploaded_file($_FILES['userfile1']['tmp_name'], $uploadfile1);

	$uploadfile2 = $uploaddir . basename($_FILES['userfile2']['name']);
	$uploadfilesql2 = '../src/img/shop/imgs/' . basename($_FILES['userfile2']['name']);
	$newImg2 = (bool)move_uploaded_file($_FILES['userfile2']['tmp_name'], $uploadfile2);

	$uploadfile3 = $uploaddir . basename($_FILES['userfile3']['name']);
	$uploadfilesql3 = '../src/img/shop/imgs/' . basename($_FILES['userfile3']['name']);
	$newImg3 = (bool)move_uploaded_file($_FILES['userfile3']['tmp_name'], $uploadfile3);

	$id = $_REQUEST['id'] ?: null;

	$name = $_REQUEST['name'] ?: null;
	$price = $_REQUEST['price'] ?: null;
	$is3d = $_REQUEST['is3d'] == 'on' ? 1: 0;
	$is_popular = $_REQUEST['is_popular'] == 'on' ? 1: 0;
	$is_concept = $_REQUEST['is_concept'] == 'on' ? 1: 0;
	$type = $_REQUEST['type'] ?: null;
	$desc = $_REQUEST['descr'] ?: null;
	$year = $_REQUEST['year'] ?: null ;

	$sql = "UPDATE products set name =?, price=?, descr=?, is3d=?, is_popular=?, type=?, year=?, is_concept=? where id =" . $id;
	$app['db']->executeQuery($sql, array($name, $price,  $desc, $is3d, $is_popular, $type, $year,$is_concept));

	if ($_FILES['userfile1']['size'] > 0) {
		$sql = "delete from img where user_id = " . $id;
		$app['db']->executeQuery($sql);
	}

	if ($newImg1) {
		$sql = "INSERT INTO img (alias, name, dest, user_id, type) values (?,?,?,?,?)";
		$app['db']->executeQuery($sql, array('shop', $name, $uploadfilesql1, $id,1));
	}
	if ($newImg2) {
		$sql = "INSERT INTO img (alias, name, dest, user_id) values (?,?,?,?)";
		$app['db']->executeQuery($sql, array('shop', $name, $uploadfilesql2, $id));
	}
	if ($newImg3) {
		$sql = "INSERT INTO img (alias, name, dest, user_id) values (?,?,?,?)";
		$app['db']->executeQuery($sql, array('shop', $name, $uploadfilesql3, $id));
	}

	return $app['twig']->render('admin/main.twig', array());
})
	->bind('admin_shop_img_add');
//===============================================


$app->get('/adm/concept', function () use ($app){
	return $app['twig']->render('admin/concept.twig', array());
})
	->bind('admin_concept');

$app->get('/adm/contacts', function () use ($app){
	return $app['twig']->render('admin/contacts.twig', array());
})
	->bind('admin_contacts');

$app->run();
