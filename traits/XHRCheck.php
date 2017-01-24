<?php

trait XHRCheck {
    public function isXHR() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    }
}