<?php  
include 'dash.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
         *{
            margin: 0;
            padding: 0;
            color: #fff;
            font-family: sans-serif;
        }
        body{
            background-color: #001;
            display: flex;
        }
        .img-box{
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #fff;
            flex-shrink: 0;
        }
        .img-box img{
            width: 100%;
        }

        .profile{
            display: flex;
            align-items: center;
            gap: 30px;
        }
        .profile h2{
            font-size: 22px;
            text-transform: capitalize;
        }

        .menu{
            background-color: #123;
            width: 60px;
            height: 100vh;
            padding: 20px;
            overflow: hidden;
            transition: 0.5s ease;
        }
        .menu:hover{
            width: 260px;
        }
        ul{
            list-style: none;
            position: relative;
            height: 95%;
        }
        ul li a{
            display: block;
            text-decoration: none;
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 40px;
            transition: 0.5s ease;
        }
        ul li a:hover , .active, .data-info .box:hover, td:hover{
            background-color: #ffffff55;
        }
        .log-out{
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        .log-out a{
            background-color: #a00;
        }
        ul li a i{
            font-size: 30px;
        }
        /* Content Area */
        .content {
            display: flex;
            gap: 30px;
            padding: 30px;
            width: 100%;
            height: 400px;
            margin-top: 0px;
        }
        .form-card {
            background: linear-gradient(135deg, #0481ff, #0066cc);
            padding: 25px;
            border-radius: 15px;
            width: 100%;
            height: 580px;
        }

        .form-card h1 {
            font-size: 22px;
            font-weight: bolder;
            margin-bottom: 20px;
        }

        .form-input {
            width: 95%;
            padding: 12px;
            margin: 1px 0 20px;
            border: none;
            border-radius: 6px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
        }

        .form-input:focus {
            outline: 2px solid #fff;
        }

        .d-flex {
            display: flex;
            gap: 15px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        /* Bouton Ajouter */
        .form-btn1 {
            flex: 1;
            padding: 12px;
            background-color: #28a745; /* Vert */
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-btn1:hover {
            background-color: #218838;
        }

        
    </style>
</head>
<body>

    <div class="content">
        <div class="form-card">
            <h1>Ajouter une formation</h1>
            <form method="post">
                <label>Titre</label>
                <input type="text" class="form-input" placeholder="Titre de la formation" name="titre">
                
                <label>Prix</label>
                <input type="text" class="form-input" placeholder="Prix en $" name="prix">
                
                <label>Formateur</label>
                <input type="text" class="form-input" placeholder="Nom du formateur" name="formateur">

                <label>categorie</label>
                <input type="text" class="form-input" placeholder="categorie" name="categorie">

                <label>description</label>
                <input type="text" class="form-input" placeholder="description" name="description">

                <label>image</label>
                <input type="file" class="form-input"  name="image">

                <div class="d-flex">
                <input type="submit" value="Ajouter" class="form-btn1" name="ajouter_formation">
                </div>
            </form>
        </div>

        <div class="form-card">
            <h1>Ajouter un etudiant</h1>
            <form method="post">
                <label>Login</label>
                <input type="text" class="form-input" placeholder="Nom d'etudiant" name="login">
                
                <label>Email</label>
                <input type="email" class="form-input" placeholder="Email" name="email">
                
                <label>Mot de passe</label>
                <input type="password" class="form-input" placeholder="Mot de passe" name="password">
                
                <div class="d-flex">
                <input type="submit" value="Ajouter" class="form-btn1" name="ajouter_etudiant">
                </div>

            </form>
        </div>
    </div>
</body>
<?php
require_once "connection_db.php";

// Traitement du formulaire étudiant
if(isset($_POST["ajouter_etudiant"])){
    if(!empty($_POST["login"]) && !empty($_POST["email"]) && !empty($_POST["password"])){
        $login = $_POST["login"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Sécurisation du mot de passe

        try {
            $sql = "INSERT INTO etudiant (login, email, password) VALUES (:login, :email, :password)";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([
                ':login' => $login,
                ':email' => $email,
                ':password' => $password
            ]);
            $message = "<div class='alert success'>Étudiant ajouté avec succès!</div>";
        } catch(PDOException $e) {
            $message = "<div class='alert error'>Erreur : " . $e->getMessage() . "</div>";
        }
    } else {
        $message = "<div class='alert error'>Tous les champs sont obligatoires!</div>";
    }
}

// Traitement du formulaire formation
if(isset($_POST["ajouter_formation"])){
    if(!empty($_POST["titre"]) && !empty($_POST["prix"]) && !empty($_POST["formateur"])){
        $titre = $_POST["titre"];
        $prix = $_POST["prix"];
        $formateur = $_POST["formateur"];
        $categorie = $_POST["categorie"];
        $description = $_POST["description"];
        $image = $_POST["image"];

        try {
            $sql = "INSERT INTO formation (titre, prix, formateur, image , categorie , description) VALUES (:titre, :prix, :formateur, :image , :categorie , :description)";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([
                ':titre' => $titre,
                ':prix' => $prix,
                ':formateur' => $formateur,
                ':image' => $image,
                ':categorie' => $categorie,
                ':description' => $description
            ]);
            $message = "<div class='alert success'>Formation ajoutée avec succès!</div>";
        } catch(PDOException $e) {
            $message = "<div class='alert error'>Erreur : " . $e->getMessage() . "</div>";
        }
    } else {
        $message = "<div class='alert error'>Tous les champs sont obligatoires!</div>";
    }
}
?>
</html>