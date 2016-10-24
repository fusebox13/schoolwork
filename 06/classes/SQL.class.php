<?php
include 'utils/db_connect.php';

class SQL {
    
    /**
     * Empty Constructor
     */
    function __construct() {
        
    }
    /**
     * DEPRECATED - Used for debugging
     * @global type $pdo
     * @return PDOStatement
     */
    function getAll () {
        \trigger_error("Deprecated.", \E_USER_ERROR);
        global $pdo;
        $sql = "select a6_locations.*, "
                . "a6_people.person_name, "
                . "a6_people.provider_number, "
                . "a6_subject.subject_label "
                . "FROM a6_locations "
                . "JOIN a6_people on a6_locations.locationID = a6_people.locationID "
                . "JOIN a6_people_subject ON a6_people.personID = a6_people_subject.personID "
                . "JOIN a6_subject ON a6_people_subject.subjectID = a6_subject.subjectID "
                . "ORDER BY locationID DESC";
        return $pdo->query($sql);
    }
    
    /**
     * Gets the location based on the zipcode
     * @global type $pdo
     * @param type $zipcode
     * @return Mixed
     */
    function getLocation($zipcode) {
        global $pdo;
        $sql = "select * "
                . "FROM a6_locations "
                . "WHERE zipcode = ? "
                . "LIMIT 1";
        $query = $pdo->prepare($sql);
        $params = array($zipcode);
        $query->execute($params);
        if ($query->rowCount() > 0) {
            return $query->fetchObject();
        } else {
            return null;
        }
    }
    
    /**
     * Returns all results within the radius of the latitude and longitude
     * @global type $pdo
     * @param type $lat
     * @param type $long
     * @param type $radius
     * @return PDOStatement
     */
    function getResults($lat, $long, $radius) {
        global $pdo;
        $sql = "select a6_locations.*, "
                . "a6_people.person_name, "
                . "a6_people.personID, "
                . "a6_people.provider_number, "
                . "GROUP_CONCAT(a6_subject.subject_label SEPARATOR ', ') AS subject_label, "
                . "69.0 * SQRT(POW((FORMAT(latitude,4)-FORMAT($lat,4)),2) + POW((FORMAT(longitude, 4)-FORMAT($long,4)),2)) AS distance "
                . "FROM a6_locations "
                . "JOIN a6_people on a6_locations.locationID = a6_people.locationID "
                . "JOIN a6_people_subject ON a6_people.personID = a6_people_subject.personID "
                . "JOIN a6_subject ON a6_people_subject.subjectID = a6_subject.subjectID "
                . "GROUP BY a6_people.personID "
                . "HAVING distance < $radius "
                . "ORDER BY distance ASC, provider_number ASC";
        return $pdo->query($sql);
        
    }
    
    
    
}
