<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 28.08.17
 * Time: 15:18
 */

$title="Profil";

extract($_GET); // $page, $id, $new
if (!isset($id) && !isset($new)) // neither view nor create
    $errormessage = "La demande est mal formulée";
else
{
    include($_SERVER["DOCUMENT_ROOT"] . "/sources/providers/friendsProvider.php");
    if (isset($id)) // request to edit existing user
    {
        // try to load data
        $friend = getFriend($id);
        if ($friend == null)
        {
            $errormessage = "La personne demandée n'existe pas";
            $errordetails = "... en tout cas pas dans notre base de données";
        }
    }
    else // new user
    {
        $friend = newFriend();
    }
}

if (isset($errormessage))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/sources/pages/error/error.php");
else
{
    extract ($_POST); // $id, $fname, $lname, $save, $delete, $step
    if (isset($save) || isset($delete) || isset($add)) // an action took place
    {
        if (isset($save)) // Updates have been supplied by POST
        {
            $friend->fname = $fname;
            $friend->lname = $lname;
            $friend->step = $step;
            saveFriend($friend); // persist new values in model
            $flashmsg = "Modifications enregistrées";
        }
        if (isset($delete)) // request to delete
        {
            deleteFriend($id);
            $flashmsg = $friend->fname." ".$friend->lname." a été supprimé de la liste";
        }
        if (isset($add)) // Values for new guy have been supplied by POST
        {
            $friend->fname = $fname;
            $friend->lname = $lname;
            $friend->step = $step;
            addFriend($friend); // persist new values in model
            $flashmsg = $friend->fname." ".$friend->lname." a été ajouté à la liste";
        }
        $friends = getFriends(); // the list view will need all friends
        require_once($_SERVER["DOCUMENT_ROOT"] . "/sources/pages/list/list.html"); // return view content
    }
    else
        require_once($_SERVER["DOCUMENT_ROOT"] . "/sources/pages/profile/profile.html"); // return view content
}

?>