<?php
/**
 * Widget formitem "password"
 *
 * Created by PhpStorm.
 * User: Dmitriy Pivovarov aka AngryDeer http://studioweb.pro
 * Date: 06.01.16
 * Time: 18:42
 *
 *
 * param $name  - field name
 * param $title - field label or null if not set
 * param $placeholder - placeholder for input or null if not set
 * param $value - value field or null if not set
 *
 */
?>

<?php
if(! isset($value)) $value = null;
if(! isset($placeholder)) $placeholder = null;
if(! isset($title)) $title = null;
?>
<div class="{!! $errors->has($name) ? 'has-error' : null !!}">
    <label for="{!! $name !!}">{{ $title }}</label>
    {!! Form::password($name, $value, array('placeholder' =>  $placeholder )) !!}
    <p class="help-block">{!! $errors->first($name) !!}</p>
</div>
