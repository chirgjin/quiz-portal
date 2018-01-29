<?php
/**
 * Function to Fetch Users from API
 *
 * @category FetchData
 * @package  QuizportalFetchData
 * @author   Chirgjin <chirgjin@gmail.com>
 * @license  idk idk
 * @link     http://api/webathon-api
 */

require_once __DIR__ . "/user.class.php";

/**
 * Fetch Data from API
 *
 * @param string $url url of api
 *
 * @return mixed data
 */
function fetchUsers($url = "https://nsc-api.herokuapp.com/nsc/api/webathon_api")
{
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    $json = json_decode($result);

    if (!$json || !is_object($json)
        || !isset($json->meta) || !isset($json->meta->status)
        || $json->meta->status != 1
    ) {
        return 0;
    }

    $participants = array();

    foreach ($json->participants as $participant) {
        if (!$participant->has_paid)
            continue;
        
        //Add Data to db..
        $user = new USER;
        $participants[] = $participant;
        $profile = $participant->participant;

        if ($participant->team == null) {
            //isLoner..
            $user->set("team_code", null)->set("team_name", null);
            $user->set("email", $profile->email)->set("phone", $profile->phone);
        } else {
            //isTeam..
            $user->set("team_name", $participant->team->team_name)->set("team_code", $participant->team->team_code);
        }

        if ($user->fetch()) {
            //User Exists -> do nothing
            continue ;
        }

        $usr = $participant->participant->user;
        $user->set("name", $usr->first_name . " " . $usr->last_name);
        $user->set("email", $profile->email)->set("phone", $profile->phone);

        $user->save(1);

        $participant->user = $user;
    }

    return $participants;

}

print_r(fetchUsers());

/**
 * Update marks
 * 
 * @return users
 */
function updateMarks()
{
    $users = (new USER)->fetchAll();

    foreach ($users as $user) {
        $submissions = $user->submissions();

        $marks = 0;

        foreach ($submissions as $submission) {
            $marks += $submission->calculateMarks();
        }

        $user->marks = $marks;
        $user->update();
    }

    return $users;
}

print_r( updateMarks() );