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
            $sql = "SELECT COUNT(*) AS total_utilisateurs FROM `userprofil` WHERE `enterprise_id` = :entreprise_id";

            // Préparation de la requête
            $query = $db->prepare($sql);

            // Liaison des valeurs des paramètres
            $query->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);

            // Exécution de la requête
            $query->execute();

            // Récupération du résultat
            $result = $query->fetch(PDO::FETCH_ASSOC);

            // Retourne un JSON avec le statut succès et le nombre total d'utilisateurs
            return json_encode([
                'status' => 'success',
                'total_utilisateurs' => $result['total_utilisateurs']
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
            $sql = "SELECT COUNT(DISTINCT userprofil.user_id) AS total_active_users
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
            $result = $query->fetch(PDO::FETCH_ASSOC);

            // Retourne un JSON avec le statut succès et le nombre d'utilisateurs actifs
            return json_encode([
                'status' => 'success',
                'data' => $result
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
            // stockage de ma requete dans une variable
            $sql = "SELECT count('ride_id') AS 'total_trajets' FROM `ride` 
            JOIN `userprofil` ON ride.`user_id` = userprofil.`user_id`
            WHERE `enterprise_id` = :entreprise_id;";

            // Préparation de la requête
            $query = $db->prepare($sql);

            // Liaison des valeurs des paramètres
            $query->bindValue(':entreprise_id', $entreprise_id, PDO::PARAM_INT);

            // Exécution de la requête
            $query->execute();

            // Récupération du résultat
            $result = $query->fetch(PDO::FETCH_ASSOC);

            // Retourne un JSON avec le statut succès et le nombre total de trajets
            return json_encode([
                'status' => 'success',
                'total_trajets' => $result['total_trajets']
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

            // Retourne le résultat encodé en JSON
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
            $rideData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Fermeture de la connexion à la base de données
            $db = null;
            return $rideData;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des données de trajets pour l'année spécifique : " . $e->getMessage();
            return array();
        }
    }

     /**
     * Méthode pour récupérer tous les utilisateurs d'une entreprise
     * 
     * @param int $entreprise_id L'identifiant de l'entreprise
     * @return string JSON contenant tous les utilisateurs
     */
    public static function getAllusers(int $entreprise_id): string
    {
        try {
            // Connexion à la base de données
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

            // Requête SQL pour récupérer tous les utilisateurs
            $sql = "SELECT `user_photo`, `user_pseudo`, `user_email` FROM `userprofil` 
                WHERE `enterprise_id` = :id_entreprise
                ORDER BY `user_id`";

            // Préparation de la requête
            $query = $db->prepare($sql);

            // Liaison des valeurs des paramètres
            $query->bindValue(':id_entreprise', $entreprise_id, PDO::PARAM_INT);

            // Exécution de la requête
            $query->execute();

            // Récupération du résultat
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            // Retourne le résultat encodé en JSON
            return json_encode([
                'status' => 'success',
                'all_users' => $result
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
     * Méthode pour modifier le status des utilisateurs en validé
     * 
     * @param int $entreprise_id L'identifiant de l'entreprise
     * @return string JSON contenant les status des utilisateurs validés
     */
    public static function getvalidateUser(int $user_id): string
    {
        try {
            // Connexion à la base de données
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

            // Requête SQL pour récupérer le statut
            $sql = "UPDATE userprofil SET user_validate = '1' WHERE user_id = :user_id
            AND enterprise_id = :enterprise_id";

            // Préparation de la requête
            $query = $db->prepare($sql);
            $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);

            // Exécution de la requête
            $query->execute();

            // Récupération du résultat
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            // Retourne un JSON avec le statut succès et les utilisateurs validés
            return json_encode([
                'status' => 'success',
                'user_validation' => $result
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
     * Méthode pour modifier le status des utilisateurs en suspendu
     * 
     * @param int $entreprise_id L'identifiant de l'entreprise
     * @return string JSON contenant les status des utilisateurs suspendus
     */
    public static function getinvalidateUser(int $user_id): string
    {
        try {
            // Connexion à la base de données
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);

            // Requête SQL pour récupérer le statut
            $sql = "UPDATE userprofil SET user_validate = '0' WHERE user_id = :user_id
            AND enterprise_id = :enterprise_id";

            // Préparation de la requête
            $query = $db->prepare($sql);
            $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);

            // Exécution de la requête
            $query->execute();

            // Récupération du résultat
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            // Retourne un JSON avec le statut succès et les utilisateurs validés
            return json_encode([
                'status' => 'success',
                'user_invalidated' => $result
            ]);
        } catch (PDOException $e) {
            // En cas d'erreur PDO, retourne un JSON avec le statut erreur et le message d'erreur
            return json_encode([
                'status' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

}
