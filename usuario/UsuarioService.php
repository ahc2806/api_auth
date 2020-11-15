<?php
    require('./UsuarioBL.php');

    class UsuarioService {
        private $usuarioBL;
        private $usuarioDTO;

        public function __construct() {
            $this->usuarioBL = new UsuarioBL();
            $this->usuarioDTO = new UsuarioDTO();
        }

        public function login($username, $password) {
            $this->usuarioDTO->username = $username;
            $this->usuarioDTO->password = $password;
            $this->usuarioDTO = $this->usuarioBL->login($this->usuarioDTO);
            echo json_encode($this->usuarioDTO, JSON_PRETTY_PRINT);
        }
    }

    $usuarioService = new UsuarioService();

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET': {
            $headers = apache_request_headers();
            echo Auth::Check($headers['Authorization']);
            break;
        }
        case 'POST': {
            $data = json_decode(file_get_contents('php://input'), true);
            if(empty($data['username'] || empty($data['password']))) {
                echo "Faltan datos";
            } else {
                $usuarioService -> login($data['username'], $data['password']);
            }
            break;
        }
    }
?>