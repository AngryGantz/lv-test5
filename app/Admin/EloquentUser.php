<?php

Admin::model('Cartalyst\Sentinel\Users\EloquentUser')->title('Юзеры')->display(function ()
{
	$display = AdminDisplay::datatables();
	$display->with();
	$display->filters([

	]);
	$display->columns([
		Column::string('id')->label('Id'),
		Column::string('email')->label('Email'),
		Column::string('first_name')->label('Имя'),
	]);
	return $display;
})->create(function ()
{
	$form = AdminForm::form();
	$form->items([
		FormItem::text('email', 'Email')->defaultValue(''),
		FormItem::password('password', 'Пароль')->defaultValue(''),
		FormItem::password('password_confirm', 'Подтверждение пароля')->defaultValue(''),
//		FormItem::timestamp('last_login', 'Last Login')->format('d.m.Y'),//->seconds(true),
		FormItem::text('first_name', 'Имя')->defaultValue(''),
		FormItem::text('last_name', 'Фамилия')->defaultValue(''),
		FormItem::view('admin.user_create'),
//		FormItem::ckeditor('permissions', 'Permissions'),
	]);
	return $form;
})->edit(function ()
{
	$form = AdminForm::form();
	$form->items([
			FormItem::columns()->columns([
				[
						FormItem::text('email', 'Email'),
						FormItem::password('password', 'Пароль'),
						FormItem::password('password_confirm', 'Подтверждение пароля'),
				],
				[
						FormItem::text('first_name', 'Имя'),
						FormItem::text('last_name', 'Фамилия'),
						FormItem::view('admin.user_update'),
				],
			]),
			//		FormItem::timestamp('last_login', 'Last Login')->format('d.m.Y'),//->seconds(true),
			//		FormItem::ckeditor('permissions', 'Permissions'),
	]);
	return $form;
});