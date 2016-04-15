<?php

function distance($lat1, $lng1, $lat2, $lng2, $unit = "M") {

    $theta = $lng1 - $lng2;
    if($theta == 0 && ($lat1 == $lat2)) return 0;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);
    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

function is_grower($user) {
    if($user && isset($user->purpose) && !empty($user->purpose)) {
        $purposes = json_decode($user->purpose);
        if(!is_array($purposes)) return false;
        if(in_array('grower', $purposes)) return true;
    }
    return false;
}

function has_purpose($purpose, $user) {
    if($user && isset($user->purpose) && !empty($user->purpose)) {
        if(!is_array($user->purpose)) {
            $purposes = json_decode($user->purpose);
        }else{
            $purposes = $user->purpose;
        }
        if(!is_array($purposes)) return false;
        if(in_array($purpose, $purposes)) return true;
    }
    return false;
}

function object_to_array($obj) {
    return json_decode(json_encode($obj), true);
}

function array_to_object($arr) {
    return json_decode(json_encode($arr));
}