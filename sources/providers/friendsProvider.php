<?php
/**
 * @package DataProvider
 * @author Xavier
 * @version 1.1
 * Date: 28.08.17
 * Time: 14:15
 *
 * Provides all storage-related functions for our friends' data
 * This version uses a text file in JSON format and is optimized for code cleanliness, not performance
 */

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Read the content of the locally stored data file. The file name is hardcoded
 *
 * @return an array of friend objects
 */
function getFriends()
{
    return json_decode(file_get_contents("data/friends.json"));
}

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Saves the array passed in parameter in the locally stored data file. The file name is hardcoded
 *
 * @param $friends
 */
function saveFriends($friends)
{
    file_put_contents("data/friends.json", json_encode($friends));
}

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Returns a specific friend from the list, or null if not found
 *
 * @param $id: the friend we want to get
 * @return a friend object
 */
function getFriend($id)
{
    $friends = getFriends();
    foreach ($friends as $friend)
        if ($friend->id == $id) return $friend;
    return null;
}

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Saves the values of the friend passed as parameter.
 *
 * @param $f
 */
function saveFriend($f)
{
    $friends = getFriends();
    foreach ($friends as $key => $friend)
        if ($friend->id == $f->id) // Found the one
            $friends[$key] = $f;  // $friend = $f is not an option because $friend is a copy of the item item in the array
    saveFriends($friends);
}

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Add a friend to the list. No sorting is performed. Nochecks are performed
 * @param $f
 */
function addFriend($f)
{
    $friends = getFriends();
    $friends[] = $f; // add at the end of the list
    saveFriends($friends);
}

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Create a new, void, friend, with an id that is 1 above the biggest known id
 *
 * @return a friend object
 */
function newFriend()
{
    $friends = getFriends();
    $biggest = 0;
    foreach ($friends as $friend)
        if ($friend->id > $biggest) $biggest = $friend->id;
    $newFriend = getFriend($biggest);
    $newFriend->id++;
    $newFriend->fname = "";
    $newFriend->lname = "";
    $newFriend->step = 1;
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
    $friends = getFriends();
    foreach ($friends as $friend)
        if ($friend->id != $id) $keepers[] = $friend;
    saveFriends($keepers);
}

?>