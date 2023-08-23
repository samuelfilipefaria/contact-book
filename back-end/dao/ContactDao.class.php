<?php
  require_once "PDOConnection.class.php";

  class ContactDao {
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
      $query = "UPDATE contato SET ";

      foreach(array_keys($fields_to_update) as $key) {
        $query .= $key." = :$key";
        if (array_key_last($fields_to_update) != $key)
        $query .= ", ";
      }

      $query .= " WHERE idContato = :idContato";

      return $query;
    }

    public function registerContact($contact) {
      $query = "INSERT INTO contato(idUsuario, nome, telefone, email, foto) VALUES(:userId, :name, :phone, :email, :photo);";

      $fields = array(
                'userId' => $contact->get('userId'),
                'name' => $contact->get('name'),
                'phone' => $contact->get('phone'),
                'email' => $contact->get('email'),
                'photo' => $contact->get('photo')
              );

      $result = 0;
      try {
        $result = $this->getResult($query, $fields);
      } catch (Exception $ex) {
        throw new Exception($ex->getMessage());
      }
      return $result > 0;
    }

    public function getContactById($id) {
      $query = "SELECT * FROM contato WHERE idContato = :contactId";
      $fields = array('contactId' => $id);

      $result = [];
      try {
        $result = $this->getResult($query, $fields);
      } catch (Exception $ex) {
        throw new Exception($ex->getMessage());
      }
      return $result;
    }

    public function contactExists($field, $value) {
      $query = "SELECT * FROM contato WHERE $field = :$field";
      $fields = array($field => $value);

      $result = 0;
      try {
        $result = $this->getResult($query, $fields);
      } catch (Exception $ex) {
        throw new Exception($ex->getMessage());
      }
      return count($result) > 0;
    }

    public function deleteContact($id) {
      $query = "DELETE FROM contato WHERE idContato = :contactId";
      $fields = array('contactId' => $id);

      $result = 0;
      try {
        $result = $this->getResult($query, $fields);
      } catch (Exception $ex) {
        throw new Exception($ex->getMessage());
      }
      return $result > 0;
    }

    public function getAllContacts() {
      $query = "SELECT * FROM contato ORDER BY nome ASC";
      $fields = [];
      $result = [];
      try {
        $result = $this->getResult($query, $fields);
      } catch (Exception $ex) {
        throw new Exception($ex->getMessage());
      }
      return $result;
    }

    public function updateContact($name, $phone, $email, $photo, $contactId) {
      $query = "
        UPDATE contato SET
          nome = :name,
          telefone = :phone,
          email = :email,
          foto = :photo
          WHERE idContato = :contactId
      ";

      $fields = array(
        'name' => $name,
        'phone' => $phone,
        'email' => $email,
        'photo' => $photo,
        'contactId' => $contactId
      );

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
