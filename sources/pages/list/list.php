<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 25.08.17
 * Time: 15:55
 */

include($_SERVER["DOCUMENT_ROOT"] . "/sources/providers/friendsProvider.php");
$friends = getFriends();
$title="Liste";

require_once ($_SERVER["DOCUMENT_ROOT"] . "/sources/pages/list/list.html");

?>