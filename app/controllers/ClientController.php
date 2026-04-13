<?php

require_once __DIR__ . '/../models/Incident.php';
require_once __DIR__ . '/../models/ServiceType.php';
require_once __DIR__ . '/../core/Auth.php';

class ClientController
{
    public function index()
    {
        Auth::requireLogin(Role::Client);

        $incidentModel = new Incident();
        $incidencias = $incidentModel->getIncidentByClientId(Auth::getUser()['id']);
        
        require_once __DIR__ . '/../views/client/dashboard.php';
    }

    public function create()
    {
        $serviceTypeModel = new ServiceType();
        $services = $serviceTypeModel->getAllServiceTypes();

        require_once __DIR__ . '/../views/client/create_incident.php';
    }

    public function store()
    {
        $incidentModel = new Incident();

        $usuario = Auth::getUser();
        $clientId = $usuario['id'] ?? null;

        $fechaServicio = $_POST['fecha_servicio'] ?? '';
        $descripcion = trim($_POST['descripcion'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $tipoUrgencia = $_POST['tipo_urgencia'] ?? '';
        $especialidadId = (int)($_POST['especialidad_id'] ?? 0);

        $errors = [];

        if (!$clientId) {
            $errors[] = 'Usuario no autenticado.';
        }

        if (empty($fechaServicio)) {
            $errors[] = 'La fecha es obligatoria.';
        }

        if (empty($descripcion)) {
            $errors[] = 'La descripción es obligatoria.';
        }

        if (empty($direccion)) {
            $errors[] = 'La dirección es obligatoria.';
        }

        if (empty($tipoUrgencia)) {
            $errors[] = 'El tipo de urgencia es obligatorio.';
        }

        if ($especialidadId <= 0) {
            $errors[] = 'Debes seleccionar un servicio.';
        }

        if ($tipoUrgencia === 'Estándar' && $incidentModel->isWithin48Hours($fechaServicio)) {
            $errors[] = 'Los servicios estándar deben pedirse con al menos 48 horas de antelación.';
        }

        if (!empty($errors)) {
            $serviceTypeModel = new ServiceType();
            $services = $serviceTypeModel->getAllServiceTypes();
            require_once __DIR__ . '/../views/client/create_incident.php';
            return;
        }

        $data = [
            'localizador' => $incidentModel->generateLocalizador(),
            'cliente_id' => (int)$clientId,
            'especialidad_id' => $especialidadId,
            'descripcion' => $descripcion,
            'direccion' => $direccion,
            'fecha_servicio' => date('Y-m-d H:i:s', strtotime($fechaServicio)),
            'tipo_urgencia' => $tipoUrgencia
        ];

        $incidentModel->createIncident($data);

        header('Location: ' . BASE_URL . '/client/incidents');
        exit;
    }

    public function incidents()
    {
        $incidentModel = new Incident();

        $usuario = Auth::getUser();
        $clientId = $usuario['id'] ?? null;

        if ($clientId) {
            $incidents = $incidentModel->getIncidentByClientId((int)$clientId);
        } else {
            $incidents = [];
        }

        require_once __DIR__ . '/../views/client/incidents.php';
    }

    public function cancel()
    {
        Auth::requireLogin();

        $usuario = Auth::getUser();
        $clientId = $usuario['id'] ?? null;
        $incidentId = (int)($_GET['id'] ?? 0);

        if (!$clientId || $incidentId <= 0) {
            header('Location: ' . BASE_URL . '/client/incidents');
            exit;
        }

        $incidentModel = new Incident();
        $incident = $incidentModel->getIncidentByIdAndClientId($incidentId, (int)$clientId);

        if (!$incident) {
            $_SESSION['error'] = 'La incidencia no existe o no te pertenece.';
            header('Location: ' . BASE_URL . '/client/incidents');
            exit;
        }

        if (!$incidentModel->canBeCancelledByClient($incident)) {
            $_SESSION['error'] = 'No puedes cancelar esta incidencia porque faltan menos de 48 horas para la cita o no es estándar.';
            header('Location: ' . BASE_URL . '/client/incidents');
            exit;
        }

        $incidentModel->cancelIncident($incidentId);

        $_SESSION['success'] = 'Incidencia cancelada correctamente.';
        header('Location: ' . BASE_URL . '/client/incidents');
        exit;
    }

    public function detail()
    {
        require_once __DIR__ . '/../views/client/incident_detail.php';
    }
}