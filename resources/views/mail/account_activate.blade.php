<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy Pivovarov aka AngryDeer http://studioweb.pro
 * Date: 29.12.15
 * Time: 23:24
 */?>

Для активации аккаунта пройдите по <a href="{{ URL::to("activate/{$sentuser->getUserId()}/{$code}") }}">ссылке</a>


