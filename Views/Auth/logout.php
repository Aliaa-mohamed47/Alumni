<?php
session_start();
// إلغاء الجلسة
session_unset();
session_destroy();
// التوجيه إلى صفحة تسجيل الدخول
header("Location: login.php");
exit();
?>
