<?php

namespace kaviaren;

class DB
{
    private $host;
    private $dbname;
    private $username;
    private $password;

    private $connection;

    public function __construct($host, $dbname, $username, $password) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;

        try {
            $this->connection = new \PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->username, $this->password);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /* Login */
    public function login($username, $password) {
        $sql = "SELECT id, password 
                FROM user 
                WHERE username = '".$username."'";
        try {
            $query = $this->connection->query($sql);
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            if ($result !== false && sha1($password) == $result['password']) {
                return $result['id'];
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            return false;
        }
    }

    /* Menu */
    public function getMenuDetails($id) {
        $sql = "SELECT id, display_name 
                FROM menu 
                WHERE id =  :id";
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':id'=>$id]);
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return array();
        }
    }

    public function getAllMenu() {
        $menus = [];
        $sql = "SELECT * FROM menu";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                $menus[] = [
                    'id' => $row['id'],
                    'sys_name' => $row['sys_name'],
                    'display_name' => $row['display_name'],
                    'created_at' => $row['created_at']
                ];
            }
            return $menus;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function updateMenu($id, $displayName) {
        $dateTime = date('Y-m-d H:i:s', time());
        $sql = "UPDATE menu 
                SET display_name = :displayName, updated_at = :dateTime
                WHERE id = :id";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                ':id'=>$id,
                ':displayName'=>$displayName,
                ':dateTime'=>$dateTime
            ]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }


    /* Emails */
    public function insertEmail($name, $email, $message) {
        $dateTime = date('Y-m-d H:i:s', time());
        $sql = "INSERT INTO email(name, email, message, created_at, updated_at) 
                VALUE (:name, :email, :message, :created_at, :created_at)";
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':message' => $message,
                ':created_at' => $dateTime
            ]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getAllEmails() {
        $emails = [];
        $sql = "SELECT * FROM email";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                $emails[] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'message' => $row['message'],
                    'created_at' => $row['created_at']
                ];
            }
            return $emails;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getEmailDetails($id) {
        $sql = "SELECT id, name, email, message 
                FROM email 
                WHERE id = :id";
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':id'=>$id]);
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return array();
        }
    }

    public function deleteEmail($id) {
        $sql = "DELETE FROM email 
                WHERE id = :id";
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':id'=>$id]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function updateEmail($id, $from, $email, $message) {
        $dateTime = date('Y-m-d H:i:s', time());
        $sql = "UPDATE email 
                SET name = :from, email = :email, message = :message, updated_at = :dateTime
                WHERE id = :id";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                ':id'=>$id,
                ':from'=>$from,
                ':email'=>$email,
                ':message'=>$message,
                ':dateTime'=>$dateTime
            ]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }


    /* Cafes */
    public function insertCafe($sysName, $displayName, $image, $sizeS, $sizeM, $sizeL, $type) {
        $dateTime = date('Y-m-d H:i:s', time());
        $sql = "INSERT INTO cafe_menu(sys_name, display_name, image, size_S,size_M,size_L, created_at, updated_at, type) 
                VALUE (:sysName, :displayName, :image, :sizeS, :sizeM, :sizeL, :dateTime, :dateTime, :type)";
        try{
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                ':sysName' => $sysName,
                ':displayName' => $displayName,
                ':image' => $image,
                ':sizeS' => $sizeS,
                ':sizeM' => $sizeM,
                ':sizeL' => $sizeL,
                ':dateTime' => $dateTime,
                ':dateTime' => $dateTime,
                ':type' => $type
            ]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getAllCafe($type) {
        $menus = [];
        $sql = "SELECT * 
                FROM cafe_menu 
                WHERE type = :type";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':type'=>$type]);
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                $menus[] = [
                    'id' => $row['id'],
                    'sys_name' => $row['sys_name'],
                    'display_name' => $row['display_name'],
                    'image' => $row['image'],
                    'size_S' => $row['size_S'],
                    'size_M'=> $row['size_M'],
                    'size_L' => $row['size_L']
                ];
            }
            return $menus;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getCafeMenuDetails($id) {

        $sql = "SELECT id, sys_name, display_name, image, size_S, size_M, size_L 
                FROM cafe_menu 
                WHERE id = :id";
        try{
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':id'=>$id]);
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return $result;
        }
    }

    public function deleteCafe($id) {
        $sql = "DELETE FROM cafe_menu 
                WHERE id = :id";
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':id'=>$id]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function updateCafeMenu($id, $sysName, $displayName, $image, $sizeS, $sizeM, $sizeL) {
        $dateTime = date('Y-m-d H:i:s', time());
        $sql = "UPDATE cafe_menu
                SET sys_name = :sysName, display_name = :displayName, image = :image, size_S = :sizeS, size_M = :sizeM, size_L = :sizeL, updated_at = :dateTime
                WHERE id = :id";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                ':id'=>$id,
                ':sysName'=>$sysName,
                ':displayName'=>$displayName,
                ':image'=>$image,
                ':sizeS'=>$sizeS,
                ':sizeM'=>$sizeM,
                ':sizeL'=>$sizeL,
                ':dateTime'=>$dateTime,
                ':id'=>$id
            ]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }


    /* Content */
    public function getAllContent() {
        $contents = [];
        $sql = "SELECT * FROM content";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                $contents[] = [
                    'id' => $row['id'],
                    'sys_name' => $row['sys_name'],
                    'display_name' => $row['display_name'],
                    'content' => $row['content'],
                    'created_at' => $row['created_at']
            ];
        }
            return $contents;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getContentDetails($id) {
        $sql = "SELECT id, content 
                FROM content 
                WHERE id = :id";
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':id'=>$id]);
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return array();
        }
    }

    public function updateContent($id, $content) {
        $dateTime = date('Y-m-d H:i:s', time());
        $sql = "UPDATE content 
                SET content = :content, updated_at = :dateTime 
                WHERE id = :id";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                ':id'=>$id,
                ':dateTime'=>$dateTime,
                ':content'=>$content
            ]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}