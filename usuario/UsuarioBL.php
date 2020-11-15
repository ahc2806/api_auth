<?php
    use Firebase\JWT\JWT;
    require('../dto/UsuarioDTO.php');
    require('../Connection.php');
    require('../auth.php');

    class UsuarioBL {
        private $conn;
        private $usuarioDTO;
        
        public function __construct() {
            $this->conn = new Connection();
            $this->usuarioDTO = new UsuarioDTO();
        }

        public function login($usuarioDTO) {
            $this -> conn -> OpenConnection();
            $connsql = $this->conn ->getConnection();

            try{
                if($connsql) {

                    $connsql->beginTransaction();
                    $sqlStatment = $connsql->prepare(
                        "SELECT * 
                            FROM usuarios 
                            WHERE username = :usuario AND 
                                    password = :contrasena AND 
                                    state = 1"
                    );
                    $sqlStatment->bindParam(':usuario', $usuarioDTO->username);
                    $sqlStatment->bindParam(':contrasena', $usuarioDTO->password);
                    $sqlStatment->execute();
        
                    $response = $sqlStatment->fetch(PDO::FETCH_OBJ);
                    $connsql->commit();
                    
                    $this->usuarioDTO->username = $usuarioDTO->username;
                    $this->usuarioDTO->password = $usuarioDTO->password;
                    $this->usuarioDTO->token = '';

                    if($response) {
                        $this->usuarioDTO->token = Auth::SignIn([
                            'username' => $usuarioDTO->username,
                            'password' => $usuarioDTO->password
                        ]);
                    }
                    
                    return $this->usuarioDTO;
                }
            } catch(PDOException $e) {
                $connsql -> rollBack();
            }
        }
    }
?>