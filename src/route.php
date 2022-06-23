<?php

use Dima\Guestbook\Controller\AddController;
use Dima\Guestbook\Controller\PostController;

$getRequest = $_GET;
$postRequest = $_POST;

if ($getRequest) {
    foreach ($getRequest as $key => $request) {
        if ($key == 'get') {
            if ($request == 'posts') {
                PostController::get();
            }
        }
    }
}

if ($postRequest) {
    foreach ($postRequest as $key => $request) {
        if ($key == 'add') {
            AddController::add($request);
        }
    }
}