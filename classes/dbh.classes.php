<?php

/**
 * @mixin PDO
 */

class DB
{
  // constructor - connect to database
  public $pdo = null;
  public $stmt = null;

  public function __construct()
  {
    try {
      $this->pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER,
        DB_PASSWORD,
        [
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
      );
    } catch (PDOException $e) {
      throw new  PDOException($e->getMessage(), (int) $e->getCode());
    }
  }

  // destructor - close connection to the database
  function __destruct()
  {
    if ($this->stmt !== null) {
      $this->stmt = null;
    }
    if ($this->pdo !== null) {
      $this->pdo = null;
    }
  }

  //  run SQL query
  public function query($sql, $data = null)
  {
    try {
      $this->stmt = $this->pdo->prepare($sql);
    } catch (PDOException $e) {
      echo "Connection error " . $e->getMessage();
      exit;
    }
    $this->stmt->execute($data);
  }
}

class Dbh
{
  private static ?DB $instance = null;

  private function __construct()
  {
  }

  public static function getInstance(): DB
  {
    if (self::$instance === null) {
      self::$instance = new DB();
    }
    return self::$instance;
  }
}

// database settings
define("DB_HOST", "localhost");
define("DB_NAME", "bookings");
define("DB_CHARSET", "utf8");
define("DB_USER", "root");
define("DB_PASSWORD", "");
