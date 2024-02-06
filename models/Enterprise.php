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

    public static function create(string $nom, string $email, string $siret, string $mot_de_passe, int $enterprise_id, string $adresse, string $code_postal, string $ville)
    {
        try {
            // Conexion à la base de données
            $db = new PDO(DBNAME, DBUSER, DBPASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Stockage de la requete dans une variable
            $sql = "INSERT INTO enterprise (enterprise_id, enterprise_name, enterprise_email, enterprise_siret, enterprise_adress, enterprise_password, enterprise_zipcode, enterprise_city)
             VALUES (:enterprise_id, :enterprise_name, :enterprise_email, :enterprise_siret, :enterprise_adress, :enterprise_password, :enterprise_zipcode, :enterprise_city)";

            // Préparation de la requête
            $query = $db->prepare($sql);

            // Relier les valeurs aux marqueurs nominatifs
            $query->bindValue(':enterprise_id', htmlspecialchars($enterprise_id), PDO::INT);
            $query->bindValue(':enterprise_name', htmlspecialchars($nom), PDO::PARAM_STR);
            $query->bindValue(':enterprise_email', htmlspecialchars($email), PDO::PARAM_STR);
            $query->bindValue(':enterprise_siret', $siret, PDO::PARAM_STR);
            $query->bindValue(':enterprise_adress', $adresse, PDO::PARAM_STR);
            $query->bindValue(':enterprise_password', password_hash($mot_de_passe, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $query->bindValue(':enterprise_zipcode', $code_postal, PDO::STR);
            $query->bindValue(':enterprise_city', $ville, PDO::PARAM_STR);


            $query->execute();
        } catch (PDOException $e) {
            echo 'Erreur :' . $e->getMessage();
            die();
        }
    }

    /**
     * Methode permettant de récupérer les informations d'un utilisateur avec son mail comme paramètre
     * 
     * @param string $email Adresse mail de l'utilisateur
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
}
