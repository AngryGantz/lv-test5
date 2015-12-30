<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy Pivovarov aka AngryDeer http://studioweb.pro
 * Date: 29.12.15
 * Time: 16:45
 */
?>

{!! Form::open() !!}
  @include('widgets.form._formitem_password', ['name' => 'password', 'title' => 'Пароль', 'placeholder' => 'Пароль' ])
  @include('widgets.form._formitem_password', ['name' => 'password_confirm', 'title' => 'Подтверждение пароля', 'placeholder' => 'Пароль' ])
  @include('widgets.form._formitem_btn_submit', ['title' => 'Регистрация'])
{!! Form::close() !!}
