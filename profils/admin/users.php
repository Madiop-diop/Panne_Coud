<?php
session_start();
if (empty($_SESSION['username']) && empty($_SESSION['mdp'])) {
    header('Location: /COUD/panne/');
    exit();
}

include('../../traitement/fonction.php');
include('../../traitement/requete.php');
include('../../activite.php');

$userId = $_SESSION['id_user'];

// Nombre de lignes par page
$limit = 10;
// Numéro de la page actuelle (par exemple, à partir d'une requête GET)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';

if ($search) {
    $allUsers = allUtilisateurs($connexion);
} else {
    $allUsers = allUtilisateurs($connexion);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../../assets/css/vendor.css" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <link rel="stylesheet" href="../../assets/css/login.css" />
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <!-- script================================================== -->
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/js/bootstrap.min.js">
    <link rel="stylesheet" href="../../assets/bootstrap/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <script src="../assets/js/modernizr.js"></script>
    <script src="../../assets/js/pace.min.js"></script>
</head>

<body>
    <?php include('../../head.php'); ?>
    <br>
    <nav class="navbar navbar-light bg">
        <div class="container">

            <ul class="nav">
                <form class="d-flex" method="GET" action="">
                    <li class="nav-item">
                        <strong class="nav-link active" aria-current="page">
                            <input class="form-control me-2" type="search" name="search" placeholder="recherche"
                                aria-label="Search">
                        </strong>
                    </li>
                    <li class="nav-item">
                        <strong class="nav-link" href="#">
                            <button type="submit" class="btn btn-primary mb-3"
                                style="width: 100%; height:50px ">Rechercher</button>
                        </strong>
                    </li>
                </form>
                <li class="nav-item">
                    <a class="nav-link" href="addUser">
                        <button type="reset" class="btn btn-success mb-3" style="width: 100%; height:50px ">Ajouter
                            Utilisateur</button>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <br>
    <div id="refreshedContent" class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped" style="font-size: 20px; font-family: 'Times New Roman', Times, serif;">
                <thead>
                    <tr>
                        <th scope="col"><b>N°</b></th>
                        <th scope="col"><b>Username</b></th>
                        <th scope="col"><b>Email</b></th>
                        <th scope="col"><b>Telephone</b></th>
                        <th scope="col"><b>Nom</b></th>
                        <th scope="col"><b>Prenom</b></th>
                        <th scope="col"><b>Profile 1</b></th>
                        <th scope="col"><b>Profile 2</b></th>
                        <th scope="col"><b>Statut</b></th>
                        <th scope="col"><b>Modif</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($allUsers): ?>
                    <?php foreach ($allUsers as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['telephone']); ?></td>
                        <td><?php echo htmlspecialchars($user['nom']); ?></td>
                        <td><?php  echo htmlspecialchars($user['prenom']);  ?></td>
                        <td><?php  echo htmlspecialchars($user['profil1']);  ?></td>
                        <td><?php  echo htmlspecialchars($user['profil2']);  ?></td>
                        <td>
                            <strong>
                                <input class="form-check-input change-status" type="checkbox" id="checkboxNoLabel"
                                    data-bs-toggle="modal" data-bs-target="#statusModal"
                                    data-user-id="<?php echo htmlspecialchars($user['id']); ?>" aria-label="..."
                                    <?php echo $user['statut'] == 1 ? 'checked' : ''; ?>>

                            </strong>
                        </td>
                        <td>
                            <a href="addUser.php?user_id=<?php echo htmlspecialchars($user['id']); ?>" class="btn">
                                <!-- Icône SVG pour la modification -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="auto" fill="currentColor"
                                    class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.651-.651l2-5a.5.5 0 0 1 .11-.168l10-10zm-10.61 10.763L1.5 14.5l2.883-.036-2.12-2.121zm11.357-8.036L10.207 1.5 3 8.707V11h2.293l7.293-7.293z" />
                                </svg>
                            </a>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="7">Aucune panne trouvée ou erreur.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Modal de confirmation de modification du statut -->
        <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous vraiment <span id="statusActionText"></span> cet utilisateur ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <form id="statusForm" method="post" action="../../traitement/traitement">
                            <input type="hidden" name="userStatusChange" id="statusUserIdInput" value="">
                            <input type="hidden" name="newStatus" id="newStatusInput" value="">
                            <input type="hidden" name="action" value="changeUserStatus">
                            <button type="submit" class="btn btn-primary">Confirmer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('.change-status').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const isChecked = this.checked;
                    const userId = this.getAttribute('data-user-id');

                    // Modifier le texte du modal en fonction de l'état de la checkbox
                    const actionText = isChecked ? 'activer' : 'désactiver';
                    document.getElementById('statusActionText').textContent = actionText;

                    // Mettre à jour les champs cachés pour le formulaire
                    document.getElementById('statusUserIdInput').value = userId;
                    document.getElementById('newStatusInput').value = isChecked ? 1 : 0;
                });
            });
        });
        </script>



        <!-- Inclure jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
        </script>


        <script src="../../assets/js/jquery-3.2.1.min.js"></script>
        <script src="../../assets/js/plugins.js"></script>
        <script src="../../assets/js/main.js"></script>

</body>
<script src="../../assets/js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>


<?php include('../../footer.php'); ?>

</html>