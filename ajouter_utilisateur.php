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
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"]) && !empty($_POST["dateNaissance"])) {
                $nom = $_POST["nom"];
                $prenom = $_POST["prenom"];
                $email = $_POST["email"];
                $adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : ""; // Handle optional fields
                $tel = isset($_POST["tel"]) ? $_POST["tel"] : "";
                $dateNaissance = $_POST["dateNaissance"];
                $photoName = $_FILES["photo"]["name"];
                $photoTmpName = $_FILES["photo"]["tmp_name"];
                $photoError = $_FILES["photo"]["error"];
                if ($photoError === 0) {
                    $photoDestination = "photos/" . $photoName;
                    move_uploaded_file($photoTmpName, $photoDestination);
                } else {
                    echo "<h2>Erreur lors du téléversement de la photo</h2>";
                }
                  $conn = connectDB();
                  $stmt = $conn->prepare("INSERT INTO students (nom, prenom, email, adresse, tel, dateNaissance, photo) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $nom, $prenom, $email, $adresse, $tel, $dateNaissance, $photoDestination);
                if ($stmt->execute()) {
                    // Rediriger vers la page d'affichage
                    header("Location: affichage.php");
                    exit();
                } else {
                    echo "<h2>Erreur lors de l'ajout de l'utilisateur : " . $stmt->error . "</h2>";
                }
                $stmt->close();
                $conn->close();
            } else {
                echo "<h2>Tous les champs requis doivent être remplis !</h2>";
            }
        }
?>
