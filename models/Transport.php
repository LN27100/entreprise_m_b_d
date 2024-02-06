<?php 

class Transport
{
    public static function getAllTransports() {
        try {
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
    
            $sql = "SELECT * FROM `transport`";
            $query = $db->prepare($sql);
            $query->execute();
    
            // Utiliser fetchAll pour récupérer tous les résultats
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;  

        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
    }
}
