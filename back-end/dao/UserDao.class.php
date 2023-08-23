<?php
  require_once "PDOConnection.class.php";

  class UserDao {
    private $connection;

    public function __construct() {
      $this->connection = new PDOConnection();
    }

    private function getResult($query, $fields) {
      $this->connection->connect();
      $stm = $this->connection->prepareStm($query, $fields);
      return $this->connection->executeQuery($stm);
    }

    private function buildUpdateQuery($fields_to_update) {
      $query = "UPDATE usuario SET ";

      foreach(array_keys($fields_to_update) as $key) {
        $query .= $key." = :$key";
        if (array_key_last($fields_to_update) != $key)
        $query .= ", ";
      }

      $query .= " WHERE idUsuario = :idUsuario";

      return $query;
    }

    public function registerUser($user) {
      $query = "INSERT INTO usuario(nome, login, senha, foto) VALUES(:name, :email, :password, :photo);";

      $fields = array(
                'name' => $user->get('name'),
                'email' => $user->get('email'),
                'password' => md5($user->get('password')),
                'photo' => $user->get('photo')
              );

      $result = 0;
      try {
        $result = $this->getResult($query, $fields);
      } catch (Exception $ex) {
        throw new Exception($ex->getMessage());
      }
      return $result > 0;
    }

    public function getUserById($id) {
      $query = "SELECT * FROM usuario WHERE idUsuario = :userId";
      $fields = array('userId' => $id);

      $result = [];
      try {
        $result = $this->getResult($query, $fields);
      } catch (Exception $ex) {
        throw new Exception($ex->getMessage());
      }
      return $result;
    }

    public function getUserByEmail($userEmail) {
      $query = "SELECT * FROM usuario WHERE login = :userEmail";
      $fields = array('userEmail' => $userEmail);

      $result = [];
      try {
        $result = $this->getResult($query, $fields);
      } catch (Exception $ex) {
        throw new Exception($ex->getMessage());
      }
      return $result;
    }

    public function getLastUser() {
      $query = "SELECT * FROM usuario ORDER BY usuarioId DESC LIMIT 1";
      $fields = [];

      $result = [];
      try {
        $result = $this->getResult($query, $fields);
      } catch (Exception $ex) {
        throw new Exception($ex->getMessage());
      }
      return $result;
    }

    public function userExists($field, $value) {
      $query = "SELECT * FROM usuario WHERE $field = :$field";
      $fields = array($field => $value);

      $result = 0;
      try {
        $result = $this->getResult($query, $fields);
      } catch (Exception $ex) {
        throw new Exception($ex->getMessage());
      }
      return count($result) > 0;
    }

    public function deleteUser($id) {
      $query = "DELETE FROM usuario WHERE idUsuario = :userId";
      $fields = array('userId' => $id);

      $result = 0;
      try {
        $result = $this->getResult($query, $fields);
      } catch (Exception $ex) {
        throw new Exception($ex->getMessage());
      }
      return $result > 0;
    }

    public function getAllUsers() {
      $query = "SELECT * FROM usuario ORDER BY nome ASC";
      $fields = [];
      $result = [];
      try {
        $result = $this->getResult($query, $fields);
      } catch (Exception $ex) {
        throw new Exception($ex->getMessage());
      }
      return $result;
    }

    public function updateUser($fields_to_update, $id) {
      $query = $this->buildUpdateQuery($fields_to_update);

      $fields = [...$fields_to_update, 'idUsuario' => $id];
      $result = 0;

      try {
        $result = $this->getResult($query, $fields);
      } catch (Exception $ex) {
        throw new Exception($ex->getMessage());
      }
      return $result > 0;
    }
  }
?>
