<?php
//connexion a la base de données
require 'connexion.php';
//compte le nombre de visiteur
require 'compter_stats.php';

//Insertion des données saisies à partir du formulaire dans la base de donnée
if (isset($_POST['save'])) {
    $sql = $connect->prepare('insert into user(fullname, contact, adress, email) values (:fullname, :contact, :adress, :email)');
    $sql->bindValue('fullname', $_POST['fullname']);
    $sql->bindValue('contact', $_POST['contact']);
    $sql->bindValue('adress', $_POST['adress']);
    $sql->bindValue('email', $_POST['email']);
    $sql->execute();
    header("location: index.php");
}
// selectionner le contenu de la base de donnees
$sql = $connect->prepare('select * from user');
$sql->execute();

// supprimer un element particulier d'une table  de la base de donnees
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $sql = $connect->prepare('delete from user where fullname=:fullname');
    $sql->bindValue('fullname', $_GET['fullname']);
    $sql->execute();
    // selectionner le contenu de la base de donnees
    $sql = $connect->prepare('select * from user');
    $sql->execute();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD PHP et AXIOS</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        td {
            padding: 4px 14px;
        }
    </style>
</head>

<body>
    <div class="col-md-12">
        <h2>Nombre de visiteur du site est:
            <?php compter_visite(); ?>
        </h2>
        <form method="post" autocomplete="off">
            <fieldset>
                <legend>Enregistrement d'un nouvel utilisateur</legend>
                <hr>
                <table cellpadding="2" cellspacing="2">
                    <tr>
                        <th>Nom complet</th>
                        <td><input type="text" id="fullname" name="fullname" required /></td>
                    </tr>
                    <tr>
                        <th>Contact</th>
                        <td><input type="text" id="contact" name="contact" required /></td>
                    </tr>
                    <tr>
                        <th>Adresse</th>
                        <td><input type="text" id="adress" name="adress" required /></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><input type="email" id="email" name="email" required /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="save" name="save" class="btn btn-success"></td>
                    </tr>

                </table>
            </fieldset>
        </form>

    </div>
    <br />
    <!-- fin formulaire d'enregistrement -->
    <div class="col-md-8">
        <table cellspacing="2" cellpadding="2" border="1" class="table table-striped table-hover">
          
            <thead class="table-light">
                <tr>
                    <th>Nom Complet</th>
                    <th>Contact</th>
                    <th>Adress</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            //affichage d'une ligne dans le tableau html
            <?php while ($user = $sql->fetch(PDO::FETCH_OBJ)) { ?>
                <tr>
                    <td><?php echo $user->fullname; ?></td>
                    <td><?php echo $user->contact; ?></td>
                    <td><?php echo $user->adress; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td>
                        <a class="btn btn-danger" href="index.php?fullname=<?php echo $user->fullname ?>&action=delete">Delete</a>
                        <a onclick="" class="btn btn-primary" href="edit.php?fullname=<?php echo $user->fullname; ?>">Edit</a>
                    </td>
                </tr>
            <?php } ?>

        </table>
    </div>
</body>

</html>