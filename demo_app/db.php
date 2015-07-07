<?php

class DbWrapper {

    private $conn;

    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'xss');
    }

    public function newUser($name, $image) {
        $statement = $this->conn->prepare('INSERT INTO users(name, image) VALUES(?, ?)');
        $statement->bind_param('ss', $name, $image);
        $statement->execute();
    }

    public function newMessage($user, $message) {
        $select = $this->conn->prepare('SELECT id FROM users WHERE name=?');
        $select->bind_param('s', $user);
        $select->execute();
        $select->bind_result($id);
        $select->fetch();
        if ($id === null)
        {
            return false;
        }
        $select->free_result();
        $statement = $this->conn->prepare('INSERT INTO messages(user, message, timestamp) VALUES(?, ?, ?)');
        $timestamp = 'NOW()';
        $statement->bind_param('sss', $id, $message, $timestamp);
        $statement->execute();
    }

    public function getMessages() {
        $res = $this->conn->query("SELECT users.name, users.image, messages.message, messages.timestamp "
                . "FROM users, messages WHERE users.id = messages.user ORDER BY messages.id DESC LIMIT 10");
        $result = [];
        while (($row = $res->fetch_assoc()) !== null)
        {
            $result[] = $row;
        }
        return $result;
    }

    public function getUsers() {
        $res = $this->conn->query("SELECT users.name FROM users");
        $result = [];
        while (($row = $res->fetch_assoc()) !== null)
        {
            $result[] = $row;
        }
        return $result;
    }

}