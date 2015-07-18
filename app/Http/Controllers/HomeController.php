<?php
namespace App\Http\Controllers;

use App\Contracts\BaseController;

class HomeController extends BaseController {

    public function index() {
        echo "<h3>Normal</h3>";
        echo "<p>It is work</p>";

        echo "<h3>Translator</h3>";
        echo "<p>".$this->app->locale->trans("It is work, %name%", array('%name%' => 'test'))."</p>";

        echo "<h3>Translator with view</h3>";
        echo "<a href='".$this->app->urlFor('view')."'>See view render</a>";
    }

    public function view() {
        return $this->app->render('view.html');
    }

}
