<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Permit;
use App\Role;
use Redirect;
use Sentinel;
use Activation;
use Reminder;
use Validator;
use Mail;
use Storage;

class AuthController extends Controller
{

    /**
     * Show login page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Show Register page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register()
    {
        return view('auth.register');
    }


    /**
     * Show wait page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function wait()
    {
        return view('auth.wait');
    }


    /**
     * Process login users frontend
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function loginProcess(Request $request)
    {
        try
        {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $remember = (bool) $request->remember;
            if (Sentinel::authenticate($request->all(), $remember))
            {
                return Redirect::intended('/');
            }
            $errors = 'Неправильный логин или пароль.';
            return Redirect::back()
                ->withInput()
                ->withErrors($errors);
        }
        catch (NotActivatedException $e)
        {
            $sentuser= $e->getUser();
            $activation = Activation::create($sentuser);
            $code = $activation->code;
            $sent = Mail::send('mail.account_activate', compact('sentuser', 'code'), function($m) use ($sentuser)
            {
                $m->from('hello@app.com', 'LaravelTest');
                $m->to($sentuser->email)->subject('Активация аккаунта');
            });

            if ($sent === 0)
            {
                return Redirect::to('login')
                    ->withErrors('Ошибка отправки письма активации.');
            }
            $errors = 'Ваш аккаунт не ативирован! Поищите в своем почтовом ящике письмо со ссылкой для активации (Вам отправлено повторное письмо). ';
            return view('auth.login')->withErrors($errors);
        }
        catch (ThrottlingException $e)
        {
            $delay = $e->getDelay();
            $errors = "Ваш аккаунт блокирован на {$delay} секунд.";
        }
        return Redirect::back()
            ->withInput()
            ->withErrors($errors);
    }


    /**
     * Process register user from site
     *
     * @param Request $request
     * @return $this
     */
    public function registerProcess(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ]);
        $input = $request->all();
        $credentials = [ 'email' => $request->email ];
        if($user = Sentinel::findByCredentials($credentials))
        {
            return Redirect::to('register')
                ->withErrors('Такой Email уже зарегистрирован.');
        }

        if ($sentuser = Sentinel::register($input))
        {
            $activation = Activation::create($sentuser);
            $code = $activation->code;
            $sent = Mail::send('mail.account_activate', compact('sentuser', 'code'), function($m) use ($sentuser)
            {
                $m->from('hello@app.com', 'LaravelTest');
                $m->to($sentuser->email)->subject('Активация аккаунта');
            });
            if ($sent === 0)
            {
                return Redirect::to('register')
                    ->withErrors('Ошибка отправки письма активации.');
            }

            $role = Sentinel::findRoleBySlug('user');
            $role->users()->attach($sentuser);

            return Redirect::to('login')
                ->withSuccess('Your accout was successfully created. Please check your Emails for activate account.')
                ->with('userId', $sentuser->getUserId());
        }
        return Redirect::to('register')
            ->withInput()
            ->withErrors('Failed to register.');
    }


    /**
     *  Activate user account by user id and activation code
     *
     * @param $id
     * @param $code
     * @return $this
     */
    public function activate($id, $code)
    {
        $sentuser = Sentinel::findById($id);

        if ( ! Activation::complete($sentuser, $code))
        {
            return Redirect::to("login")
                ->withErrors('Invalid or expired activation code.');
        }

        return Redirect::to('login')
            ->withSuccess('Account activated.');
    }


    /**
     * Show form for begin process reset password
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetOrder()
    {
        return view('auth.reset_order');
    }


    /**
     * Begin process reset password by email
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function resetOrderProcess(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);
        $email = $request->email;
        $sentuser = Sentinel::findByCredentials(compact('email'));
        if ( ! $sentuser)
        {
            return Redirect::back()
                ->withInput()
                ->withErrors('No user with that email address belongs in our system.');
        }
         $reminder = Reminder::exists($sentuser) ?: Reminder::create($sentuser);
         $code = $reminder->code;

        $sent = Mail::send('mail.account_reminder', compact('sentuser', 'code'), function($m) use ($sentuser)
        {
            $m->from('hello@app.com', 'LaravelTest');
            $m->to($sentuser->email)->subject('Сброс пароля');
        });
         if ($sent === 0)
         {
         	return Redirect::to('reset')
         		->withErrors('Failed to send reset password email.');
         }
        return Redirect::to('wait');
    }

    /**
     * Show form for complete reset password
     *
     * @param $id
     * @param $code
     * @return mixed
     */
    public function resetComplete($id, $code)
    {
        $user = Sentinel::findById($id);
        return view('auth.reset_complete');
    }


    /**
     * Complete reset password
     *
     * @param Request $request
     * @param $id
     * @param $code
     * @return $this
     */
    public function resetCompleteProcess(Request $request, $id, $code)
    {
        $this->validate($request, [
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ]);
        $user = Sentinel::findById($id);
        if ( ! $user)
        {
            return Redirect::back()
                ->withInput()
                ->withErrors('The user no longer exists.');
        }
        if ( ! Reminder::complete($user, $code, $request->password))
        {
            return Redirect::to('login')
                ->withErrors('Invalid or expired reset code.');
        }
        return Redirect::to('login')
            ->withSuccess("Password Reset.");
    }


    /**
     * Create User from admin panel
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminUserCreate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ]);
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,

        ];
        $sentuser = Sentinel::register($credentials);
        $role = Sentinel::findRoleById($request->role);
        $role->users()->attach($sentuser);
        if($request->activated)
        {
            $activation = Activation::create($sentuser);
            $code = $activation->code;
            Activation::complete($sentuser, $code);
        }
        return Redirect('/admin/eloquent_users');
    }


    /**
     *  Update User from admin panel
     *  (in admin panel can set or unset activation checkbox)
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminUserUpdate(Request $request, $id)
    {
        $v = Validator::make($request->all(), array(
            'email' => 'required|email',
        ));
        $v->sometimes('password_confirm', 'required|same:password', function($request)
        {
            return $request->password != '';
        });
        if ($v->fails())
        {
            return Redirect::back()
                ->withInput()
                ->withErrors($v);
        }


        $sentuser = Sentinel::findById($id);
        $roles=Sentinel::getRoleRepository()->createModel()->all();
        foreach($roles as $role)
        {
            $role->users()->detach($sentuser);
        }
        $role = Sentinel::findRoleById($request->role);
        $role->users()->attach($sentuser);

//        $role->permissions = [
//            'user.update' => true,
//            'user.view' => true,
//        ];
//        $role->save();

        $activation = Activation::completed($sentuser);
        if($request->activated)
        {
            if(! $activation)
            {
                $activation = Activation::create($sentuser);
                $code = $activation->code;
                Activation::complete($sentuser, $code);
            }
        } else {
            if( $activation)
            {
                Activation::remove($sentuser);
            }
        }
        if($request->password)
        {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
            ];
            Sentinel::update($sentuser, $credentials);
        } else {
            $credentials = [
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
            ];
            Sentinel::update($sentuser, $credentials);
        }
        return Redirect('/admin/eloquent_users');
    }

    /**
     * Create role from Admin Panel
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminRoleCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required',
        ]);

        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);
        if(isset($request->permits))
            foreach($request->permits as $permitId){
                $permit = Permit::find($permitId);
                $role->addPermission($permit->slug);
            }
        $role = Role::find($role->id);
        $arrPermitsForRole = $request->input('permits');
        $role->setPermitsAttribute($arrPermitsForRole);
        return Redirect('/admin/roles');
    }


    /**
     * Update role from admin panel
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminRoleUpdate(Request $request, $id)
    {
        $role = Sentinel::findRoleById($id);
        $allpermits = Permit::all();
        foreach($allpermits as $permit)
        {
            $role->removePermission($permit->slug)->save();
        }
        if(isset($request->permits))
            foreach($request->permits as $permitId){
                $permit = Permit::find($permitId);
                $role->addPermission($permit->slug);
            }
        $role->slug = $request->slug;
        $role->name = $request->name;
        $role->save();

        $role = Role::find($role->id);
        $arrPermitsForRole = $request->input('permits');
        $role->setPermitsAttribute($arrPermitsForRole);
        return Redirect('/admin/roles');
    }


    public function test(Request $request){
        $email=$request->email;
        if ($user = Sentinel::findByCredentials(array('email' => $email)))
        {
            Sentinel::authenticate($user);
            $avatar = 'https://scontent.xx.fbcdn.net/hprofile-xaf1/v/t1.0-1/376689_104705169682959_641046286_n.jpg?oh=5eec0be72b890bb327f2c954ef5199e1&oe=56FE3210';
//            $avatar = 'https://graph.facebook.com/v2.5/636296983190439/picture?width=1920';
            Storage::put('avatars/'.$user->id.'.jpg', $avatar);

            return Redirect::intended('/');
        }
        $name = 'Pupkin';
        $avatar = 'https://scontent.xx.fbcdn.net/hprofile-xaf1/v/t1.0-1/376689_104705169682959_641046286_n.jpg?oh=5eec0be72b890bb327f2c954ef5199e1&oe=56FE3210';
//        $avatar = 'https://graph.facebook.com/v2.5/636296983190439/picture?width=1920';
        Storage::put('avatars/'.$user->id.'.jpg', $avatar);

    }
}
