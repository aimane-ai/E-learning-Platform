<?php
session_start();
require_once 'connection_db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["user"])) {
    header("Location: log.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Si c'est une action d'administration
    if (isset($_POST['action']) && $_SESSION["is_admin"]) {
        $action = $_POST['action'];
        $inscription_id = $_POST['inscription_id'];

        try {
            switch ($action) {
                case 'annuler':
                    $sql = "UPDATE inscriptions SET statut = 'cancelled' WHERE id = :id";
                    $stmt = $connexion->prepare($sql);
                    $stmt->execute([':id' => $inscription_id]);
                    $_SESSION['success'] = "Inscription annulée avec succès";
                    break;

                case 'completer':
                    $sql = "UPDATE inscriptions SET statut = 'completed' WHERE id = :id";
                    $stmt = $connexion->prepare($sql);
                    $stmt->execute([':id' => $inscription_id]);
                    $_SESSION['success'] = "Formation marquée comme terminée";
                    break;

                default:
                    $_SESSION['error'] = "Action non reconnue";
                    break;
            }
            header("Location: admin_inscriptions.php");
            exit();
        } catch(PDOException $e) {
            $_SESSION['error'] = "Erreur lors du traitement : " . $e->getMessage();
            header("Location: admin_inscriptions.php");
            exit();
        }
    }
    // Si c'est une nouvelle inscription
    else {
        $formation_id = $_POST['formation_id'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $niveau = $_POST['niveau'];

        try {
            // Récupérer l'ID de l'étudiant
            $sql_etudiant = "SELECT id FROM etudiant WHERE login = :login";
            $stmt_etudiant = $connexion->prepare($sql_etudiant);
            $stmt_etudiant->execute([':login' => $_SESSION["user"]]);
            $etudiant = $stmt_etudiant->fetch(PDO::FETCH_OBJ);

            if ($etudiant){
                // Vérifier si l'étudiant n'est pas déjà inscrit à cette formation
                $sql_check = "SELECT id FROM inscriptions WHERE etudiant_id = :etudiant_id AND formation_id = :formation_id";
                $stmt_check = $connexion->prepare($sql_check);
                $stmt_check->execute([
                    ':etudiant_id' => $etudiant->id,
                    ':formation_id' => $formation_id
                ]);

                if ($stmt_check->rowCount() == 0) {
                    // Créer l'inscription
                    $sql = "INSERT INTO inscriptions (formation_id, etudiant_id, statut) VALUES (:formation_id, :etudiant_id, 'active')";
                    $stmt = $connexion->prepare($sql);
                    $stmt->execute([
                        ':formation_id' => $formation_id,
                        ':etudiant_id' => $etudiant->id
                    ]);

                    $_SESSION['success'] = "Inscription réussie ! Vous pouvez voir vos inscriptions dans votre espace personnel.";
                    header("Location: inscriptions.php");
                } else {
                    $_SESSION['error'] = "Vous êtes déjà inscrit à cette formation.";
                    header("Location: inf.php?id=" . $formation_id);
                }
            } else {
                $_SESSION['error'] = "Erreur : Étudiant non trouvé";
                header("Location: inf.php?id=" . $formation_id);
            }
        } catch(PDOException $e) {
            $_SESSION['error'] = "Erreur lors de l'inscription : " . $e->getMessage();
            header("Location: inf.php?id=" . $formation_id);
        }
        exit();
    }
}
?> 