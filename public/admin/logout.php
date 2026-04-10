<?php
// public/admin/logout.php
require_once dirname(__DIR__, 2) . '/app/bootstrap.php';
Auth::logout();
header('Location: login.php');
exit();