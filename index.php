<?php 

    $pdo = new PDO('mysql:host=localhost;dbname=php_crud', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    //CREATE
    if(!isset($_POST['id']) and isset($_POST['nome'])){

        $sql = $pdo->prepare("INSERT INTO clientes VALUES (null, ?, ?)");
        $sql->execute(array($_POST['nome'],$_POST['email']));

        echo 'inserido com sucesso';
    }

    //UPDATE
    if(isset($_POST['id']) and isset($_POST['nome'])){

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];

        $pdo->exec("UPDATE clientes SET nome = '$nome' , email = '$email' WHERE id = $id ");

        echo 'atualizado com sucesso';

    }

    //DELETE
    if(isset($_GET['delete'])){
        $id = (int)$_GET['delete'];
        $sql = $pdo->prepare("DELETE FROM clientes WHERE id = $id");
        $sql->execute();
        echo 'deletado com sucesso o id: ' . $id;
    }


?>


<form method="post">

    <h2> Criar cliente </h2>
    <p>Nome: <input type="text" name="nome"> </p>
    <p>Email: <input type="text" name="email"> </p> <br/> 
    <input type="submit" value="Enviar">

</form>

<hr>

<form method="post">

    <h2> Atualizar cliente </h2>
    <p>Id: <input type="int" name="id"> </p>
    <p>Nome: <input type="text" name="nome"> </p>
    <p>Email: <input type="text" name="email"> <br/> </p>
    <input type="submit" value="Enviar">

</form>

<h2> Lista de clientes :  </h2>

<?php 

    //READ
    $sql = $pdo->prepare("SELECT * FROM clientes");
    $sql->execute();

    $fetchClientes = $sql->fetchAll();


    foreach($fetchClientes as $key => $value){
        echo '<a href="?delete=' .$value['id']. '"> ( X ) </a>' 
        . $value['id'] . ' | ' . $value['nome'] . ' | ' . $value['email'] ;
        echo '<hr>';
    }
?>

