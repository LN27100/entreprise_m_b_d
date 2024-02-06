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
     * @param int $user_id est l'id de l'entreprise
     */

     public static function updateProfileImage(int $enterprise_id, string $new_image_path)
     {
         try {
             $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
             $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
             // Obtenir l'extension du fichier à partir du chemin de l'image
             $file_extension = pathinfo($new_image_path, PATHINFO_EXTENSION);
     
             // Construire un nom de fichier unique avec le user_id
             $new_file_name = "profile_" . $enterprise_id . "." . $file_extension;
     
             // Nouveau chemin de l'image avec le nom de fichier unique
             $new_image_path_with_enterprise_id = '../assets/uploads/' . $new_file_name;
     
             $sql = "UPDATE userprofil SET user_photo = :new_image_path WHERE user_id = :user_id";
     
             $query = $db->prepare($sql);
     
             $query->bindValue(':new_image_path', $new_image_path_with_enterprise_id, PDO::PARAM_STR);
             $query->bindValue(':user_id', $enterprise_id, PDO::PARAM_INT);
     
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
     
             $sql = "UPDATE userprofil 
                     SET user_describ = :new_description, 
                         user_name = :new_name, 
                         user_firstname = :new_firstname, 
                         user_pseudo = :new_pseudo, 
                         user_email = :new_email, 
                         user_dateofbirth = :new_dateofbirth, 
                         enterprise_id = :new_enterprise 
                     WHERE user_id = :user_id";
     
             $query = $db->prepare($sql);
     
             $query->bindValue(':new_description', $new_description, PDO::PARAM_STR);
             $query->bindValue(':new_name', $new_name, PDO::PARAM_STR);
             $query->bindValue(':new_firstname', $new_firstname, PDO::PARAM_STR);
             $query->bindValue(':new_pseudo', $new_pseudo, PDO::PARAM_STR);
             $query->bindValue(':new_email', $new_email, PDO::PARAM_STR);
             $query->bindValue(':new_dateofbirth', $new_dateofbirth, PDO::PARAM_STR);
             $query->bindValue(':new_enterprise', $new_enterprise, PDO::PARAM_STR);
             $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
     
             $query->execute();
         } catch (PDOException $e) {
             error_log('Erreur lors de la mise à jour du profil : ' . $e->getMessage());
             throw new Exception('Une erreur s\'est produite lors de la mise à jour du profil.');
         }
     }
     
     /**
      * Méthode pour supprimer le profil entreprise
      * @param int $user_id est l'id de l'entreprise
      * @return bool|string Renvoie true si la suppression est réussie, sinon renvoie un message d'erreur
      */
     
     public static function deleteUser(int $user_id) {
         try {
             $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
     
             $sql = "DELETE FROM userprofil WHERE user_id = :user_id";
             $query = $db->prepare($sql);
             $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
             $query->execute();
     
             
             return true;
         } catch (PDOException $e) {
             // Si une erreur se produit, retourner le message d'erreur
             return 'Erreur : ' . $e->getMessage();
         }
     }
}
