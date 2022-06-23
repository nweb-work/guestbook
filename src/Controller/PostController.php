<?php


namespace Dima\Guestbook\Controller;

use Dima\Guestbook\Model\PostModel as PostModel;

class PostController
{
    public static function get()
    {
        $posts = PostModel::get(5);
        echo json_encode($posts);
    }
}