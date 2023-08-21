<?php
  header('Content-Type: application/json');
  header('Content-Type: multipart/form-data');
  header('Content-Type: application/x-www-form-urlencoded');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
  session_start();

  // model
  require_once '../model/user.php';
  // dao
  require_once '../dao/UserDao.class.php';
  // Utils
  require_once 'Utils.class.php';

  try {
    $userController = new UserController();
    $userController->handleRequest();
  } catch (Exception $ex) {
    echo Utils::buildJSONMessage($ex->getMessage(), 0);
  }

  class UserController {
    private $daoUser;

    public function __construct() {
      $this->daoUser = new UserDao();
    }

    public function handleRequest() {
      //identificando o tipo de requisicao recebida
      switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
          if (!isset($_POST['_acao']))
            throw new Exception('Erro ao tentar realizar a operação.<br> Ação não informada');

          $this->handlePostRequest($_POST['_acao']);
        break;

        case 'GET':
          if (!isset($_GET['_acao']))
            throw new Exception('Erro ao tentar realizar a operação.<br> Ação não informada');

          $this->handleGetRequest($_GET['_acao']);
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
        case 'entrar':
          $this->login();
        break;
        // poderiam existir outras ações a serem executadas com POST
        default:
          throw new Exception('Ocorreu um erro ao tentar realizar a operação.<br> Ação desconhecida');
      }
    }

    private function handleGetRequest($_acao) {
      switch($_acao) {
        case 'listar':
          $this->getAllUsers();
        break;
        // poderiam existir outras ações a serem executadas com GET
        default:
          throw new Exception('Ocorreu um erro ao tentar realizar a operação.<br> Ação desconhecida');
      }
    }

    public function register() {
      try {
        extract($_POST);
        // variaveis $_acao, $descricao, $categoria e $quantidade
        $user = new User(0, $name, $email, $password, $photo);
        if (!$this->daoUser->userExists('name', $user->get('name'))) {

          if($this->daoUser->registerUser($user)) {
            $_SESSION['userEmail'] = $email;
            $_SESSION['userName'] = $name;
            echo Utils::buildJSONMessage('Cadastro realizado com sucesso!', 1, $_SESSION['userName']);
          } else {
            session_destroy();
            echo Utils::buildJSONMessage('Erro ao tentar realizar o cadastro.', 0, false);
          }

        } else {
          echo Utils::buildJSONMessage('Erro ao tentar realizar o cadastro.<br>Já existe um usuário com o nome informado.', 0);
        }
      } catch (Exception $ex) {
        echo Utils::buildJSONMessage($ex->getMessage(), 0);
      }
    }

    public function login() {
      try {
        extract($_POST);
        if (
          $this->daoUser->userExists('login', $email) &&
          $this->daoUser->userExists('senha', $password)
        ) {
            $_SESSION['userEmail'] = $email;
            $_SESSION['userName'] = $name;
            echo Utils::buildJSONMessage('Login realizado com sucesso!', 1, $_SESSION['userName']);
          } else {
            session_destroy();
            echo Utils::buildJSONMessage('Erro ao tentar realizar o login.', 0, false);
          }
      } catch (Exception $ex) {
        echo Utils::buildJSONMessage($ex->getMessage(), 0);
      }
    }

    public function getAllUsers() {
      $users = [];
      try {
        $users = $this->daoUser->getAllUsers();
        echo json_encode($users);
      } catch (Exception $ex) {
        echo Utils::buildJSONMessage($ex->getMessage(), 0);
      }
    }

    public function update() {
      try {
        echo Utils::buildJSONMessage('Produto atualizado com sucesso', 1);
      } catch (Exception $ex) {
        echo Utils::buildJSONMessage($ex->getMessage(), 0);
      }
    }

    public function deletar() {
      try {
        echo Utils::buildJSONMessage('Produto excluído com sucesso', 1);
      } catch (Exception $ex) {
        echo Utils::buildJSONMessage($ex->getMessage(), 0);
      }
    }

    public function getById($id) {
      try {
        $user = $this->daoUser->getUserById($id);
        echo json_encode($user);
      } catch (Exception $ex) {
        echo Utils::buildJSONMessage($ex->getMessage(), 0);
      }
    }
  }
?>
