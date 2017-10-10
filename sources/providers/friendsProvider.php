<?php
/**
 * @package DataProvider
 * @author Xavier
 * @version 1.2
 * Date: Oct.17
 *
 * Provides all storage-related functions for our friends' data
 * This version uses a MySQL datatbase
 */

// Initialize $dbh, the database handler

$dbname = "dudes";
$hostname = "localhost";
$username = "root";
$password = "root";
try
{
    $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e)
{
    echo "mysql:host=$hostname;dbname=$dbname, $username, $password)";
    die ("erreur de connexion au serveur (" . $e->getMessage() . ")");
}
$dbh->exec("SET NAMES 'utf8'");


/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Read the content of the locally stored data file. The file name is hardcoded
 *
 * @return an array of friend objects
 */
function getFriends()
{
    global $dbh;

    $sql = "SELECT idDude, fname, lname, gitname FROM dude";
    $query = $dbh->prepare($sql);
    if ($query->execute())
        return $query->fetchAll();
    else
        die ("SQL Error in " . __FILE__ . ":" . __LINE__ . " :<br>$sql<br>Error message:" . $dbh->errorInfo()[2]);
}

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Returns a specific friend from the list, or null if not found
 *
 * @param $id : the friend we want to get
 * @return a friend object
 */
function getFriend($id)
{
    global $dbh;

    $sql = "SELECT idDude, fname, lname, gitname FROM dude WHERE idDude= :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    if ($query->execute())
        return $query->fetch();
    else
    {
        error_log("SQL Error in " . __FILE__ . ":" . __LINE__ . " :<br>$sql<br>Error message:" . $dbh->errorInfo()[2]);
        return false;
    }
}

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Saves the values of the friend passed as parameter.
 *
 * @param $f
 */
function saveFriend($f)
{
    global $dbh;

    $sql = "UPDATE dude SET fname= :fname, lname= :lname, gitname= :gitname WHERE idDude= :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(":fname", $f['fname'], PDO::PARAM_STR);
    $query->bindParam(":lname", $f['lname'], PDO::PARAM_STR);
    $query->bindParam(":gitname", $f['gitname'], PDO::PARAM_STR);
    $query->bindParam(":id", $f['idDude'], PDO::PARAM_INT);
    if ($query->execute())
        return true;
    else
    {
        error_log("SQL Error in " . __FILE__ . ":" . __LINE__ . " :<br>$sql<br>Error message:" . $dbh->errorInfo()[2]);
        return false;
    }
}

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Add a friend to the list. No sorting is performed. Nochecks are performed
 * @param $f
 */
function addFriend($f)
{
    global $dbh;

    $sql = "INSERT INTO dude(fname,lname,gitname) VALUES (:fname, :lname, :gitname)";
    $query = $dbh->prepare($sql);
    $query->bindParam(":fname", $f['fname'], PDO::PARAM_STR);
    $query->bindParam(":lname", $f['lname'], PDO::PARAM_STR);
    $query->bindParam(":gitname", $f['gitname'], PDO::PARAM_STR);
    if ($query->execute())
        return true;
    else
    {
        error_log("SQL Error in " . __FILE__ . ":" . __LINE__ . " :<br>$sql<br>Error message:" . $dbh->errorInfo()[2]);
        return false;
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
    global $dbh;

    $sql = "DELETE FROM dude WHERE idDude= :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    if ($query->execute())
        return true;
    else
    {
        error_log("SQL Error in " . __FILE__ . ":" . __LINE__ . " :<br>$sql<br>Error message:" . $dbh->errorInfo()[2]);
        return false;
    }
}

?>