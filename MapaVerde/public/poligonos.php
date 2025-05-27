<?php
session_start();
require_once('db-connect.php');

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $result = $conn->query("SELECT * FROM poligonos_mapa");
    $poligonos = [];
    while ($row = $result->fetch_assoc()) {
        $poligonos[] = [
            'id' => (int)$row['id'],
            'nombre' => $row['nombre'],
            'color' => $row['color'],
            'coordenadas' => json_decode($row['coordenadas'], true)
        ];
    }
    echo json_encode($poligonos);
    exit;
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) { http_response_code(400); exit; }

    $nombre = $data['nombre'] ?? '';
    $color = $data['color'] ?? '';
    $coordenadas = $data['coordenadas'] ?? [];

    if (!$nombre || !$color || empty($coordenadas)) {
        http_response_code(400);
        echo json_encode(['error' => 'Datos incompletos']);
        exit;
    }

    $coords_json = json_encode($coordenadas);

    $stmt = $conn->prepare("INSERT INTO poligonos_mapa (nombre, color, coordenadas) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $nombre, $color, $coords_json);
    $stmt->execute();
    if ($stmt->affected_rows) {
        echo json_encode(['ok' => true, 'id' => $stmt->insert_id]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'No se pudo guardar']);
    }
    $stmt->close();
    exit;
}
if ($method === 'DELETE') {
    parse_str(file_get_contents("php://input"), $params);
    $id = isset($params['id']) ? intval($params['id']) : 0;
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM poligonos_mapa WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->affected_rows) {
            echo json_encode(['ok' => true]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No se encontró']);
        }
        $stmt->close();
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'ID inválido']);
    }
    exit;
}
?>