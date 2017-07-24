<?php
    include_once("conn.php"); //Chama a conexão com o servidor

    if (!empty($_POST['email']) and !empty($_POST['senha'])){ //Verifica se email e senha não estão vindo nulos
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $senha = md5($senha); //Hasheando a a senha para verificar no banco de dados 
        $query = "SELECT* FROM participante WHERE Email = '$email' and Senha = '$senha' LIMIT 1" or die (mysqli_error($conn)); //Query para verificar se o email e a senha do usuário corresponde
        $busca_user = mysqli_query($conn,$query); //Realiza a querylogin
        $resultado = mysqli_fetch_assoc($busca_user); //Pega o resultado da query
        if ($resultado){ // Verifica se a query gerou um resultado
            session_start(); //Starta uma sessão
            $_SESSION["email"] = $email; //Grava email e senha na sessão
            $_SESSION["senha"] = $senha;
            $_SESSION['id'] = $resultado['ID'];
            echo 1; //Imprime 1 para o front-end pegar a resposta positiva de que o email e senha correspondem
        }else{
            echo 0; //Imprime 0 para mostar que não achou um resultado compatível.
        }
    }else{
        echo 0; // Imprime zero se email ou senha vieram vazios
    }
    
?>

