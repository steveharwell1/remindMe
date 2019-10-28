<?PHP
$data = array( 'data' => date('l jS \of F Y h:i:s A'));
header('Content-Type: application/json');
echo json_encode($data);