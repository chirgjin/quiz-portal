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
        $participants[] = $participant;
    }

    return $participants;

}

echo json_encode(fetchUsers());