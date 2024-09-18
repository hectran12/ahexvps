<?php




function checkXSSInURI() {
    $currentURI = $_SERVER['REQUEST_URI'];
    $currentURI = urldecode($currentURI);
    $currentURI = htmlspecialchars($currentURI);
    
    if ($currentURI === htmlspecialchars($currentURI)) {
        return $currentURI;
    } else {
        // Handle XSS Injection
        // You can log the attempt or perform other actions here
        return false;
    }
}


function checkInjection ($data) {
    // check and return false if data contains SQL Injection
    if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $data)) {
        return false;
    }
    return true;
}
?>