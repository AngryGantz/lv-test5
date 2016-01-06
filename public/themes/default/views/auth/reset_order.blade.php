<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy Pivovarov aka AngryDeer http://studioweb.pro
 * Date: 07.01.16
 * Time: 0:00
 */?>

<h1>Reset password order</h1>
<div class="loginform">
    {!! Form::open() !!}
    {!! Theme::widget('Form\_formitem_text', array('name' => 'email', 'title' => 'E-Mail', 'placeholder' => 'E-Mail' ))->render()  !!}
    {!! Theme::widget('Form\_formitem_submitbtn', array( 'title' => 'Сброс пароля', ))->render()  !!}
    {!! Form::close() !!}
</div>
