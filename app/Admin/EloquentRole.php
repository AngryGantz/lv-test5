<?php

Admin::model('Cartalyst\Sentinel\Roles\EloquentRole')->title('Роли')->display(function ()
//Admin::model(\App\Role::class)->title('Роли')->display(function ()
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
//		FormItem::view('admin.role'),
		FormItem::multiselect('permits', 'Права доступа')->model('App\Permit')->display('name'),
//		FormItem::ckeditor('permissions', 'Permissions'),
	]);
	return $form;
});