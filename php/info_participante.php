<?php
    include_once("conn.php");
    session_start();
    if (!isset($_SESSION['email']) or !isset($_SESSION['senha']) or !isset($_SESSION['id'])){
        echo 0;
    }else{
        $id = $_SESSION['id'];
        $query = "SELECT* FROM participante WHERE id='$id' LIMIT 1" or die(mysqli_error($conn));
        $busca_user = mysqli_query($conn,$query);
        $resultado = mysqli_fetch_assoc($busca_user);
        if ($resultado){
            $resultado['Nascimento'] = date("d-m-Y", strtotime($resultado['Nascimento']));
            header('Content-Type: application/json');
            echo json_encode($resultado);
        }else{
            echo "0";
        }

    }


?>