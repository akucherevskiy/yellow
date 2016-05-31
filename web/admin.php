<?php

$app->get('/admin/', function () use ($app){
    return $app['twig']->render('admin/main.twig', array());
})
->bind('admin');

$app->post('/admin/edit', function () use ($app){
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

$app->post('/admin/add/', function () use ($app){
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

$app->post('/admin/img/add/', function () use ($app){
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

$app->get('/admin/img/delete/{id}', function ($id) use ($app){
    $sql = "select * from img where id=".$id;
    $data = $app['db']->fetchAll($sql);
    unlink(substr($data[0]['dest'], 3));
    $sql = "delete from img where id=".$id;
    $app['db']->executeQuery($sql);

    return $app['twig']->render('admin/main.twig', array());
})
    ->bind('admin_img_delete');

//===============================================

$app->get('/admin/about/', function () use ($app){
    $sql = "SELECT * FROM data WHERE alias IN ('about_1', 'about_2')";
    $data = $app['db']->fetchAll($sql);
    $returnArray = array(
        'about_1'=> $data[0]['data'],
        'about_2'=> $data[1]['data'],
    );
    return $app['twig']->render('admin/about.twig', $returnArray);
})
->bind('admin_about');

$app->get('/admin/about/{id}', function ($id) use ($app){
    $sql = "SELECT * FROM data WHERE id = " . $id;
    $data = $app['db']->fetchAll($sql);
    $returnArray = array(
        'item' => $data[0]['data'],
        'id' => $id,
    );
    return $app['twig']->render('admin/about_item.twig', $returnArray);
});

$app->get('/admin/about_img/{alias}', function ($alias) use ($app){
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

$app->get('/admin/about_add/{id}', function ($id) use ($app){
    return $app['twig']->render('admin/about_add.twig', ['alias'=>$id]);
})
    ->bind('admin_about_add');

//===============================================

$app->get('/admin/coworking/', function () use ($app){
    $sql = "SELECT * FROM data WHERE alias IN ('coworking_1')";
    $data = $app['db']->fetchAll($sql);

    return $app['twig']->render('admin/coworking.twig', ['data' =>$data]);
})
->bind('admin_coworking');

$app->get('/admin/coworking/{id}', function ($id) use ($app){
    $sql = "SELECT * FROM data WHERE id = " . $id;
    $data = $app['db']->fetchAll($sql);
    $returnArray = array(
        'item' => $data[0]['data'],
        'id' => $id,
    );
    return $app['twig']->render('admin/coworking_item.twig', $returnArray);
});

$app->get('/admin/coworking_edit/{id}', function ($id) use ($app){
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

$app->get('/admin/coworking_add/{id}', function ($id) use ($app){
    return $app['twig']->render('admin/coworking_add.twig', array());
})
    ->bind('admin_coworking_add');

$app->post('/admin/coworking/img/add/', function () use ($app){

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

$app->post('/admin/lectorium/img/add/', function () use ($app){

    $uploaddir = __DIR__.'/src/img/lectorium/imgs/';
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
    $uploadfilesql = '../src/img/lectorium/imgs/' . basename($_FILES['userfile']['name']);
    $newImg = (bool)move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);

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

    $sql = "Update  data set name= ?, data = ?, day=?, month=?, timestamp = ? where id = $user_id";
    $app['db']->executeQuery($sql, array($name, $data, $day, $month, $time));

    return $app['twig']->render('admin/main.twig', array());
})
    ->bind('admin_lectorium_img_add');

$app->get('/admin/lectorium/', function () use ($app){
    $sql = "SELECT * FROM data WHERE alias IN ('lectorium_1', 'lectorium') order by timestamp ";
    $data = $app['db']->fetchAll($sql);

    return $app['twig']->render('admin/lectorium.twig', ['data' =>$data]);
})
->bind('admin_lectorium');

$app->get('/admin/lectorium/delete/{id}', function ($id) use ($app){
    $sql = "delete FROM data WHERE id = ". $id;
    $app['db']->executeQuery($sql);

    $sql = "delete from img WHERE user_id = ". $id;
    $app['db']->executeQuery($sql);

    return $app['twig']->render('admin/main.twig');
})
->bind('admin_lectorium_delete');

$app->get('/admin/lectorium_edit/{id}', function ($id) use ($app){
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

$app->get('/admin/lectorium_add/', function () use ($app){
    return $app['twig']->render('admin/lectorium_add.twig');
})
    ->bind('admin_lectorium_add');

$app->get('/admin/lectorium/{id}', function ($id) use ($app){
    $sql = "SELECT * FROM data WHERE id = " . $id;
    $data = $app['db']->fetchAll($sql);
    $returnArray = array(
        'item' => $data[0]['data'],
        'id' => $id,
    );
    return $app['twig']->render('admin/lectorium_item.twig', $returnArray);
});

//===============================================

$app->get('/admin/shop', function () use ($app){
    $sql = "SELECT * FROM products";
    $data = $app['db']->fetchAll($sql);

    return $app['twig']->render('admin/shop.twig', ['data' =>$data]);
})->bind('admin_shop');

$app->get('/admin/shop/addform/', function () use ($app){
    return $app['twig']->render('admin/shop_add_form.twig', array());
})->bind('admin_shop_add_form');

$app->post('/admin/shop/add/', function () use ($app){
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

$app->get('/admin/shop/edit/{id}', function ($id) use ($app){
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

$app->get('/admin/shop/delete/{id}', function ($id) use ($app){
    $sql = "delete from img where user_id = " . $id;
    $app['db']->executeQuery($sql);

    $sql = "delete from products where id = " . $id;
    $app['db']->executeQuery($sql);
    return $app['twig']->render('admin/main.twig', array());
})->bind('admin_shop_delete');


$app->post('/admin/shop/img/add/', function () use ($app){

    $uploaddir = __DIR__.'/src/img/shop/imgs/';
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
    $uploadfilesql = '../src/img/shop/imgs/' . basename($_FILES['userfile']['name']);
    $newImg = (bool)move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
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

    if ($_FILES['userfile']['size'] > 0) {
        $sql = "delete from img where user_id = " . $id;
        $app['db']->executeQuery($sql);
    }

    if ($newImg) {
        $sql = "INSERT INTO img (alias, name, dest, user_id) values (?,?,?,?)";
        $app['db']->executeQuery($sql, array('shop', $name, $uploadfilesql, $id));
    }

    return $app['twig']->render('admin/main.twig', array());
})
    ->bind('admin_shop_img_add');
//===============================================


$app->get('/admin/concept', function () use ($app){
    return $app['twig']->render('admin/concept.twig', array());
})
->bind('admin_concept');

$app->get('/admin/contacts', function () use ($app){
    return $app['twig']->render('admin/contacts.twig', array());
})
->bind('admin_contacts');