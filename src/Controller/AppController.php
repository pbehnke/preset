<?php

namespace App\Controller;

use Awurth\Slim\Helper\Controller\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

class AppController extends Controller
{
    public function home(Request $request, Response $response)
    {
        $template = 'home';

        if(!$this->auth->check()) {

          $template = 'index';

        }

        return $this->render($response, "app/$template.twig");
    }

    public function settings(Request $request, Response $response, String $template)
    {
        $template = "app/settings/$template.twig";

        if (!file_exists($template)) {
          //TODO:Not found page
          return $this->render($response, $template);
        }

        return $this->render($response, $template);
    }
}
