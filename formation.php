
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
    include 'dash.php';
        require_once "connection_db.php";
        $sql = "SELECT * FROM formation ORDER BY id";
        $stmt=$connexion->query($sql);
        $count = $stmt->rowCount();
        if($count){
    ?>
    <div class="content">
        <div class="title-info">
            <p>formation</p>
            <i class="fas fa-table"></i>
        </div>

        <table>
            <thead>
                <tr>
                    <th>titre</th>
                    <th>categorie</th>
                    <th>prix</th>
                    <th>formateur</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row=$stmt->fetch(PDO::FETCH_OBJ)){
                echo"
                <tr>
                    <td><span class='price'>{$row->titre}</span></td>
                    <td><span class='count'>{$row->categorie}</span></td>
                    <td><span class='price'>{$row->prix}</span></td>
                    <td><span class='count'>{$row->formateur}</span></td>
                    <td><a class='delete' href = 'delete_formation.php?id={$row->id}' >delete</a> <a class='edit' href = 'edit_formation.php?id={$row->id}' >edit</a></td>
                </tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
            }else{}
        ?>
    </div>
</body>
</html>