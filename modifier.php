<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un utilisateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Modifier un Utilisateur</h1>
        <?php
        function connectDB() {
            $host = 'mysql';
            $username = 'root';
            $password = 'root';
            $dbname = 'gestion_etudiant';
            
            $conn = new mysqli($host, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Échec de la connexion : " . $conn->connect_error);
            }
            return $conn;
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
            $id = $_GET["id"];
            $conn = connectDB();

            $sql = "SELECT * FROM students WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
        ?>
                <form action="modifier.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom" value="<?php echo $row['nom']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom :</label>
                        <input type="text" id="prenom" name="prenom" value="<?php echo $row['prenom']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="adresse">Adresse :</label>
                        <input type="text" id="adresse" name="adresse" value="<?php echo $row['adresse']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="tel">Téléphone :</label>
                        <input type="text" id="tel" name="tel" value="<?php echo $row['tel']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="dateNaissance">Date de Naissance :</label>
                        <input type="date" id="dateNaissance" name="dateNaissance" value="<?php echo $row['dateNaissance']; ?>" required>
                    </div>
                    <!-- Ajoutez les autres champs ici avec les valeurs préremplies -->
                    <button type="submit" class="btn">Modifier</button>
                </form>
        <?php
            } else {
                echo "<h2>Aucun utilisateur trouvé avec cet identifiant.</h2>";
            }
            $conn->close();
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
            $id = $_POST["id"];
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $email = $_POST["email"];
            $adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : "";
            $tel = isset($_POST["tel"]) ? $_POST["tel"] : "";
            $dateNaissance = $_POST["dateNaissance"];
            // Ajoutez le traitement pour les autres champs ici

            $conn = connectDB();

            $sql_update = "UPDATE students SET nom='$nom', prenom='$prenom', email='$email', adresse='$adresse', tel='$tel', dateNaissance='$dateNaissance' WHERE id=$id";
            if ($conn->query($sql_update) === TRUE) {
                echo "<h2>Utilisateur modifié avec succès !</h2>";
            } else {
                echo "<h2>Erreur lors de la modification de l'utilisateur : " . $conn->error . "</h2>";
            }

            $conn->close();
        }
        ?>
        <a href="affichage.php">Retour à la liste des utilisateurs</a>
    </div>
</body>
</html>
