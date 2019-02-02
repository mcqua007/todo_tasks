<?php
// process.php

$errors = array();      // array to hold validation errors
$data = array();      // array to pass back data


// if any of these variables don't exist, add an error to our $errors array

    if (empty($_POST['name']))
        $errors['name'] = 'Name is required.';

    if (empty($_POST['email']))
        $errors['email'] = 'Email is required.';

    if (empty($_POST['superheroAlias']))
        $errors['superheroAlias'] = 'Superhero alias is required.';

// return a response ===========================================================
