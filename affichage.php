<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="container">
        <h1>Liste des Utilisateurs</h1>
        <form method="get">
            <input type="text" name="search_prenom" placeholder="Prénom">
            <button type="submit">Rechercher</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Date de Naissance</th>
                    <th>Photo de Profil</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                function connectDB() {
                    $host = "mysql";
                    $username = "root";
                    $password = "root";
                    $dbname = "gestion_etudiant";
                    
                    $conn = new mysqli($host, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Échec de la connexion : " . $conn->connect_error);
                    }
                    return $conn;
                }

                $conn = connectDB();

                // Recherche par prénom
                $search_prenom = isset($_GET['search_prenom']) ? $_GET['search_prenom'] : '';

                if (!empty($search_prenom)) {
                    $sql = "SELECT * FROM students WHERE prenom LIKE '%$search_prenom%'";
                } else {
                    $sql = "SELECT * FROM students";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo"<br>";
                        echo "<tr>";
                        echo "<td>" . $row["nom"] . "</td>";
                        echo "<td>" . $row["prenom"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["adresse"] . "</td>";
                        echo "<td>" . $row["tel"] . "</td>";
                        echo "<td>" . $row["dateNaissance"] . "</td>";
                        echo "<td><img src='" . $row["photo"] . "' alt='Photo de Profil' class='profil-photo'></td>";
                        echo "<td>";
                        echo "<form method='post' style='display: inline; margin-right: 5px;'>";
                        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                        echo "<button type='submit' name='delete' class='btn-supprimer' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet étudiant ?\")'>Supprimer</button>";
                        echo "</form>";
                        echo "<form action='modifier.php' method='get' style='display: inline;'>";
                        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                        echo "<button type='submit' class='btn-modifier'>Modifier</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Aucun utilisateur trouvé</td></tr>";
                }

                if (isset($_POST["delete"])) {
                    $id = $_POST["id"];
                    $sql_delete = "DELETE FROM students WHERE id = $id";
                    if ($conn->query($sql_delete) === TRUE) {
                        echo "<script>alert('Utilisateur supprimé avec succès');</script>";
                        echo "<script>window.location.replace('affichage.php');</script>";
                    } else {
                        echo "<script>alert('Erreur lors de la suppression de l\'utilisateur');</script>";
                    }
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        <a href="index.php">Cliquer ici pour ajouter un étudiant</a>
    </div>
</body>
</html>
