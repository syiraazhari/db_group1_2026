<?php
session_start();
session_unset();
session_destroy();

echo "<script>
        alert('You have logged out successfully.');
        window.location='../customer/register.php';
      </script>";
exit();
?>