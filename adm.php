<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="projet2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php
    include 'dash.php';
    require_once "connection_db.php";

    // Récupérer les informations de l'admin connecté
    $sql_admin = "SELECT * FROM admin WHERE username = :username";
    $stmt_admin = $connexion->prepare($sql_admin);
    $stmt_admin->execute([':username' => $_SESSION["user"]]);
    $admin = $stmt_admin->fetch(PDO::FETCH_OBJ);

    // Compter le nombre d'étudiants
    $sql_etudiants = "SELECT COUNT(*) as total FROM etudiant";
    $stmt_etudiants = $connexion->query($sql_etudiants);
    $total_etudiants = $stmt_etudiants->fetch(PDO::FETCH_OBJ)->total;

    // Récupérer les formations
    $sql = "SELECT * FROM formation ORDER BY id";
    $stmt = $connexion->query($sql);
    $count = $stmt->rowCount();
    if($count){
    ?>
    <div class="content">
        <div class="title-info">
            <p>dashboard</p>
            <i class="fas fa-chart-bar"></i>
        </div>
        <div class="data-info">
            <div class="box">
                <i class="fas fa-user"></i>
                <div class="data">
                    <p>etudiants</p>
                    <span><?php echo $total_etudiants ?></span>
                </div>
            </div>
            <div class="box">
                <i class="fas fa-pen"></i>
                <div class="data">
                    <p>posts</p>
                    <span>29</span>
                </div>
            </div>
            <div class="box">
                <i class="fas fa-table"></i>
                <div class="data">
                    <p>formation</p>
                    <span><?php echo $count ?></span>
                </div>
            </div>
            <div class="box">
                <i class="fas fa-dollar"></i>
                <div class="data">
                    <p>revenue</p>
                    <span>$2652</span>
                </div>
            </div>
        </div>
        <div class="title-info">
            <p>formation</p>
            <i class="fas fa-table"></i>
        </div>

        <table>
            <thead>
                <tr>
                    <th>titre</th>
                    <th>prix</th>
                    <th>formateur</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row=$stmt->fetch(PDO::FETCH_OBJ)){
                echo"
                <tr>
                    <td>{$row->titre}</td>
                    <td><span class='price'>{$row->prix}</span></td>
                    <td><span class='count'>{$row->formateur}</span></td>
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