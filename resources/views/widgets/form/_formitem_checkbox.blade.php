<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy Pivovarov aka AngryDeer http://studioweb.pro
 * Date: 29.12.15
 * Time: 17:11
 *
 * Widget formitem "text"
 *
 * param $name  - field name
 * param $title - field label or null if not set
 * param $value - value field or null if not set
 * param $checked - value field or null if not set
 */?>

<?php
    if(! isset($value)) $value = null;
    if(! isset($checked)) $checked = null;
    if(! isset($title)) $title = null;
?>
<div class="{!! $errors->has($name) ? 'has-error' : null !!}">
    <label for="{!! $name !!}">{{ $title }}</label>
    {!! Form::checkbox($name, $value, $checked) !!}
    <p class="help-block">{!! $errors->first($name) !!}</p>
</div>

