<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy Pivovarov aka AngryDeer http://studioweb.pro
 * Date: 29.12.15
 * Time: 18:32
 */
?>

  @include('widgets.form._formitem_checkbox', ['name' => 'activated', 'title' => 'Активирован', 'checked' => true] )
  <label for="role">Роль пользователя</label>
  <select name="role" id="role">
    @foreach(Sentinel::getRoleRepository()->createModel()->all() as $role)
      <option value="{{ $role->id }}">{{ $role->name }}</option>
    @endforeach
  </select>
  <br><br>