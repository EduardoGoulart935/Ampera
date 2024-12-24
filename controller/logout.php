<?php
@session_start();
session_destroy();
header("Location: /Ampera/login");
exit;
