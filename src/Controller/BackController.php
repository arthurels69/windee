<?php


namespace App\Controller;

use App\Model\StationManager;

class BackController extends AbstractController
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('location: /back/login');
        }
        $stations = new StationManager();
        $stations = $stations->selectAll();
        $path = 'add';
        $button = 'Ajouter';
        return $this->twig->render("Back/index.html.twig", [
            'stations' => $stations,
            'path' => $path,
            "button" => $button
        ]);
    }

    public function add()
    {
        $stations = new StationManager();
        $newStation = [
            'station_name' => $_POST['station_name'],
            'street_name' => $_POST['street_name'],
            'number' => $_POST['number'],
            'zipcode' => $_POST['zipcode'],
            'city' => $_POST['city']
        ];
        $stations->insert($newStation);
        header("location:/back/index");
    }

    public function edit($id)
    {
        $path = 'update';
        $button = 'Editer';
        $buttonDelete = 'Supprimer';
        $stations = new StationManager();
        $stations = $stations->selectAll();
        $station = new StationManager();
        $station = $station->selectOneById($id);
        return $this->twig->render("Back/index.html.twig", [
            "currentStation" => $station,
            "stations" => $stations,
            "path" => $path,
            "button" => $button,
            "buttonDelete" => $buttonDelete
        ]);
    }

    public function update($id)
    {
        $stations = new StationManager();
        $station = $stations->selectOneById($id);
        $station['station_name'] = $_POST['station_name'];
        $station['street_name'] = $_POST['street_name'];
        $station['number'] = $_POST['number'];
        $station['zipcode'] = $_POST['zipcode'];
        $station['city'] = $_POST['city'];
        $stations->update($station);
        header("location:/Back/index");
    }

    public function delete($id)
    {
        $station = new StationManager();
        $station = $station->delete($id);
        header("location:/Back/index");
    }

    public function login()
    {
        return $this->twig->render("Back/login.html.twig");
    }

    public function check()
    {
        if ($_POST['username'] === 'admin'&& $_POST['password'] === 'password') {
            $_SESSION['user'] = $_POST['username'];
            header('location: /back/index');
        } else {
            header('location: /back/login');
        }
    }
    public function logout()
    {
        session_destroy();
        header("location: /back/login/");
    }
}
