<?php

function SessionError () 
{
    // condition qui dis que si utilisateur n'est pas connecté alors il est renvoyé vers la page login.php
session_start();
if ($_SESSION == false) {
    redirect('login.php?error=' . LoginError::CONNECTION_FAILED);
}
}