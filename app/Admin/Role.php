<?php

Admin::model(App\Role::class)->title('Роли')->display(function ()
{
	$display = AdminDisplay::datatables();
	$display->with('permits');
	$display->filters([

	]);
	$display->columns([
		Column::string('id')->label('Id'),
		Column::string('name')->label('Name'),
		Column::string('slug')->label('Slug'),
	]);
	return $display;
})->createAndEdit(function ()
{
	$form = AdminForm::form();
	$form->items([
		FormItem::text('slug', 'Slug'),
		FormItem::text('name', 'Name'),
		FormItem::multiselect('permits', 'Права доступа')->model('App\Permit')->display('name'),
//		FormItem::ckeditor('permissions', 'Permissions'),
	]);
	return $form;
});