<?php
include "dash.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="projet2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .delete{
            text-decoration: none;
            background-color: red;
            padding: 5px 20px;
            border-radius: 7px;
        }
        .edit{
            text-decoration: none;
            background-color: green;
            padding: 5px 15px;
            border-radius: 7px;
            width: 50%;
        }
    </style>
</head>
<body>
    <?php
        require_once "connection_db.php";
        $sql = "SELECT * FROM etudiant ORDER BY id";
        $stmt=$connexion->query($sql);
        $count = $stmt->rowCount();
        $id = 1;
        if($count){
    ?>
     <div class="content">
        <div class="title-info">
            <p>Etudiants</p>
            <i class="fas fa-table"></i>
        </div>
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>nom</th>
                    <th>email</th>
                    <th>date de join</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row=$stmt->fetch(PDO::FETCH_OBJ)){
                echo"
                <tr>
                    <td>".$id++."</td>
                    <td><span class='price'>{$row->login}</span></td>
                    <td><span class='count'>{$row->email}</span></td>
                    <td><span class='price'>{$row->dateRejoindre}</span></td>
                    <td><a class='delete' href='delete.php?id={$row->id}'>delete</a> <a class='edit' href='edit.php?id={$row->id}'>edit</a></td>
                </tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
            }else{}
        ?>
    </div>
    </div>
</body>
</html>