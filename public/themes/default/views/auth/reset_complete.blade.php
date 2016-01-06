<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy Pivovarov aka AngryDeer http://studioweb.pro
 * Date: 07.01.16
 * Time: 0:10
 */?>

<h1>LOGIN PAGE THEME</h1>
<div class="loginform">
    {!! Form::open() !!}
    {!! Theme::widget('Form\_formitem_password', array('name' => 'password', 'title' => 'Новый пароль', 'placeholder' => 'password' ))->render()  !!}
    {!! Theme::widget('Form\_formitem_password', array('name' => 'password_confirm', 'title' => 'Подтвердить пароль', 'placeholder' => 'password' ))->render()  !!}
    {!! Theme::widget('Form\_formitem_submitbtn', array( 'title' => 'Вход', ))->render()  !!}
    {!! Form::close() !!}
</div>
