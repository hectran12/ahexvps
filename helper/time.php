<?php

// set date to hcm
date_default_timezone_set('Asia/Ho_Chi_Minh');

function acceptRequestTime ($userInfo, $miniumtime, $service) {
    $timeService = $userInfo["timeRequestServer"];
    if($timeService == null) {
        return true;
    } else {
        $timeService = json_decode($timeService, true);
        if($timeService[$service] == null) {
            return true;
        } else {
            $timeService = $timeService[$service];
            $timeNow = time();
            if($timeNow - $timeService < $miniumtime) {
                return false;
            } else {
                return true;
            }
        }
    }
}


function gettime () {
    return date('Y-m-d H:i:s');
}


?>