<?php


namespace Dima\Guestbook\Controller;

use Dima\Guestbook\Model\PostModel as PostModel;

class AddController
{
    private $name;
    private $email;
    private $text;

    private function __construct(){}

    private static function factoryMethod() : AddController
    {
        return new self();
    }

    private function validate() : array
    {
        $error = [];
        if (empty($this->name)) {
            $error[] = 'Не заполнено имя';
        }

        if (empty($this->email)) {
            $error[] = 'Не заполнен email';
        }

        if (empty($this->text)) {
            $error[] = 'Не заполнен текст';
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $error[] = 'Некорректный email';
        }

        return $error;
    }

    private function getResponse(array $response) : void
    {
        $message = implode(', ', $response);
        echo json_encode($message,  JSON_PRETTY_PRINT|JSON_PRESERVE_ZERO_FRACTION);
    }

    public static function add($request) : void
    {
        $factory = self::factoryMethod();
        $post = json_decode($request, true);

        $factory->name = $post['name'];
        $factory->email = $post['email'];
        $factory->text = $post['text'];

        $errorsValidate = $factory->validate();
        if (!empty($errorsValidate)) {
            $factory->getResponse($errorsValidate);
            return;
        }

        $add = PostModel::add([
            date('Y-m-d H:i:s'),
            $factory->name,
            $factory->email,
            $factory->text
        ]);

        if ($add === true) {
            $factory->getResponse(['Сообщение успешно добавлено']);
        } else {
            $factory->getResponse(['Ошибка при добавлении сообщения']);
        }
    }
}