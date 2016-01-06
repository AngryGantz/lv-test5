<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy Pivovarov aka AngryDeer http://studioweb.pro
 * Date: 06.01.16
 * Time: 18:42
 *
 *
 *
 */?>

<h1>LOGIN PAGE THEME</h1>
<div class="loginform">
    {!! Form::open() !!}
    {!! Theme::widget('Form\_formitem_text', array('name' => 'email', 'title' => 'E-Mail', 'placeholder' => 'E-Mail' ))->render()  !!}
    {!! Theme::widget('Form\_formitem_password', array('name' => 'password', 'title' => 'Пароль', 'placeholder' => 'password' ))->render()  !!}
    {!! Theme::widget('Form\_formitem_checkbox', array('name' => 'remember', 'title' => 'Запомнить меня' ))->render()  !!}
    {!! Theme::widget('Form\_formitem_submitbtn', array( 'title' => 'Вход', ))->render()  !!}
    {!! Form::close() !!}

    <a href="reset">Забыли пароль?</a>
</div>
