<?php 

class Enterprise
{
    /**
     * Méthode permettant de créer une entreprise
     * @param string $nom Nom de l'entreprise
     * @param string $email Email de l'entreprise
     * @param string $siret Siret de l'entreprise
     * @param string $mot_de_passe Mot de passe de l'entreprise
     * @param string $enterprise_id Id de l'entreprise de l'entreprise
     * @param string $adresse Adresse de l'entreprise
     * @param string $code_postal Code postale de l'entreprise
     * @param string $ville Ville de l'entreprise

     */

    public static function create(string $nom, string $email, string $siret, string $mot_de_passe, string $adresse, string $code_postal, string $ville)
    {
        try {
            // Conexion à la base de données
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Stockage de la requete dans une variable
            $sql = "INSERT INTO enterprise (enterprise_name, enterprise_email, enterprise_siret, enterprise_adress, enterprise_password, enterprise_zipcode, enterprise_city)
             VALUES (:enterprise_name, :enterprise_email, :enterprise_siret, :enterprise_adress, :enterprise_password, :enterprise_zipcode, :enterprise_city)";

            // Préparation de la requête
            $query = $db->prepare($sql);

            // Relier les valeurs aux marqueurs nominatifs
            $query->bindValue(':enterprise_name', htmlspecialchars($nom), PDO::PARAM_STR);
            $query->bindValue(':enterprise_email', htmlspecialchars($email), PDO::PARAM_STR);
            $query->bindValue(':enterprise_siret', $siret, PDO::PARAM_STR);
            $query->bindValue(':enterprise_adress', $adresse, PDO::PARAM_STR);
            $query->bindValue(':enterprise_password', password_hash($mot_de_passe, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $query->bindValue(':enterprise_zipcode', $code_postal, PDO::PARAM_STR);
            $query->bindValue(':enterprise_city', $ville, PDO::PARAM_STR);


            $query->execute();
        } catch (PDOException $e) {
            echo 'Erreur :' . $e->getMessage();
            die();
        }
    }


    /**
     * Methode permettant de récupérer les informations d'un Entreprise avec son mail comme paramètre
     * 
     * @param string $email Adresse mail de l'Entreprise
     * 
     * @return bool
     */
    public static function checkMailExists(string $email): bool
    {
        // le try and catch permet de gérer les erreurs, nous allons l'utiliser pour gérer les erreurs liées à la base de données
        try {
            // Création d'un objet $db selon la classe PDO
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

            // stockage de ma requete dans une variable
            $sql = "SELECT * FROM `enterprise` WHERE `enterprise_email` = :enterprise_email";

            // je prepare ma requête pour éviter les injections SQL
            $query = $db->prepare($sql);

            // on relie les paramètres à nos marqueurs nominatifs à l'aide d'un bindValue
            $query->bindValue(':enterprise_email', $email, PDO::PARAM_STR);

            // on execute la requête
            $query->execute();

            // on récupère le résultat de la requête dans une variable
            $result = $query->fetch(PDO::FETCH_ASSOC);

            // on vérifie si le résultat est vide car si c'est le cas, cela veut dire que le mail n'existe pas
            if (empty($result)) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
    }


    /**
     * Methode permettant de récupérer les infos d'un Entreprise avec son mail comme paramètre
     * 
     * @param string $email Adresse mail de l'Entreprise
     * 
     * @return array Tableau associatif contenant les infos de l'Entreprise
     */
    public static function getInfos(string $email): array
    {
        try {
            // Création d'un objet $db selon la classe PDO
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

            // stockage de ma requete dans une variable
            $sql = "SELECT *
                FROM `enterprise` 
                WHERE `enterprise_email` = :enterprise_email";

            // je prepare ma requête pour éviter les injections SQL
            $query = $db->prepare($sql);

            // on relie les paramètres à nos marqueurs nominatifs à l'aide d'un bindValue
            $query->bindValue(':enterprise_email', $email, PDO::PARAM_STR);

            // on execute la requête
            $query->execute();

            // on récupère le résultat de la requête dans une variable
            $result = $query->fetch(PDO::FETCH_ASSOC);

            // on retourne le résultat
            return $result ?? [];
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
    }


    /**
     * Méthode permettant de télécharger une image de profil
     * @param string $new_image_path est le nouveau nom de l'image télécharger
     * @param int $entreprise_id est l'id de l'entreprise
     */

     public static function updateProfileImage(int $enterprise_id, string $new_image_path)
     {
         try {
             $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
             $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
             // Obtenir l'extension du fichier à partir du chemin de l'image
             $file_extension = pathinfo($new_image_path, PATHINFO_EXTENSION);
     
             // Construire un nom de fichier unique avec le entreprise_id
             $new_file_name = "profile_" . $enterprise_id . "." . $file_extension;
     
             // Nouveau chemin de l'image avec le nom de fichier unique
             $new_image_path_with_enterprise_id = '../assets/uploads/' . $new_file_name;
     
             $sql = "UPDATE enterprise SET enterprise_photo = :new_image_path WHERE enterprise_id = :enterprise_id";
     
             $query = $db->prepare($sql);
     
             $query->bindValue(':new_image_path', $new_image_path_with_enterprise_id, PDO::PARAM_STR);
             $query->bindValue(':enterprise_id', $enterprise_id, PDO::PARAM_INT);
     
             $query->execute();
         } catch (PDOException $e) {
             echo 'Erreur :' . $e->getMessage();
             die();
         }
     }
     

         /**
          * * Méthode pour modifier le profil entreprise
          */
         public static function updateProfil(int $enterprise_id, string $new_name, string $new_email, string $new_adress, string $new_zipcode, string $new_city)
     {   
         try {
             $db = new PDO(DBNAME, DBUSER, DBPASSWORD, array(PDO::ATTR_PERSISTENT => true));
             $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
             $sql = "UPDATE enterprise 
                     SET enterprise_name = :new_name, 
                         enterprise_email = :new_email, 
                         enterprise_adress = :new_adress, 
                         enterprise_zipcode = :new_zipcode,
                         enterprise_city = :new_city
                     WHERE enterprise_id = :enterprise_id";
     
             $query = $db->prepare($sql);
     
             $query->bindValue(':new_name', $new_name, PDO::PARAM_STR);
             $query->bindValue(':new_email', $new_email, PDO::PARAM_STR);
             $query->bindValue(':new_adress', $new_adress, PDO::PARAM_STR);
             $query->bindValue(':new_zipcode', $new_zipcode, PDO::PARAM_STR);
             $query->bindValue(':new_city', $new_city, PDO::PARAM_STR);
             $query->bindValue(':enterprise_id', $enterprise_id, PDO::PARAM_INT);
     
             $query->execute();
         } catch (PDOException $e) {
             error_log('Erreur lors de la mise à jour du profil : ' . $e->getMessage());
             throw new Exception('Une erreur s\'est produite lors de la mise à jour du profil.');
         }
     }
     

     /**
      * Méthode pour supprimer le profil entreprise
      * @param int $entreprise_id est l'id de l'entreprise
      * @return bool|string Renvoie true si la suppression est réussie, sinon renvoie un message d'erreur
      */
     
     public static function deleteEnterprise(int $enterprise_id) {
         try {
             $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
     
             $sql = "DELETE FROM enterprise WHERE enterprise_id = :enterprise_id";
             $query = $db->prepare($sql);
             $query->bindValue(':enterprise_id', $enterprise_id, PDO::PARAM_INT);
             $query->execute();
     
             
             return true;
         } catch (PDOException $e) {
             // Si une erreur se produit, retourner le message d'erreur
             return 'Erreur : ' . $e->getMessage();
         }
     }

     public static function getAllUtilisateurs(int $entreprise_id) : int
    {
        try {
            // Création d'un objet $db selon la classe PDO
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

            // stockage de ma requete dans une variable
            $sql = "SELECT count(`user_pseudo`) as 'Total utilisateurs'  FROM `userprofil` where `enterprise_id` = :id_entreprise;";

            // je prepare ma requête pour éviter les injections SQL
            $query = $db->prepare($sql);

            // on relie les paramètres à nos marqueurs nominatifs à l'aide d'un bindValue
            $query->bindValue(':id_entreprise', $entreprise_id, PDO::PARAM_INT);

            // on execute la requête
            $query->execute();

            // on récupère le résultat de la requête dans une variable
            $result = $query->fetch(PDO::FETCH_ASSOC);


            // on retourne le nom de l'entreprise
            return $result['Total utilisateurs'];
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
    }

    public static function getActifUtilisateurs(int $entreprise_id) : int
{
    try {
        // Création d'un objet $db selon la classe PDO
        $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

        // stockage de ma requete dans une variable
        $sql = "SELECT DISTINCT userprofil.*
        FROM `userprofil`
        JOIN `ride` ON userprofil.`user_id` = ride.`user_id`
        WHERE userprofil.`enterprise_id` = :id_entreprise;";

        // je prepare ma requête pour éviter les injections SQL
        $query = $db->prepare($sql);

        // on relie les paramètres à nos marqueurs nominatifs à l'aide d'un bindValue
        $query->bindValue(':id_entreprise', $entreprise_id, PDO::PARAM_INT);

        // on execute la requête
        $query->execute();

        // on récupère le nombre d'utilisateurs actifs
        $count = $query->rowCount();

        // on retourne le nombre d'utilisateurs actifs
        return $count;
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        die();
    }
}

public static function getAllTrajets(int $entreprise_id) : int
{
    try {
        // Création d'un objet $db selon la classe PDO
        $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

        // stockage de ma requete dans une variable
        $sql = "SELECT count('ride_id') AS 'Total des trajets' FROM `ride` 
        JOIN `userprofil` ON ride.`user_id` = userprofil.`user_id`
        WHERE `enterprise_id` = :id_entreprise;";

        // je prepare ma requête pour éviter les injections SQL
        $query = $db->prepare($sql);

        // on relie les paramètres à nos marqueurs nominatifs à l'aide d'un bindValue
        $query->bindValue(':id_entreprise', $entreprise_id, PDO::PARAM_INT);

        // on execute la requête
        $query->execute();

        // on récupère le résultat de la requête dans une variable
        $result = $query->fetch(PDO::FETCH_ASSOC);


        // on retourne le nom de l'entreprise
        return $result['Total des trajets'];
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        die();
    }
}

public static function getlastfiveusers(int $entreprise_id) : array
{
    try {
        // Création d'un objet $db selon la classe PDO
        $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

        // stockage de ma requete dans une variable
        $sql = "SELECT `user_photo`, `user_pseudo` FROM `userprofil` 
        WHERE `enterprise_id` = :id_entreprise
        ORDER BY `user_id` DESC LIMIT 5";

        // je prepare ma requête pour éviter les injections SQL
        $query = $db->prepare($sql);

        // on relie les paramètres à nos marqueurs nominatifs à l'aide d'un bindValue
        $query->bindValue(':id_entreprise', $entreprise_id, PDO::PARAM_INT);

        // on execute la requête
        $query->execute();

        // on récupère le résultat de la requête dans une variable
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        // on retourne le résultat
        return $result;
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        die();
    }
}

public static function getlastfivejourneys(int $entreprise_id): array
{
    try {
        $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

        $sql = "SELECT ride.`ride_date`, ride.`ride_distance`, userprofil.`user_pseudo` , transport.`transport_type`
        FROM `ride`
        JOIN `userprofil`  ON ride.`user_id` = userprofil.`user_id`
        JOIN `transport` ON ride.`transport_id` = transport.`transport_id`
        JOIN `enterprise`  ON userprofil.`enterprise_id` = enterprise.`enterprise_id`
        WHERE enterprise.`enterprise_id` = :enterprise_id
        ORDER BY ride.`ride_date` DESC 
        LIMIT 5";

        $query = $db->prepare($sql);
        $query->bindValue(':enterprise_id', $entreprise_id, PDO::PARAM_INT);

        $query->execute();

        // Récupérer tous les résultats
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        die();
    }
}

}
