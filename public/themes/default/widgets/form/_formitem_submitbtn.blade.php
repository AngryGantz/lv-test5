<?php
/**
 * Widget formitem "Submit Button"
 *
 * Created by PhpStorm.
 * User: Dmitriy Pivovarov aka AngryDeer http://studioweb.pro
 * Date: 06.01.16
 * Time: 18:42
 *
 *
 * param $title - field label or null if not set
 *
 */
?>

<?php
  if(! isset($title)) $title = null;
?>

{!! Form::submit($title, array('class' => 'btn btn-primary')) !!}