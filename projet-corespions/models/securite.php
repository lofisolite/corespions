<?php

const COOKIE_PROTECT = "timer";

function SecureData($string){
    return htmlspecialchars($string);
}

function genereCookieSession(){
    $timerCookie = session_id().microtime().rand(0,55555);
    $timerCookie = hash("sha256", $timerCookie);
    setCookie(COOKIE_PROTECT, $timerCookie, time() + (60 * 60));
    $_SESSION[COOKIE_PROTECT] = $timerCookie;
}

function verifyCookies(){ 
    if(isset($_SESSION[COOKIE_PROTECT]) && isset($_COOKIE[COOKIE_PROTECT]) && $_SESSION[COOKIE_PROTECT] === $_COOKIE[COOKIE_PROTECT]){
        return true;
    } else {
        session_destroy();
        unset($_SESSION[COOKIE_PROTECT]);
        unset($_SESSION["access"]);
        throw new Exception("Vous avez été déconnecté");
    } 
}

function verifyAccessSession(){
    return (isset($_SESSION['access']) && !empty($_SESSION['access']) && ($_SESSION['access'] === "admin"));
}

function verifyAccess(){
    return(verifyAccessSession() && verifyCookies());
}
