<?php
//rechercher un enregistrement et le maj 
require 'connexion.php';
$sql = $connect->prepare('select * from user where fullname=:fullname');
$sql->bindValue('fullname', $_GET['fullname']);
$sql->execute();
//$user est une variable qui a le meme nom que la table de la base de donnée
$user = $sql->fetch(PDO::FETCH_OBJ);

if (isset($_POST['save'])) {
    $sql = $connect->prepare('update user set contact =:contact, adress=:adress, email=:email where fullname=:fullname');
    $sql->bindValue('fullname', $_POST['fullname']);
    $sql->bindValue('contact', $_POST['contact']);
    $sql->bindValue('adress', $_POST['adress']);
    $sql->bindValue('email', $_POST['email']);
    $sql->execute();
    header("location: index.php");
}
// selectionner le contenu de la base de donnees



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD PHP+ SQL </title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.js">
    </script>
    <style>
        td {
            padding: 4px 14px;
        }
    </style>
</head>

<body>
    <div class="col-md-12">
        <form method="post" autocomplete="off">
            <fieldset>
                <legend>Enregistrement d'un nouvel utilisateur</legend>
                <table cellpadding="2" cellspacing="2">
                    <tr>
                        <th>Nom complet</th>
                        <td><input type="text" id="fullname" name="fullname" value="<?php echo $user->fullname; ?>" readonly="readonly" required /></td>
                    </tr>
                    <tr>
                        <th>Contact</th>
                        <td><input type="text" id="contact" name="contact" value="<?php echo $user->contact; ?>" required /></td>
                    </tr>
                    <tr>
                        <th>Adresse</th>
                        <td><input type="text" id="adress" name="adress" value="<?php echo $user->adress; ?>" required /></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><input type="email" id="email" name="email" value="<?php echo $user->email; ?>" required /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="save" name="save" class="btn btn-success"></td>
                    </tr>

                </table>
            </fieldset>
        </form>

    </div>

</body>

</html>