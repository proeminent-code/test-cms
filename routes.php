<?php


// Home page
$router->get('/', 'HomeController@index');


// 404 page
$router->get('/404', 'NotFoundController@index');


// Products page
// $router->get('/products', 'ProductsController@index');


// View product page
$router->get('/products/:name/:id', 'ProductsController@product');

// More pages..


?>