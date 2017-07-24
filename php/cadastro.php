<?php
    include_once("conn.php"); //Chama a conexão com o servidor
    include ("validacoes.php");    
    $email = $_POST['Email'];
    $cpf = $_POST['CPF'];
    $cpf = str_replace(".", "", $cpf);
    $cpf = str_replace("-", "", $cpf);
    if (validacpf($cpf) == 0){
        echo ("CPF invalido");
        exit();
    }
    $cep = $_POST['CEP'];
    $cep = str_replace("-","", $cep);
    if (validacep($cep) == 0){
        echo ("CEP invalido");
        exit();
    }
    $rg = $_POST['RG'];
    $queryA = "SELECT* FROM participante WHERE email='$email'";
    $query = mysqli_query($conn,$queryA);
    $fetch = mysqli_fetch_assoc($query);
    if($fetch){
        echo "Email informado já está em uso";
        exit();
    }
    $queryA = "SELECT* FROM participante WHERE RG='$rg'";
    $query = mysqli_query($conn,$queryA);
    $fetch = mysqli_fetch_assoc($query);
    if($fetch){
        echo "RG informado já está em uso";
        exit();
    }
    $queryA = "SELECT* FROM participante WHERE CPF='$cpf'";
    $query = mysqli_query($conn,$queryA);
    $fetch = mysqli_fetch_assoc($query);
    if($fetch){
        echo "CPF informado já está em uso";
        exit();
    }

    $senha = $_POST['Senha'];
    $confSenha = $_POST['confSenha'];
    if ($senha != $confSenha){
        echo "Senha informada diferente da senha de confirmação.";
    }


    $variaveis = array("Nome","Senha","Sexo","Email","Nascimento","CPF","RG","Telefone","Bairro","Numero","Cidade","Estado","CEP"); //Coloca a label de todas as variaveis que iraão ser verificadas(somente as obrigatórias)
    $verified = True; //Cria uma variável booleana que irá dizer se a verificação está ok
    //print_r ($_POST);
    foreach ($variaveis as $v) { //Faz a verificação de cada variavel enviada pelo POST garantindo que nenhuma é nula(só as obrigatórias)
        if (!isset($_POST[$v]) or empty($_POST[$v])){
            echo "Preencha todos os campos para realizar o cadastro."; //Se achar alguma vazia, vai retornar miss 'nome da variavel'
            $verified = False; //Deu ruim
            exit();
        }
    }

    if (!filter_var($_POST['Email'],FILTER_VALIDATE_EMAIL)){
        echo "Email inválido.";
        exit();
    }


    if ($verified){ // Se é verificado, pega todos os POST
        $nome = $_POST['Nome'];
        $sexo = $_POST['Sexo'];
        $nascimento = $_POST['Nascimento'];
        $nascimento = DateTime::createFromFormat('d/m/Y',$nascimento)->format('Y/m/d');
        $telefone = $_POST['Telefone'];
        $telefone = str_replace("(","",$telefone);
        $telefone = str_replace(")","",$telefone);
        $telefone = str_replace("-","",$telefone);
        $telefone = str_replace(" ","",$telefone);
        $logradouro = $_POST['Logradouro'];
        $bairro = $_POST['Bairro'];
        $numero = $_POST['Numero'];
        $complemento = $_POST['Complemento'];
        $endereco = $_POST['Endereco'];
        $cidade = $_POST['Cidade'];
        $estado = $_POST['Estado'];
        //print_r ($_POST);
        $senha = md5($senha); //Hasheia a senha do usuário
        $query = "INSERT INTO participante(Nome,Sexo,CPF,RG,Email,Telefone,Nascimento,Logradouro,Bairro,Numero,Complemento,Cidade,CEP,Estado,Senha) VALUES ('$nome','$sexo','$cpf','$rg','$email','$telefone','$nascimento','$logradouro','$bairro','$numero','$complemento','$cidade','$cep','$estado','$senha')" or die (mysqli_error());
        $fazCadastro = mysqli_query($conn,$query) or die (mysqli_error($conn)) ;
        if ($fazCadastro){
            session_start(); //Starta uma sessão
            $_SESSION["email"] = $email; //Grava email e senha na sessão
            $_SESSION["senha"] = $senha;
            $_SESSION['id'] = mysqli_insert_id($conn);
            echo 1;
        }else{
            echo "Ocorreu um erro! Tente novamente.";
        }
    }

?>