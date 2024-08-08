<?php
session_start();
include 'fonction.php';

// Vérifier si les données du formulaire sont définies
if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['type_panne']) && isset($_POST['localisation']) &&
    isset($_POST['description']) && isset($_POST['niveau_urgence']) &&
    isset($_SESSION['id_user'])) {

    $type_panne = $_POST['type_panne'];
    $localisation = $_POST['localisation'];
    $description = $_POST['description'];
    $niveau_urgence = $_POST['niveau_urgence'];

    // Tableau des noms de jours et de mois en français
    $jours = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
    $mois = array("", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");

    // Obtenir les indices du jour et du mois actuels
    $numJour = date("w"); // Indice du jour (0 pour dimanche, 6 pour samedi)
    $numMois = date("n"); // Indice du mois (1 pour janvier, 12 pour décembre)

    // Formater la date
    $date_enregistrement = $jours[$numJour] . "/" . date("d") . " " . $mois[$numMois] . "/" . date("Y"); // La date actuelle

    $id_chef_residence = $_SESSION['id_user'];
    $profil1 = $_SESSION['profil2'];

    // Ajouter la valeur du profil1 à la localisation
    $localisation = $profil1 . "--" . $localisation;

    if (insertPanne($connexion, $type_panne, $date_enregistrement, $description, $localisation, $niveau_urgence, $id_chef_residence)) {
        header('Location: /COUD/panne/profils/residence/listPannes');
        exit();
    } else {
        header('Location: /COUD/panne/profils/residence/ajoutPanne');
        exit();
    }
} 

if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['evaluation']) && isset($_POST['commentaire']) &&
    isset($_POST['idPanne']) && isset($_POST['idIntervention']) &&
    isset($_POST['idObservation'])) {

    $evaluationQualite = $_POST['evaluation'];
    $commentaireSuggestion = $_POST['commentaire'];
    $idUtilisateur = $_SESSION['id_user'];
    $idPanne = $_POST['idPanne'];
    $idIntervention = $_POST['idIntervention'];
    $idObservation = isset($_POST['idObservation']) ? $_POST['idObservation'] : null;
     // Tableau des noms de jours et de mois en français
     $jours = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
     $mois = array("", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
 
     // Obtenir les indices du jour et du mois actuels
     $numJour = date("w"); // Indice du jour (0 pour dimanche, 6 pour samedi)
     $numMois = date("n"); // Indice du mois (1 pour janvier, 12 pour décembre)
 
     // Formater la date
     $date_observation = $jours[$numJour] . "/" . date("d") . " " . $mois[$numMois] . "/" . date("Y"); // La date actuelle

    if (enregistrerObservation($connexion, $idPanne, $idUtilisateur, $idIntervention, $evaluationQualite, $date_observation, $commentaireSuggestion, $idObservation)) {
        header('Location: /COUD/panne/profils/residence/listPannes');
        exit();
    } else {
        header('Location: /COUD/panne/profils/residence/observation');
        exit();
    }
}
//############ requete pour enregister un intervention ##############################################

if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['agent']) && isset($_POST['details']) &&
    isset($_POST['idPanne']) && isset($_POST['date_intervention'])) {

    $personne_agent = $_POST['agent'];
    $description_action = $_POST['details'];
    $id_chef_atelier = $_SESSION['id_user'];
    $id_panne = $_POST['idPanne'];
    $date_intervention = $_POST['date_intervention'];
    // Tableau des noms de jours et de mois en français
    $jours = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
    $mois = array("", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");

    // Obtenir les indices du jour et du mois actuels
    $numJour = date("w"); // Indice du jour (0 pour dimanche, 6 pour samedi)
    $numMois = date("n"); // Indice du mois (1 pour janvier, 12 pour décembre)

    // Formater la date
    $date_sys = $jours[$numJour] . "/" . date("d") . " " . $mois[$numMois] . "/" . date("Y");

    // Convertir la date_intervention en timestamp
    $date_intervention = strtotime($date_intervention);

    // Obtenir les indices du jour et du mois actuels
    $numJour2 = date("w", $date_intervention); // Indice du jour (0 pour dimanche, 6 pour samedi)
    $numMois2 = date("n", $date_intervention); // Indice du mois (1 pour janvier, 12 pour décembre)

    // Formater la date
    $date_formatee = $jours[$numJour2] . " " . date("d", $date_intervention) . " " . $mois[$numMois2] . " " . date("Y", $date_intervention);

    $date_intervention = $date_formatee;

    $resultat = "en cours";

    if (enregistrerIntervention($connexion, $date_intervention, $date_sys, $description_action, $resultat, $personne_agent, $id_chef_atelier, $id_panne)) {
        header('Location: /COUD/panne/profils/dst/listPannes');
        exit();
    } else {
        header('Location: /COUD/panne/profils/dst/intervention');
        exit();
    }
}


// ##################################################################################################

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['panneDelete'])) {
    $panne_id = $_POST['panneDelete'];

    // Supprimer la panne de la base de données
    $sql = "DELETE FROM panne WHERE id = ?";
    if ($stmt = $connexion->prepare($sql)) {
        $stmt->bind_param("i", $panne_id);
        $stmt->execute();
        $stmt->close();
        header('Location: /COUD/panne/profils/residence/listPannes');
    exit();
    }

    header('Location: /COUD/panne/profils/residence/listPannes?echec='.$panne_id);
    exit();
} 

// ##################################################################################################

if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['idPanne']) && isset($_POST['instruction']) &&
    isset($_POST['userId'])) {

    $idChefDst = $_POST['userId'];
    $instruction = $_POST['instruction'];
    $idPanne = $_POST['idPanne'];
    // Tableau des noms de jours et de mois en français
    $jours = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
    $mois = array("", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");

    // Obtenir les indices du jour et du mois actuels
    $numJour = date("w"); // Indice du jour (0 pour dimanche, 6 pour samedi)
    $numMois = date("n"); // Indice du mois (1 pour janvier, 12 pour décembre)

    // Formater la date
    $dateImputation = $jours[$numJour] . "/" . date("d") . " " . $mois[$numMois] . "/" . date("Y");
    $resultat = "imputer";

    if (enregistrerImputation($connexion, $idPanne, $idChefDst, $instruction, $resultat, $dateImputation)) {
        header('Location: /COUD/panne/profils/dst/listPannes');
        exit();
    } else {
        header('Location: /COUD/panne/profils/dst/imputation');
        exit();
    }
}
?>