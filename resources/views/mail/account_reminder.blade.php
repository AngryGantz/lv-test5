<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy Pivovarov aka AngryDeer http://studioweb.pro
 * Date: 30.12.15
 * Time: 1:00
 */?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Password Reset</h2>

<div>
    Reset your password by clicking <a href="{{ URL::to("reset/{$sentuser->getUserId()}/{$code}") }}">here</a></div>
</body>
</html>

