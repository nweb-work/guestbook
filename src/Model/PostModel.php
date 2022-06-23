<?php


namespace Dima\Guestbook\Model;


class PostModel
{
    protected $pdo;
    protected static $tableName = 'guest_book';

    protected function __construct() {}

    protected static function factoryMethod()
    {
        return new self();
    }

    protected function getConnection()
    {
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8;";
        $opt = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new \PDO($dsn, DB_USER, DB_PASS, $opt);
        $this->pdo = $pdo;
    }

    protected function record($post)
    {
        $tableName = self::$tableName;
        [$time, $name, $email, $text] = $post;
        $sql = "INSERT INTO {$tableName} (dtime, name, email, body) VALUES (?,?,?,?)";
        $query = $this->pdo->prepare($sql)->execute([$time, $name, $email, $text]);
        return $query;
    }

    protected function getPosts($limit)
    {
        $tableName = self::$tableName;
        $sql = $this->pdo->prepare("SELECT * FROM {$tableName} ORDER BY dtime DESC LIMIT ?");
        $sql->execute([intval($limit)]);
        return $sql->fetchAll();
    }

    public static function add($post)
    {
        $factory = self::factoryMethod();
        $factory->getConnection();
        return $factory->record($post);
    }

    public static function get($limit)
    {
        $factory = self::factoryMethod();
        $factory->getConnection();
        return $factory->getPosts($limit);
    }
}