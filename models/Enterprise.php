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
 * Méthode pour mettre à jour le profil de l'entreprise dans la base de données.
 * 
 * @param int $enterprise_id L'identifiant de l'entreprise à mettre à jour
 * @param string $new_name Le nouveau nom de l'entreprise
 * @param string $new_email Le nouveau email de l'entreprise
 * @param string $new_adress La nouvelle adresse de l'entreprise
 * @param string $new_zipcode Le nouveau code postal de l'entreprise
 * @param string $new_city La nouvelle ville de l'entreprise
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

    public static function deleteEnterprise(int $enterprise_id)
    {
        try {
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

            $sql = "DELETE FROM enterprise WHERE enterprise_id = :enterprise_id";
            $query = $db->prepare($sql);
            $query->bindValue(':enterprise_id', $enterprise_id, PDO::PARAM_INT);
            $query->execute();

            // Détruire la session
            session_destroy();

            // Supprimer le mot de passe de la session
            unset($_SESSION['enterprise_password']);

            return true;
        } catch (PDOException $e) {
            // Si une erreur se produit, retourner le message d'erreur
            return 'Erreur : ' . $e->getMessage();
        }
    }



    /**
 * Méthode pour récupérer le nombre total d'utilisateurs enregistrés dans une entreprise spécifiée.
 * 
 * @param int $entreprise_id L'identifiant de l'entreprise pour laquelle récupérer les utilisateurs
 * @return int Le nombre total d'utilisateurs
 */
    public static function getAllUtilisateurs(int $entreprise_id): int
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


    /**
 * Méthode pour récupérer le nombre d'utilisateurs actifs dans une entreprise spécifiée.
 * 
 * @param int $entreprise_id L'identifiant de l'entreprise pour laquelle récupérer les utilisateurs
 * @return int Le nombre d'utilisateurs actifs
 */
    public static function getActifUtilisateurs(int $entreprise_id): int
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


    /**
 * Méthode pour récupérer le nombre total de trajets effectués par les utilisateurs d'une entreprise spécifiée.
 * 
 * @param int $entreprise_id L'identifiant de l'entreprise pour laquelle récupérer les trajets
 * @return int Le nombre total de trajets effectués
 */
    public static function getAllTrajets(int $entreprise_id): int
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


    /**
 * Méthode pour récupérer les informations des cinq derniers utilisateurs ajoutés à une entreprise spécifiée.
 * 
 * @param int $entreprise_id L'identifiant de l'entreprise pour laquelle récupérer les utilisateurs
 * @return array Un tableau contenant les informations des utilisateurs (photo et pseudo)
 */
    public static function getlastfiveusers(int $entreprise_id): array
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


    /**
 * Méthode pour récupérer les détails des cinq derniers trajets effectués par des utilisateurs de l'entreprise spécifiée.
 * 
 * @param int $entreprise_id L'identifiant de l'entreprise pour laquelle récupérer les trajets
 * @return array Un tableau contenant les détails des trajets (date, distance, pseudo de l'utilisateur, type de transport)
 */
    public static function getlastfivejourneys(int $entreprise_id): array
    {
        try {
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

            $sql = "SELECT DATE_FORMAT(ride.ride_date, '%d/%m/%Y') AS date_fr, ride.`ride_distance`, userprofil.`user_pseudo` , transport.`transport_type`
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


    /**
     * Méthode pour récupérer les statistiques des moyens de transport pour une entreprise donnée
     * @param int $entreprise_id L'identifiant de l'entreprise pour laquelle récupérer les statistiques
     * @return array Un tableau associatif contenant les statistiques des moyens de transport
     *              Le tableau contient des paires de clés-valeurs où la clé est le type de transport
     *              et la valeur est le nombre d'occurrences de ce type de transport
     */
    public static function getTransportStats(int $entreprise_id): array
    {
        try {
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

            // Requête SQL pour récupérer les statistiques de transport
            $sql = "SELECT transport_type, COUNT(*) as stats FROM `transport` 
            NATURAL JOIN `userprofil`
            NATURAL JOIN `enterprise`
            NATURAL JOIN `ride`
            where enterprise_id = :enterprise_id
            GROUP BY transport_type;";

            // Préparer et exécuter la requête
            $query = $db->prepare($sql);
            $query->bindValue(':enterprise_id', $entreprise_id, PDO::PARAM_INT);
            $query->execute();

            // Récupérer les résultats sous forme de tableau associatif
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            // Retourner les statistiques des moyens de transport
            return $result;
        } catch (PDOException $e) {
            // En cas d'erreur, afficher le message d'erreur et arrêter le script
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
    }

    /**
     * Méthode pour récupérer les données de trajets pour une entreprise donnée et une année spécifique
     * @param int $enterprise_id L'identifiant de l'entreprise pour laquelle récupérer les données de trajets
     * @param int $year L'année pour laquelle récupérer les données de trajets
     * @return array Un tableau associatif contenant les données de trajets pour l'année spécifiée
     *              Le tableau contient des paires de clés-valeurs où la clé est la date du trajet au format "jour/mois/année"
     *              et la valeur est le nombre total de trajets effectués ce jour-là
     */

    public static function getRideDataForYear($enterprise_id, $year)
    {
        try {
            // Connexion à la base de données
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
            // Préparation de la requête SQL
            $query = "SELECT MONTH(ride_date) AS month, COUNT(*) AS total_rides
        FROM ride
        NATURAL JOIN `enterprise`
        WHERE enterprise_id = :enterprise_id
        AND YEAR(ride_date) = :years
        GROUP BY MONTH(ride_date)";

            // Préparation de la requête
            $stmt = $db->prepare($query);

            // Liaison des valeurs des paramètres
            $stmt->bindParam(':enterprise_id', $enterprise_id, PDO::PARAM_INT);
            $stmt->bindParam(':years', $year, PDO::PARAM_INT);

            // Exécution de la requête
            $stmt->execute();
            // Récupération du résultat sous forme de tableau associatif
            $rideData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Fermeture de la connexion à la base de données
            $db = null;
            return $rideData;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des données de trajets pour l'année spécifique : " . $e->getMessage();
            return array();
        }
    }

}
