<?php
    class Book
    {
        public int    $id;
        public string $author;
        public string $title;
        public bool   $available;
        public int    $pages;
        public int    $isbn;

        public function __construct($db){
            $this->conn = $db->getConnection();
            $this->createIfNotExists();
        }
        // public function __construct(){
        // }

        public function createIfNotExists() {
            $query = "CREATE TABLE IF NOT EXISTS books(
                id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                author VARCHAR(255),
                title VARCHAR(255),
                available BOOLEAN,
                isbn BIGINT,
                pages INT
            )ENGINE=InnoDb;";

            $this->conn->exec($query);       
        }

        public function setData($data) 
        {
            foreach ($data AS $key => $value) 
                $this->{$key} = $value;
        }
        public function insertData($data) 
        {
            $query = "
                        INSERT INTO books 
                        (author, title, available, isbn, pages)  VALUES
                        (:author, :title, :available, :isbn, :pages)
                    ";
            $statement = $this->conn->prepare($query);
            return $statement->execute([
                ':author' => $data->author,
                ':title' => $data->title,
                ':available' => $data->available,
                ':isbn' => $data->isbn,
                ':pages' => $data->pages,
            ]);
            // return $this->conn->query($query);
        }
        public function removeData($id)
        {
            $query = "DELETE FROM books WHERE ID = :id";
            $statement = $this->conn->prepare($query);
            return $statement->execute([
                ':id' => $id,
            ]);
        }
        public function updateData($data)
        {

        }
        public function getAllBooks()
        {
            $query = "SELECT * FROM books";
            $statement = $this->conn->prepare($query);
            $ret = $statement->execute();
            return array($ret, $statement->fetchAll(PDO::FETCH_ASSOC));
        }
    }
?>