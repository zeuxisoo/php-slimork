### Install

	curl -sS https://getcomposer.org/installer | php
	php composer.phar install

	chmod 777 cache/views
	chmod 777 log
	mv config/common.php.sample config/common.php
	mv config/database.php.sample config/database.php

### Locale

- support locale format `YAML` or `PHP Array`

	vim locale/en_US.php

		<?php
		return array(
			'Hello %name%' => 'PHP Bonjour %name%',
		);

	vim locale/en_US.yaml

		'Hello %name%': YAML Bonjour %name%

- In program

	echo $translator->trans('Hello %name%', array("%name%" => "World"));

- In Twig Tempalte

	{{ "Hello %name%" | trans({ '%name%': "World" }) }}

	OR

	{% trans with {'%name%': 'World'} %}
		Hello %name%
	{% endtrans %}

### Testing

	php composer.phar update
	php vendor/bin/codecept bootstrap

	# Acceptance
	php vendor/bin/codecept generate:cept acceptance signup/SubmitExistsAccount
	vim tests/acceptance.suite.xml

		config:
        PhpBrowser:
            url: 'http://localhost/work/project/'

	php vendor/bin/codecept build
	vim tests/acceptance/signup/SubmitExistsAccountCept.php

		<?php
		$I = new WebGuy($scenario);
		$I->wantTo('submit exists account');
		$I->amOnPage('/signup');
		$I->submitForm('form', array(
			'email' => 'test@test.com',
			'password' => 'testtest',
			'confirm_password' => 'testtest',
		));
		$I->see('Error! The email address already exists', '.alert-error');

	# Unit
	vim tests/unit.suite.yml

		class_name: CodeGuy
		modules:
		    enabled: [Unit, CodeHelper, PhpBrowser]
		    config:
		        PhpBrowser:
		            url: 'http://localhost/work/pet/'

	php vendor/bin/codecept build
	php vendor/bin/codecept generate:test unit Signup
	vim tests/unit/SignupTest.php

		<?php
		use Codeception\Util\Stub;

		class SignupTest extends \Codeception\TestCase\Test
		{
		   /**
		    * @var \CodeGuy
		    */
		    protected $codeGuy;

		    protected function _before()
		    {
		    }

		    protected function _after()
		    {
		    }

		    // tests
		    public function testSubmitExistsAccount()
		    {
		        $this->codeGuy->amOnPage('/signup');
		        $this->codeGuy->submitForm('form', array(
		            'email' => 'test@test.com',
		            'password' => 'testtest',
		            'confirm_password' => 'testtest',
		        ));
		        $this->codeGuy->see('Error! The email address already exists', '.alert-error');
		    }
		}

	php vendor/bin/codecept run
	php vendor/bin/codecept run -steps
	php vendor/bin/codecept run acceptance signup

### License

	The BSD 2-Clause License
