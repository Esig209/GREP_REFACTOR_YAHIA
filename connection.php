
<?php  
define('DB_HOST', 'hhva.myd.infomaniak.com');
define('DB_NAME', 'hhva_t24_8_v2');
define('DB_USER', 'hhva_t24_8_v2');
define('DB_PASS', '1kChruwd5');

function getConnexion()
{
    static $bdd = null;
    if ($bdd === null) {
        try {
            $connectionString = 'mysql:host=' .  DB_HOST . ';dbname=' . DB_NAME . '';
            $bdd = new PDO($connectionString, DB_USER, DB_PASS, array('charset' => 'utf8'));
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur  : ' . $e->getMessage());
        }
    }
    return $bdd;
}

?>