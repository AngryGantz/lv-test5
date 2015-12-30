<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy Pivovarov aka AngryDeer http://studioweb.pro
 * Date: 29.12.15
 * Time: 16:45
 */
?>

{!! Form::open() !!}
  @include('widgets.form._formitem_text', ['name' => 'email', 'title' => 'Email', 'placeholder' => 'Ваш Email' ])
  @include('widgets.form._formitem_btn_submit', ['title' => 'Сброс пароля'])
{!! Form::close() !!}
