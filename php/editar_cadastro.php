<?php
    include_once("conn.php"); //Chama a conexão com o servidor
    //var_dump($_POST);
    session_start();
    $id = $_SESSION['id'];
    $senhaAntiga = md5($_POST['SenhaAtual']);
    if (!empty($_POST['confNovaSenha']) or !empty(($_POST['novaSenha']))){
        if ($_SESSION['senha'] != $senhaAntiga){
            echo "A senha informada não corresponde com a cadastrada";
            exit();
        }
        if ($_POST['novaSenha'] != $_POST["confNovaSenha"]){
            echo "Senha informada diferente da senha de confirmação";
            exit();
        }

        $senha = md5($_POST['novaSenha']);

    }else{
        $senha = $_SESSION['senha'];
    }
    
    $variaveis = array("Mome","Senha","Sexo","Email","Nascimento","CPF","RG","Telefone","Bairro","Numero","Cidade","Estado","CEP"); //Coloca a label de todas as variaveis que iraão ser verificadas(somente as obrigatórias)
    $verified = True; //Cria uma variável booleana que irá dizer se a verificação está ok
    /*foreach ($variaveis as $v) { //Faz a verificação de cada variavel enviada pelo POST garantindo que nenhuma é nula(só as obrigatórias)
        if (!isset($_POST[$v]) or empty($_POST[$v])){
            echo $v; //Se achar alguma vazia, vai retornar miss 'nome da variavel'
            $verified = False; //Deu ruim
            exit();
        }
    }*/

    if (!filter_var($_POST['Email'],FILTER_VALIDATE_EMAIL)){
        echo "Email inválido";
        exit();
    }

    /*if (strlen($_POST['telefone']) < 8){
        echo strlen($_POST['telefone']);
        echo "telefone invalido";
    } */

    
    if ($verified){ // Se é verificado, pega todos os POST
        $nome = $_POST['Nome'];
        $sexo = $_POST['Sexo'];
        $email = $_POST['Email'];
        $nascimento = $_POST['Nascimento'];
        $nascimento = DateTime::createFromFormat('d/m/Y',$nascimento)->format('Y/m/d');
        $cpf = $_POST['CPF'];
        $cpf = str_replace(".", "", $cpf);
        $cpf = str_replace("-", "", $cpf);
        $rg = $_POST['RG'];
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
        $cep = $_POST['CEP'];
        $cep = str_replace("-","", $cep);
        //print_r ($_POST);
        $query = "UPDATE participante SET Nome='$nome',Sexo='$sexo',CPF='$cpf',RG='$rg',Email='$email',Telefone='$telefone',Nascimento='$nascimento',Logradouro='$logradouro',Bairro='$bairro',Numero='$numero',Complemento='$complemento',Cidade='$cidade',CEP='$cep',Estado='$estado',Senha='$senha' WHERE ID='$id'";
        $fazCadastro = mysqli_query($conn,$query) or die (mysqli_error($conn)) ;
        if ($fazCadastro){
            echo 1;
        }else{
            echo 0;
        }

    
    }

?>