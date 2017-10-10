<?php
/**
 * Purpose: Profile controller. Handles CRUD on users
 * User: Xavier
 * Date: 28.08.17
 * Time: 15:18
 */

$title = "Profil";

if (!isset($id)) // neither view nor create
    $errormessage = "La demande est mal formulée";
else
{
    include($_SERVER["DOCUMENT_ROOT"] . "/sources/providers/friendsProvider.php");
    if ($id == "new") // request to create user
    {
        $friend = newFriend();
    } else // existing user
    {
        // try to load data
        $friend = getFriend($id);
        if ($friend == null)
        {
            $errormessage = "La personne demandée n'existe pas";
            $errordetails = "... en tout cas pas dans notre base de données";
        }
    }

    if (isset($errormessage))
        require_once($_SERVER["DOCUMENT_ROOT"] . "/sources/pages/error/error.php");
    else
    {
        extract($_POST); // $id, $fname, $lname, $save, $delete, $step, $gitname
        if (isset($save) || isset($delete) || isset($add)) // an action took place
        {
            if (isset($save)) // Updates have been supplied by POST
            {
                $friend['fname'] = $fname;
                $friend['lname'] = $lname;
                $friend['gitname'] = $gitname;
                if (saveFriend($friend)) // persist new values in model
                    $flashmsg = "Modifications enregistrées";
                else
                    $errormessage = "Erreur d'enregistrement";
            }
            if (isset($delete)) // request to delete
            {
                if (deleteFriend($id))
                    $flashmsg = $friend['fname'] . " " . $friend['lname'] . " a été supprimé de la liste";
                else
                    $errormessage = "Erreur d'effacement";
            }
            if (isset($add)) // Values for new guy have been supplied by POST
            {
                $friend['fname'] = $fname;
                $friend['lname'] = $lname;
                $friend['gitname'] = $gitname;
                if (addFriend($friend)) // persist new values in model
                    $flashmsg = $friend['fname'] . " " . $friend['lname'] . " a été ajouté à la liste";
                else
                    $errormessage = "Erreur de création";
            }
            $friends = getFriends(); // the list view will need all friends
            require_once($_SERVER["DOCUMENT_ROOT"] . "/sources/pages/list/list.html"); // return view content
        } else
            if ($id == "new")
                require_once($_SERVER["DOCUMENT_ROOT"] . "/sources/pages/profile/newprofile.html"); // return view content
            else
                require_once($_SERVER["DOCUMENT_ROOT"] . "/sources/pages/profile/editprofile.html"); // return view content
    }
}
?>