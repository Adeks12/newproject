<?php
require_once '../libs/SecurityService.php';
$antiCSRF = new \NRFA\SecurityService\securityService();
$antiCSRF->insertHiddenToken();
