<?php
class Database
{
    private $pdo;
    protected $driver;
    protected $version;


    public function __construct() {
        $this->pdo();
    }

    private function pdo() {
        $dsn = db_engine . ":host=" . db_server . ";dbname=" . db_name . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $this->pdo = new PDO($dsn, db_username, db_password, $options);
            $this->driver = $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
            $this->version($this->driver());
        } catch (PDOException $error) {
            throw new PDOException($error->getMessage(), (int) $error->getCode());
        }
    }

    public function query($query, $parameters = []) {
        if (!isset($this->pdo)) {
            $this->pdo();
        }

        $sql = $this->pdo->prepare($query);

        if (!empty($parameters)) {
            foreach ($parameters as $parameter => $value) {
                $sql->bindValue($parameter, $value);
            }
        }

        $sql->execute();
        return $sql;
    }

    // Select Statement
    public function select($table, $columns = '*', $where = '', $parameters = []) {
        if (!isset($this->pdo)) {
            $this->pdo();
        }
        $query = "SELECT $columns FROM $table";
        if ($where != '') {
            $query .= " WHERE $where";
        }
        $sql = $this->pdo->prepare($query);
        foreach ($parameters as $key => $value) {
            $sql->bindValue($key, $value);
        }

        $sql->execute();

        return $sql;
    }

    // Insert a new row into the database
    public function insert($table, $data) {

        if (!isset($this->pdo)) {
            $this->pdo();
        }
        // Build the query
        $columns = implode(',', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO $table ($columns) VALUES ($values)";

        // Prepare the statement
        $sql = $this->pdo->prepare($query);

        // Bind the values
        foreach ($data as $key => $value) {
            if ($value === null) {
                $sql->bindValue(":$key", $value, PDO::PARAM_NULL);
            } else {
                $sql->bindValue(":$key", $value);
            }
        }

        return $sql->execute();
    }

    public function update($table, $data, $where) {
        if (!isset($this->pdo)) {
            $this->pdo();
        }
        // Build the SET clause
        $set = '';
        $i = 1;
        foreach ($data as $key => $value) {
            $set .= "$key = :$key";
            if ($i < count($data)) {
                $set .= ", ";
            }
            $i++;
        }

        // Build the WHERE clause
        $whereClause = '';
        $i = 1;
        foreach ($where as $key => $value) {
            $whereClause .= "$key = :$key";
            if ($i < count($where)) {
                $whereClause .= " AND ";
            }
            $i++;
        }
        // Prepare the query
        $sql = $this->pdo->prepare("UPDATE $table SET $set WHERE $whereClause");
        // Bind the values
        foreach ($data as $key => $value) {
            $sql->bindValue(":$key", $value);
        }
        foreach ($where as $key => $value) {
            $sql->bindValue(":$key", $value);
        }
        // Execute the query
        return $sql->execute();
    }

    // Delete a row from the database
    public function delete($table, $where, $bind) {
        if (!isset($this->pdo)) {
            $this->pdo();
        }
        // Build the query
        $query = "DELETE FROM $table WHERE $where";
        // Prepare the statement
        $sql = $this->pdo->prepare($query);
        // Bind the values
        foreach ($bind as $key => $value) {
            $sql->bindValue(":$key", $value);
        }
        // Execute the statement
        return $sql->execute();
    }

    private function version($driver) {

        switch ($driver) {
            case 'mysql':
                $sql = $this->pdo->query("SELECT VERSION() as version")->fetch();
                $this->version = $sql['version'];
                break;
            case 'pgsql':
                $sql = $this->pdo->query("SELECT version() as version")->fetch();
                $this->version = $sql['version'];
                break;
            case 'sqlsrv':
                $sql = $this->pdo->query("SELECT @@version as version")->fetch();
                $this->version = $sql['version'];
                break;
            case 'sqlite':
                $sql = $this->pdo->query("SELECT sqlite_version()")->fetch();
                $this->version = $sql['version'];
                break;
            default:
                $this->version = 'Unknown Version';
        }
    }

    public function load_permission() {
        return $this->query("SELECT DISTINCT permission_name FROM users INNER JOIN user_roles ON user_roles.user_id = users.id INNER JOIN role_permissions ON user_roles.role_id = role_permissions.role_id INNER JOIN permissions ON role_permissions.permission_id = permissions.permission_id WHERE users.id = :id", [':id' => $_SESSION['user_id']])->fetchAll();
    }
    public function hasPermission($permission_name) {
        $permissions = $this->load_permission();
        $permissions = array_map(function ($permission) {
            return $permission['permission_name'];
        }, $permissions);
        if (in_array($permission_name, $permissions)) return true;
        else if (in_array('root', $permissions)) return true;
        else if (in_array($_SESSION['user_id'], superadmin)) return true;
        return false;
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function driver() {
        return $this->driver;
    }
    public function driver_version() {
        return $this->version;
    }

}