<?php
session_start();
session_unset();
session_destroy();
header('Location: ../ui-form/login_form.php');
exit;
?>
