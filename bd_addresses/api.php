<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Load JSON files
$divisions = json_decode(file_get_contents(__DIR__ . '/data/bd-divisions.json'), true);
$districts = json_decode(file_get_contents(__DIR__ . '/data/bd-districts.json'), true);
$upazilas = json_decode(file_get_contents(__DIR__ . '/data/bd-upazilas.json'), true);

// Get the action from request
$action = $_GET['action'] ?? '';

switch($action) {
    case 'divisions':
        echo json_encode($divisions['divisions']);
        break;
        
    case 'districts':
        $division_id = $_GET['division_id'] ?? '';
        if ($division_id) {
            $filtered_districts = array_filter($districts['districts'], function($district) use ($division_id) {
                return $district['division_id'] === $division_id;
            });
            echo json_encode(array_values($filtered_districts));
        }
        break;
        
    case 'upazilas':
        $district_id = $_GET['district_id'] ?? '';
        if ($district_id) {
            $filtered_upazilas = array_filter($upazilas['upazilas'], function($upazila) use ($district_id) {
                return $upazila['district_id'] === $district_id;
            });
            echo json_encode(array_values($filtered_upazilas));
        }
        break;
        
    case 'postoffices':
        $district_id = $_GET['district_id'] ?? '';
        if ($district_id) {
            $district_file = __DIR__ . '/data/' . $district_id . '.json';
            if (file_exists($district_file)) {
                $district_data = json_decode(file_get_contents($district_file), true);
                echo json_encode($district_data['postcodes']);
            }
        }
        break;
        
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
}
?> 