<?php
/**
 * @package DataProvider
 * @author Xavier
 * @version 1.2.1
 * Date: Nov.17
 *
 * Provides all storage-related functions for our friends' data
 * This version uses a MySQL datatbase
 */

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Returns a connection to the database
 *
 */
function dbConnection()
{
    $dbname = "dudes";
    $hostname = "localhost";
    $username = "root";
    $password = "root";
    try
    {
        $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->exec("SET NAMES 'utf8'");
        return $dbh;
    } catch (PDOException $e)
    {
        echo "mysql:host=$hostname;dbname=$dbname, $username, $password)";
        die ("erreur de connexion au serveur (" . $e->getMessage() . ")");
    }
}


/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Read the content of the locally stored data file. The file name is hardcoded
 *
 * @return an array of friend objects
 */
function getFriends()
{
    $dbh = dbConnection();

    $sql = "SELECT idDude, fname, lname, gitname FROM dude";
    $query = $dbh->prepare($sql);
    try {
        $query->execute();
        return $query->fetchAll();
    } catch (PDOException $e) {
        error_log("PDOException in ".$e->getFile()." at line ".$e->getLine().": ".$e->getMessage());
    }
}

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Returns a specific friend from the list, or null if not found
 *
 * @param $id : the friend we want to get
 * @return a friend object
 */
function getFriend($id)
{
    $dbh = dbConnection();

    $sql = "SELECT idDude, fname, lname, gitname FROM dude WHERE idDude= :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    try
    {
        $query->execute();
        return $query->fetch();
    } catch (PDOException $e) {
        error_log("PDOException in ".$e->getFile()." at line ".$e->getLine().": ".$e->getMessage());
    }
}

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Saves the values of the friend passed as parameter.
 *
 * @param $f
 */
function saveFriend($f)
{
    $dbh = dbConnection();

    $sql = "UPDATE dude SET fname= :fname, lname= :lname, gitname= :gitname WHERE idDude= :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(":fname", $f['fname'], PDO::PARAM_STR);
    $query->bindParam(":lname", $f['lname'], PDO::PARAM_STR);
    $query->bindParam(":gitname", $f['gitname'], PDO::PARAM_STR);
    $query->bindParam(":id", $f['idDude'], PDO::PARAM_INT);
    try {
        $query->execute();
        return true;
    } catch (PDOException $e) {
        error_log("PDOException in ".$e->getFile()." at line ".$e->getLine().": ".$e->getMessage());
    }
}

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Add a friend to the list. No sorting is performed. Nochecks are performed
 * @param $f
 */
function addFriend($f)
{
    $dbh = dbConnection();

    $sql = "INSERT INTO dude(fname,lname,gitname) VALUES (:fname, :lname, :gitname)";
    $query = $dbh->prepare($sql);
    $query->bindParam(":fname", $f['fname'], PDO::PARAM_STR);
    $query->bindParam(":lname", $f['lname'], PDO::PARAM_STR);
    $query->bindParam(":gitname", $f['gitname'], PDO::PARAM_STR);
    try {
        $query->execute();
        return true;
    } catch (PDOException $e) {
        error_log("PDOException in ".$e->getFile()." at line ".$e->getLine().": ".$e->getMessage());
    }
}

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Create a new, void, friend, with an id that is 1 above the biggest known id
 *
 * @return a friend object
 */
function newFriend()
{
    $newFriend = array("fname" => "", "lname" => "", "gitname" => "(tbd)");
    return $newFriend;
}

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Destroys a scpecific friend in the list
 * Strategy: iterate over the list and create a list of keepers
 *
 * @param $id
 */
function deleteFriend($id)
{
    $dbh = dbConnection();

    $sql = "DELETE FROM dude WHERE idDude= :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    try {
        $query->execute();
        return true;
    } catch (PDOException $e) {
        error_log("PDOException in ".$e->getFile()." at line ".$e->getLine().": ".$e->getMessage());
    }
}

?>