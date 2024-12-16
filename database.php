<?php
require __DIR__ . '/vendor/autoload.php'; // Load Composer autoload
require_once 'userhelper.php'; // Include additional helper

use Dotenv\Dotenv;

class Database {
    private static $instance = null; // Singleton instance
    private $connection; // PDO connection object

    // Private constructor to prevent direct instantiation
    private function __construct() {
        // Load environment variables
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        // Retrieve environment variables
        $host = $_ENV['DB_HOST'] ?? '127.0.0.1'; // Default to localhost
        $port = $_ENV['DB_PORT'] ?? '3306'; // Default MySQL port
        $database = $_ENV['DB_DATABASE'] ?? 'test'; // Default database
        $username = $_ENV['DB_USERNAME'] ?? 'root'; // Default username
        $password = $_ENV['DB_PASSWORD'] ?? ''; // Default empty password

        try {
            // Establish database connection
            $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the database exists
            $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
            $stmt->execute([$database]);

            if ($stmt->rowCount() === 0) {
                // Database doesn't exist, create it
                $pdo->exec("CREATE DATABASE `$database`");
            }

            // Use the database
            $pdo->exec("USE `$database`");

            // If a schema file exists, execute it
            $schemaFile = __DIR__ . '/database/schema.sql';
            if (file_exists($schemaFile)) {
                $customInitScript = file_get_contents($schemaFile);
                $pdo->exec($customInitScript);
            }

            // Save connection
            $this->connection = $pdo;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Singleton pattern to get a single instance of the Database class
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Get the PDO connection
    public function getConnection() {
        return $this->connection;
    }
}

// Initialize the Database instance
$dbInstance = Database::getInstance();
$connection = $dbInstance->getConnection();
