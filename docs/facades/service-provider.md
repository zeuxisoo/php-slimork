# Service Provider

In this level, We have providerd service provider facade object to you.

## Facades

The following code can be replaced with the related facades, like `session`

    // In controller
    $hello = $this->session->get('hello');

    $session = $this->container->get('session');
    $hello   = $session->get('hello');

    // In controller with facade
    $hello = Session::get('hello');

**Session**

return the session service provider, like

    Session::set('name', 'value')
    Session::get('name')

**Cookie**

return the cookie service provider, like

    Cookie::set('name', 'value')
    Cookie::get('name')

**Paginator**

return the pagination service provider, like


    Paginator::findOffset('per_page', 'current_page')
    Paginator::items('[items]')->total('total')->perPage('per_page')->currentPage('current_page')->default()

**DB**

return the database service provider, like

    DB::table('table')->count()
    DB::table('table')->skip('offset')->take('per_page')->get()

**Flash**

return the flash service provider, like

    Flash::error('message')
    Flash::has('error')
    Flash::error()

**CSRF**

return the csrf serivce provider, like

    Csrf::getTokenForHiddenInputTags()
    Csrf::getTokenForMetaTags()
    Csrf::getTokens()

**Validation**

return the validation service provider, like

    $validator = Validator::validators(['username' => ''], [
        'username' => Slimork\Providers\Validation\Rule::stringType()->notEmpty()
    ]);

    $validator->fails();

**View**

return the view service provider, like

    View::render(Container::get('response'), 'index.html')

**Mail**

return the mail service provider, like

    Mail::subject('subject')->from('email')->to('email')->body('content')->send()

**Hash**

return the hash service provider, like

    Hash::make('string')
    Hash::check('string', 'hashed_string')
    Hash::needsRehash('hashed_string')

**Logger**



**Redirection**
