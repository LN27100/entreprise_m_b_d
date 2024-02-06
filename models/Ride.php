<?php 

class Ride
{
    /**
     * Méthode permettant de créer un utilisateur
     * @param int $ride_id Id du trajet
     * @param string $date Date du trajet
     * @param string $ditance Kilomètres parcourus
     * @param string $user_id Id de l'utilisateur
     * @param int $transport_id Id du moyen de transport
     */

 public static function create(string $date, int $transport_id, string $distance,string $ride_time, int $user_id )
    {
        try {
            // Conexion à la base de données
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Stockage de la requete dans une variable
            $sql = "INSERT INTO ride ( ride_date, transport_id, ride_distance, ride_time, user_id)
             VALUES (:dateride,:id_transport, :distanceride, :ride_time, :id_user)";

            // Préparation de la requête
            $query = $db->prepare($sql);

            // Relier les valeurs aux marqueurs nominatifs
            $query->bindValue(':dateride', htmlspecialchars($date), PDO::PARAM_STR);
            $query->bindValue(':distanceride', htmlspecialchars($distance), PDO::PARAM_STR);
            $query->bindValue(':id_user', $user_id, PDO::PARAM_INT);
            $query->bindValue(':id_transport', $transport_id, PDO::PARAM_INT);
            $query->bindValue(':ride_time', $ride_time, PDO::PARAM_STR);

        

            $query->execute();
        } catch (PDOException $e) {
            echo 'Erreur :' . $e->getMessage();
            die();
        }
    }

    public static function getAllTrajets(int $user_id) {
        try {
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
    //  `heure_minute` qui concatène les heures et les minutes de la colonne `ride_time` au format "00h00min"

            $sql = "SELECT *, DATE_FORMAT(ride_date, '%d/%m/%Y') AS date_fr, CONCAT(TIME_FORMAT(ride_time, '%H'), 'h', TIME_FORMAT(ride_time, '%i'), 'min') AS heure_minute FROM `ride` NATURAL JOIN `transport` WHERE `user_id`= :id_user ORDER BY `ride_date` DESC";
            $query = $db->prepare($sql);
            $query->bindValue(':id_user', $user_id, PDO::PARAM_INT);
            $query->execute();
    
            // Utiliser fetchAll pour récupérer tous les résultats
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;  // Retourner le tableau des trajets
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
    }

/**
 * Methode permettant de supprimer un trajet
 * @param int $ride_id est l'id du trajet
 */
    public static function deleteRide(int $ride_id) {
        try {
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
    
            $sql = "DELETE FROM `ride` WHERE `ride_id` = :ride_id";
            $query = $db->prepare($sql);
            $query->bindValue(':ride_id', $ride_id, PDO::PARAM_INT);
            $query->execute();
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
    }

    /**
     * Methode permettant de faire la somme des kms (ride_distance) de tous les trajets
     * @param in $user_id est l'id de l'utilisateur
     */
    public static function sommeKms(int $user_id) {
        try {
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
    
            $sql = "SELECT Sum(ride_distance) AS 'total' FROM `ride` WHERE `user_id`= :id_user ";
            $query = $db->prepare($sql);
            $query->bindValue(':id_user', $user_id, PDO::PARAM_INT);
            $query->execute();
    
            // Utiliser fetchAll pour récupérer tous les résultats
            $result = $query->fetch(PDO::FETCH_ASSOC);
    
            return $result;  // Retourner le tableau des trajets
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
    }
}

    
