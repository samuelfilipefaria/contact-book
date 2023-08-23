<?php
  header('Content-Type: application/json');
  header('Content-Type: multipart/form-data');
  header('Content-Type: application/x-www-form-urlencoded');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
  session_start();

  // model
  require_once '../model/contact.php';
  // dao
  require_once '../dao/ContactDao.class.php';
  // Utils
  require_once 'Utils.class.php';

  try {
    $contactController = new ContactController();
    $contactController->handleRequest();
  } catch (Exception $ex) {
    echo Utils::buildJSONMessage($ex->getMessage(), 0);
  }

  class ContactController {
    private $daoContact;

    public function __construct() {
      $this->daoContact = new ContactDao();
    }

    public function handleRequest() {
      switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
          if (!isset($_POST['_acao']))
            throw new Exception('Erro ao tentar realizar a operação.<br> Ação não informada');

          $this->handlePostRequest($_POST['_acao']);
        break;

        default:
          throw new Exception('Erro ao tentar realizar a operação.<br> Requisição desconhecida');
      }
    }

    private function handlePostRequest($_acao) {
      switch($_acao) {
        case 'cadastrar':
          $this->register();
        break;
        case 'editar':
          $this->update();
        break;
        case 'deletar':
          $this->delete();
        break;
        case 'listar':
          $this->getAllContacts();
        break;

        default:
          throw new Exception('Ocorreu um erro ao tentar realizar a operação.<br> Ação desconhecida');
      }
    }

    public function register() {
      try {
        extract($_POST);

        $contact = new Contact(0, $userId, $name, $email, $phone, $photo);
        if (!$this->daoContact->contactExists('name', $contact->get('name'))) {

          if($this->daoContact->registerContact($contact)) {
            echo Utils::buildJSONMessage('Cadastro realizado com sucesso!', 1);
          } else {
            echo Utils::buildJSONMessage('Erro ao tentar realizar o cadastro.', 0);
          }

        } else {
          echo Utils::buildJSONMessage('Erro ao tentar realizar o cadastro.<br>Já existe um contato com o nome informado.', 0);
        }
      } catch (Exception $ex) {
        echo Utils::buildJSONMessage($ex->getMessage(), 0);
      }
    }

    public function getAllContacts() {
      $contacts = [];
      try {
        $contacts = $this->daoContact->getAllContacts();
        echo json_encode($contacts);
      } catch (Exception $ex) {
        echo Utils::buildJSONMessage($ex->getMessage(), 0);
      }
    }

    public function update() {
      try {
        extract($_POST);

        if($this->daoContact->updateContact($name, $phone, $email, $photo, $contactId)) {
          echo Utils::buildJSONMessage('Contato atualizado com sucesso', 1);
        } else {
          echo Utils::buildJSONMessage('Contato NÃO atualizado com sucesso', 0);
        }
      } catch (Exception $ex) {
        echo Utils::buildJSONMessage("tessteeee", 0);
      }
    }

    public function delete() {
      try {
        extract($_POST);

        if($this->daoContact->deleteContact($contactId)) {
          echo Utils::buildJSONMessage('Contato deletado com sucesso', 1);
        } else {
          echo Utils::buildJSONMessage('Contato NÃO foi deletado com sucesso', 0);
        }
      } catch (Exception $ex) {
        echo Utils::buildJSONMessage($ex->getMessage(), 0);
      }
    }

    public function getById($id) {
      try {
        $user = $this->daoContact->getContactById($id);
        echo json_encode($user);
      } catch (Exception $ex) {
        echo Utils::buildJSONMessage($ex->getMessage(), 0);
      }
    }
  }
?>
