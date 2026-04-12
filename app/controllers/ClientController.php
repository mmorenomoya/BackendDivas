<?php

class ClientController
{
    public function index()
    {
        require_once __DIR__ . '/../views/client/dashboard.php';
    }

    public function create()
    {
        require_once __DIR__ . '/../views/client/create_incident.php';
    }

    public function incidents()
    {
        require_once __DIR__ . '/../views/client/incidents.php';
    }

    public function detail()
    {
        require_once __DIR__ . '/../views/client/incident_detail.php';
    }
}