<?php

namespace App\Controller;

use Awurth\Slim\Helper\Controller\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Project;

class ProjectsController extends Controller
{
    //get list
    public function list(Request $request, Response $response)
    {
        return $this->render($response, 'app/projects.twig');
    }

    //put add
    public function add(Request $request, Response $response)
    {
        $project = [
            'name' => $request->getParam('name'),
            'discription' => $request->getParam('description'),
            'url' => $request->getParam('url'),
            'dir' => '/' . $this->auth->getUser()->username . '/' . $request->getParam('name')
        ];

        return $this->json(Project::add($project));
    }

    //post edit
    public function edit(Request $request, Response $response, String $username, String $projectName)
    {

    }

    //delete
    public function delete(Request $request, Response $response, String $username, String $projectName)
    {

    }

    //get content editor
    public function editor(Request $request, Response $response, String $username, String $projectName)
    {
        $data = [
          'project' => [
            'name' => $projectName
          ]
        ];

        return $this->render($response, 'app/editor.twig', $data);
    }

    //post publish to url
    public function publish(Request $request, Response $response, String $username, String $projectName)
    {
        return $this->render($response, 'app/content.twig');
    }
}
