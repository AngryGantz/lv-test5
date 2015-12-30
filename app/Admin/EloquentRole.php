<?php

Admin::model('Cartalyst\Sentinel\Roles\EloquentRole')->title('Роли')->display(function ()
{
	$display = AdminDisplay::datatables();
	$display->with();
	$display->filters([

	]);
	$display->columns([
		Column::string('id')->label('Id'),
		Column::string('name')->label('Имя'),
		Column::string('slug')->label('Slug'),
	]);
	return $display;
})->createAndEdit(function ()
{
	$form = AdminForm::form();
	$form->items([
		FormItem::text('name', 'Имя'),
		FormItem::text('slug', 'Slug'),

//		FormItem::ckeditor('permissions', 'Permissions'),
	]);
	return $form;
});