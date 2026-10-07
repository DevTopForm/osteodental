<?php
    chdir(dirname(dirname(__FILE__)));

    set_include_path(realpath('data/lib') . PATH_SEPARATOR . get_include_path());

    include('data/init.php');

    $price = new Item_Price();
    $price->downloadPrice(Query::$get['node_id']);

?>