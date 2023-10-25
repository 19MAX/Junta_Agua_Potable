<?php

function _load_session(){
    if (session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
}

function save_session($data){
    try {
        _load_session();
        $_SESSION['session'] = $data;
    } catch (Exception $e) {
        exit();
    }
}

function get_cookied_session(){
    try{
        _load_session();
        if (isset($_SESSION['session'])){
            return $_SESSION['session'];
        } else {
            return null;
        }
    } catch (Exception) {
        return null;
    }
}

function delete_session(){
    try{
        _load_session();
        unset($_SESSION['session']);
    } catch (Exception $e) {
        exit();
    }
}
