<?php

class LoginView {
    public function showLogin($error = null) {
        require 'templates/form_login.phtml';
    }
}