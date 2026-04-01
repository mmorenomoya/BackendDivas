<?php 

class Controller
{
    protected function loadModel($model)
    {
        require_once './app/models' . $model . '.php';
        return new $model;
    }

    protected function renderView($viewPath, $data = [], $title = "Repara Ya")
    {
        extract($data);
        require_once './public/index.php';
    }
}

?>