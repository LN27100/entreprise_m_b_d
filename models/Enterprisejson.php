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
 * Méthode pour vérifier si un email existe déjà dans la base de données
 * 
 * @param string $email L'adresse email à vérifier
 * @return string JSON contenant le statut de la vérification
 */
    public static function checkMailExists(string $email): string
{
    try {
        // Connexion à la base de données
        $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
        
        // Requête SQL pour vérifier si l'email existe dans la base de données
        $sql = "SELECT * FROM `enterprise` WHERE `enterprise_email` = :enterprise_email";
        $query = $db->prepare($sql);
        $query->bindValue(':enterprise_email', $email, PDO::PARAM_STR);
        $query->execute();
        
        // Récupération du résultat de la requête
        $result = $query->fetch(PDO::FETCH_ASSOC);

        // Vérification si l'email existe ou non
        if (empty($result)) {
            // Si l'email n'existe pas, retourner un JSON avec le statut succès et exists à false
            return json_encode([
                'status' => 'success',
                'exists' => false
            ]);
        } else {
            // Si l'email existe, retourner un JSON avec le statut succès et exists à true
            return json_encode([
                'status' => 'success',
                'exists' => true
            ]);
        }
    } catch (PDOException $e) {
        // En cas d'erreur PDO, retourner un JSON avec le statut erreur et le message d'erreur
        return json_encode([
            'status' => 'error',
            'message' => 'Erreur : ' . $e->getMessage()
        ]);
    }
}

    /**
 * Méthode pour récupérer les informations d'une entreprise basées sur son adresse email
 * 
 * @param string $email L'adresse email de l'entreprise
 * @return string JSON contenant les informations de l'entreprise
 */
    public static function getInfos(string $email): string
    {
        try {
            // Connexion à la base de données
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
            
            // Requête SQL pour récupérer les informations de l'entreprise par email
            $sql = "SELECT * FROM `enterprise` WHERE `enterprise_email` = :enterprise_email";
            $query = $db->prepare($sql);
            $query->bindValue(':enterprise_email', $email, PDO::PARAM_STR);
            $query->execute();
            
            // Récupération du résultat de la requête
            $result = $query->fetch(PDO::FETCH_ASSOC);
    
            // Retourne un JSON avec le statut succès et les données récupérées, ou un tableau vide si aucun résultat
            return json_encode([
                'status' => 'success',
                'data' => $result ?? [] // Si aucun résultat, retourne un tableau vide
            ]);
        } catch (PDOException $e) {
            // En cas d'erreur PDO, retourne un JSON avec le statut erreur et le message d'erreur
            return json_encode([
                'status' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }
    

   /**
 * Méthode pour mettre à jour le chemin de l'image de profil d'une entreprise
 * 
 * @param int $enterprise_id L'identifiant de l'entreprise
 * @param string $new_image_path Le nouveau chemin de l'image de profil
 * @return void
 */

     public static function updateProfileImage(int $enterprise_id, string $new_image_path): void
     {
         try {
             // Connexion à la base de données
             $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
             $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
             // Génération du nouveau nom de fichier pour l'image de profil
             $file_extension = pathinfo($new_image_path, PATHINFO_EXTENSION);
             $new_file_name = "profile_" . $enterprise_id . "." . $file_extension;
             $new_image_path_with_enterprise_id = '../assets/uploads/' . $new_file_name;
     
             // Requête SQL pour mettre à jour le chemin de l'image de profil dans la base de données
             $sql = "UPDATE enterprise SET enterprise_photo = :new_image_path WHERE enterprise_id = :enterprise_id";
             $query = $db->prepare($sql);
             $query->bindValue(':new_image_path', $new_image_path_with_enterprise_id, PDO::PARAM_STR);
             $query->bindValue(':enterprise_id', $enterprise_id, PDO::PARAM_INT);
             $query->execute();
     
             // Retourne un JSON avec le statut succès et un message de succès
             echo json_encode([
                 'status' => 'success',
                 'message' => 'Image de profil mise à jour avec succès'
             ]);
         } catch (PDOException $e) {
             // En cas d'erreur PDO, retourne un JSON avec le statut erreur et le message d'erreur
             echo json_encode([
                 'status' => 'error',
                 'message' => 'Erreur : ' . $e->getMessage()
             ]);
         }
     }


   /**
 * Méthode pour mettre à jour le profil d'une entreprise
 * 
 * @param int $enterprise_id L'identifiant de l'entreprise
 * @param string $new_name Le nouveau nom de l'entreprise
 * @param string $new_email Le nouvel email de l'entreprise
 * @param string $new_adress La nouvelle adresse de l'entreprise
 * @param string $new_zipcode Le nouveau code postal de l'entreprise
 * @param string $new_city La nouvelle ville de l'entreprise
 * @return void
 */
    public static function updateProfil(int $enterprise_id, string $new_name, string $new_email, string $new_adress, string $new_zipcode, string $new_city): void
{
    try {
        // Connexion à la base de données
        $db = new PDO(DBNAME, DBUSER, DBPASSWORD, array(PDO::ATTR_PERSISTENT => true));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour mettre à jour les informations du profil de l'entreprise
        $sql = "UPDATE enterprise 
                 SET enterprise_name = :new_name, 
                     enterprise_email = :new_email, 
                     enterprise_adress = :new_adress, 
                     enterprise_zipcode = :new_zipcode,
                     enterprise_city = :new_city
                 WHERE enterprise_id = :enterprise_id";

        // Préparation de la requête
        $query = $db->prepare($sql);

        // Liaison des valeurs des paramètres
        $query->bindValue(':new_name', $new_name, PDO::PARAM_STR);
        $query->bindValue(':new_email', $new_email, PDO::PARAM_STR);
        $query->bindValue(':new_adress', $new_adress, PDO::PARAM_STR);
        $query->bindValue(':new_zipcode', $new_zipcode, PDO::PARAM_STR);
        $query->bindValue(':new_city', $new_city, PDO::PARAM_STR);
        $query->bindValue(':enterprise_id', $enterprise_id, PDO::PARAM_INT);

        // Exécution de la requête
        $query->execute();

        // Retourne un JSON avec le statut succès et un message de succès
        echo json_encode([
            'status' => 'success',
            'message' => 'Profil mis à jour avec succès'
        ]);
    } catch (PDOException $e) {
        // En cas d'erreur PDO, retourne un JSON avec le statut erreur et le message d'erreur
        error_log('Erreur lors de la mise à jour du profil : ' . $e->getMessage());
        echo json_encode([
            'status' => 'error',
            'message' => 'Une erreur s\'est produite lors de la mise à jour du profil.'
        ]);
    }
}


   /**
 * Méthode pour supprimer une entreprise
 * 
 * @param int $enterprise_id L'identifiant de l'entreprise à supprimer
 * @return string Un message indiquant le statut de la suppression
 */

     public static function deleteEnterprise(int $enterprise_id): string
     {
         try {
             // Connexion à la base de données
             $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
     
             // Requête SQL pour supprimer l'entreprise
             $sql = "DELETE FROM enterprise WHERE enterprise_id = :enterprise_id";
             $query = $db->prepare($sql);
             $query->bindValue(':enterprise_id', $enterprise_id, PDO::PARAM_INT);
             $query->execute();
     
             // Suppression de la session et du mot de passe de la session
             session_destroy();
             unset($_SESSION['enterprise_password']);
     
             // Retourne un JSON avec le statut succès
             return json_encode([
                 'status' => 'success'
             ]);
         } catch (PDOException $e) {
             // En cas d'erreur PDO, retourne un JSON avec le statut erreur et le message d'erreur
             return json_encode([
                 'status' => 'error',
                 'message' => 'Erreur : ' . $e->getMessage()
             ]);
         }
     }
     

     /**
 * Méthode pour récupérer le nombre total d'utilisateurs d'une entreprise
 * 
 * @param int $entreprise_id L'identifiant de l'entreprise
 * @return string JSON contenant le nombre total d'utilisateurs
 */
     public static function getAllUtilisateurs(int $entreprise_id): string
     {
         try {
             // Connexion à la base de données
             $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
     
             // Requête SQL pour compter le nombre d'utilisateurs
             $sql = "SELECT count(`user_pseudo`) as 'Total utilisateurs'  FROM `userprofil` where `enterprise_id` = :id_entreprise;";
     
             // Préparation de la requête
             $query = $db->prepare($sql);
     
             // Liaison des valeurs des paramètres
             $query->bindValue(':id_entreprise', $entreprise_id, PDO::PARAM_INT);
     
             // Exécution de la requête
             $query->execute();
     
             // Récupération du résultat
             $result = $query->fetch(PDO::FETCH_ASSOC);
     
             // Retourne un JSON avec le statut succès et les données récupérées
             return json_encode([
                 'status' => 'success',
                 'total_users' => $result['Total utilisateurs']
             ]);
         } catch (PDOException $e) {
             // En cas d'erreur PDO, retourne un JSON avec le statut erreur et le message d'erreur
             return json_encode([
                 'status' => 'error',
                 'message' => 'Erreur : ' . $e->getMessage()
             ]);
         }
     }


     /**
 * Méthode pour récupérer le nombre d'utilisateurs actifs d'une entreprise
 * 
 * @param int $entreprise_id L'identifiant de l'entreprise
 * @return string JSON contenant le nombre d'utilisateurs actifs
 */
    public static function getActifUtilisateurs(int $entreprise_id): string
{
    try {
        // Connexion à la base de données
        $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

        // Requête SQL pour compter le nombre d'utilisateurs actifs
        $sql = "SELECT DISTINCT userprofil.*
                FROM `userprofil`
                JOIN `ride` ON userprofil.`user_id` = ride.`user_id`
                WHERE userprofil.`enterprise_id` = :id_entreprise;";

        // Préparation de la requête
        $query = $db->prepare($sql);

        // Liaison des valeurs des paramètres
        $query->bindValue(':id_entreprise', $entreprise_id, PDO::PARAM_INT);

        // Exécution de la requête
        $query->execute();

        // Récupération du nombre d'utilisateurs actifs
        $count = $query->rowCount();

        // Retourne un JSON avec le statut succès et le nombre d'utilisateurs actifs
        return json_encode([
            'status' => 'success',
            'active_users' => $count
        ]);
    } catch (PDOException $e) {
        // En cas d'erreur PDO, retourne un JSON avec le statut erreur et le message d'erreur
        return json_encode([
            'status' => 'error',
            'message' => 'Erreur : ' . $e->getMessage()
        ]);
    }
}



/**
 * Méthode pour récupérer le nombre total de trajets effectués par une entreprise
 * 
 * @param int $entreprise_id L'identifiant de l'entreprise
 * @return string JSON contenant le nombre total de trajets
 */
public static function getAllTrajets(int $entreprise_id): string
{
    try {
        // Connexion à la base de données
        $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

        // Requête SQL pour compter le nombre total de trajets
        $sql = "SELECT count('ride_id') AS 'Total des trajets' FROM `ride` 
                JOIN `userprofil` ON ride.`user_id` = userprofil.`user_id`
                WHERE `enterprise_id` = :id_entreprise;";

        // Préparation de la requête
        $query = $db->prepare($sql);

        // Liaison des valeurs des paramètres
        $query->bindValue(':id_entreprise', $entreprise_id, PDO::PARAM_INT);

        // Exécution de la requête
        $query->execute();

        // Récupération du résultat
        $result = $query->fetch(PDO::FETCH_ASSOC);

        // Retourne un JSON avec le statut succès et le nombre total de trajets
        return json_encode([
            'status' => 'success',
            'total_trips' => $result['Total des trajets']
        ]);
    } catch (PDOException $e) {
        // En cas d'erreur PDO, retourne un JSON avec le statut erreur et le message d'erreur
        return json_encode([
            'status' => 'error',
            'message' => 'Erreur : ' . $e->getMessage()
        ]);
    }
}



/**
 * Méthode pour récupérer les cinq derniers utilisateurs d'une entreprise
 * 
 * @param int $entreprise_id L'identifiant de l'entreprise
 * @return string JSON contenant les cinq derniers utilisateurs
 */
public static function getlastfiveusers(int $entreprise_id): string
{
    try {
        // Connexion à la base de données
        $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

        // Requête SQL pour récupérer les cinq derniers utilisateurs
        $sql = "SELECT `user_photo`, `user_pseudo` FROM `userprofil` 
                WHERE `enterprise_id` = :id_entreprise
                ORDER BY `user_id` DESC LIMIT 5";

        // Préparation de la requête
        $query = $db->prepare($sql);

        // Liaison des valeurs des paramètres
        $query->bindValue(':id_entreprise', $entreprise_id, PDO::PARAM_INT);

        // Exécution de la requête
        $query->execute();

        // Récupération du résultat
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        // Retourne un JSON avec le statut succès et les cinq derniers utilisateurs
        return json_encode([
            'status' => 'success',
            'last_five_users' => $result
        ]);
    } catch (PDOException $e) {
        // En cas d'erreur PDO, retourne un JSON avec le statut erreur et le message d'erreur
        return json_encode([
            'status' => 'error',
            'message' => 'Erreur : ' . $e->getMessage()
        ]);
    }
}



/**
 * Méthode pour récupérer les cinq derniers trajets effectués par des utilisateurs de l'entreprise
 * 
 * @param int $entreprise_id L'identifiant de l'entreprise
 * @return string JSON contenant les cinq derniers trajets
 */
public static function getlastfivejourneys(int $entreprise_id): string
{
    try {
        // Connexion à la base de données
        $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

        // Requête SQL pour récupérer les cinq derniers trajets
        $sql = "SELECT DATE_FORMAT(ride.ride_date, '%d/%m/%Y') AS date_fr, ride.`ride_distance`, userprofil.`user_pseudo` , transport.`transport_type`
                FROM `ride`
                JOIN `userprofil`  ON ride.`user_id` = userprofil.`user_id`
                JOIN `transport` ON ride.`transport_id` = transport.`transport_id`
                JOIN `enterprise`  ON userprofil.`enterprise_id` = enterprise.`enterprise_id`
                WHERE enterprise.`enterprise_id` = :enterprise_id
                ORDER BY ride.`ride_date` DESC 
                LIMIT 5";

        // Préparation de la requête
        $query = $db->prepare($sql);
        $query->bindValue(':enterprise_id', $entreprise_id, PDO::PARAM_INT);

        // Exécution de la requête
        $query->execute();

        // Récupération du résultat
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        // Retourne un JSON avec le statut succès et les cinq derniers trajets
        return json_encode([
            'status' => 'success',
            'last_five_journeys' => $result
        ]);
    } catch (PDOException $e) {
        // En cas d'erreur PDO, retourne un JSON avec le statut erreur et le message d'erreur
        return json_encode([
            'status' => 'error',
            'message' => 'Erreur : ' . $e->getMessage()
        ]);
    }
}



   /**
 * Méthode pour récupérer les statistiques des moyens de transport pour une entreprise donnée
 * 
 * @param int $entreprise_id L'identifiant de l'entreprise
 * @return string JSON contenant les statistiques des moyens de transport
 */
    public static function getTransportStats(int $entreprise_id): string
{
    try {
        // Connexion à la base de données
        $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

        // Requête SQL pour récupérer les statistiques de transport
        $sql = "SELECT transport_type, COUNT(*) as stats FROM `transport` 
                NATURAL JOIN `userprofil`
                NATURAL JOIN `enterprise`
                NATURAL JOIN `ride`
                where enterprise_id = :enterprise_id
                GROUP BY transport_type;";

        // Préparation de la requête
        $query = $db->prepare($sql);
        $query->bindValue(':enterprise_id', $entreprise_id, PDO::PARAM_INT);

        // Exécution de la requête
        $query->execute();

        // Récupération du résultat
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        // Retourne un JSON avec le statut succès et les statistiques de transport
        return json_encode([
            'status' => 'success',
            'transport_stats' => $result
        ]);
    } catch (PDOException $e) {
        // En cas d'erreur PDO, retourne un JSON avec le statut erreur et le message d'erreur
        return json_encode([
            'status' => 'error',
            'message' => 'Erreur : ' . $e->getMessage()
        ]);
    }
}



    /**
 * Méthode pour récupérer les données de trajets pour une entreprise donnée et une année spécifique
 * 
 * @param int $enterprise_id L'identifiant de l'entreprise
 * @param int $year L'année spécifique
 * @return string JSON contenant les données de trajets
 */

     public static function getRideDataForYear(int $enterprise_id, int $year): string
     {
         try {
             // Connexion à la base de données
             $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
     
             // Requête SQL pour récupérer les données de trajets pour une année spécifique
             $query = "SELECT MONTH(ride_date) AS month, COUNT(*) AS total_rides
                       FROM ride
                       NATURAL JOIN `enterprise`
                       WHERE enterprise_id = :enterprise_id
                       AND YEAR(ride_date) = :years
                       GROUP BY MONTH(ride_date)";
     
             // Préparation de la requête
             $stmt = $db->prepare($query);
             $stmt->bindParam(':enterprise_id', $enterprise_id, PDO::PARAM_INT);
             $stmt->bindParam(':years', $year, PDO::PARAM_INT);
     
             // Exécution de la requête
             $stmt->execute();
     
             // Récupération du résultat
             $rideData = $stmt->fetchAll(PDO::FETCH_ASSOC);
     
             // Retourne un JSON avec le statut succès et les données de trajets pour l'année spécifiée
             return json_encode([
                 'status' => 'success',
                 'ride_data_for_year' => $rideData
             ]);
         } catch (PDOException $e) {
             // En cas d'erreur PDO, retourne un JSON avec le statut erreur et le message d'erreur
             return json_encode([
                 'status' => 'error',
                 'message' => 'Erreur lors de la récupération des données de trajets pour l\'année spécifique : ' . $e->getMessage()
             ]);
         }
     }
     

    /**
     * Méthode permettant de récupérer toutes les entreprises sous forme de JSON
     * 
     * @return string JSON contenant les données des entreprises
     */
    public static function newGetAllEntreprise(): string
    {
        try {
            // Connexion à la base de données
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

            // Préparation de la requête SQL
            $sql = "SELECT * FROM enterprise";

            // Préparation de la requête
            $query = $db->prepare($sql);

            // Exécution de la requête
            $query->execute();

            // Récupération du résultat sous forme de tableau associatif
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            // Fermeture de la connexion à la base de données
            $db = null;

            // Convertion du résultat en JSON et  on le retourne
            return json_encode([
                'status' => 'success',
                'message' => 'Entreprises récupérées',
                'data' => $result
            ]);
        } catch (PDOException $e) {
            // message d'erreur
            return json_encode([
                'status' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }
}
