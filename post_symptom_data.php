<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$host = "localhost";
$dbname = "mothercare";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

$input = json_decode(file_get_contents("php://input"), true);
if (!isset($input['symptoms'], $input['bloodPressure'], $input['proteinInUrine'])) {
    http_response_code(400);
    echo json_encode(["message" => "Missing required fields"]);
    exit();
}

$symptoms = $input['symptoms'];
$bloodPressure = trim($input['bloodPressure']);
$proteinInUrine = $conn->real_escape_string($input['proteinInUrine']);
$urinalysisTaken = ($proteinInUrine === "Not taken") ? 0 : 1;

if (!preg_match('/^(\d+(\.\d+)?)\/(\d+(\.\d+)?)$/', $bloodPressure, $matches)) {
    http_response_code(400);
    echo json_encode(["message" => "Please enter a valid blood pressure reading in format systolic/diastolic (e.g., 120/80)."]);
    exit();
}
$systolic = floatval($matches[1]);
$diastolic = floatval($matches[3]);

$severeSymptoms = ["Blurred vision", "Severe abdominal pain", "Shortness of breath", "Decreased urine output", "Swelling in hands or feet"];
$severeCount = 0;
foreach ($symptoms as $symptom) {
    if (in_array($symptom, $severeSymptoms)) {
        $severeCount++;
    }
}

$riskScore = 0;
if ($systolic >= 160 || $diastolic >= 110) {
    $riskScore += 40;
} elseif ($systolic >= 140 || $diastolic >= 90) {
    $riskScore += 20;
}
if ($proteinInUrine === "Yes") {
    $riskScore += 30;
}
$totalSymptoms = count($symptoms);
if ($severeCount >= 2 || $totalSymptoms >= 5) {
    $riskScore += 30;
} elseif ($totalSymptoms >= 3) {
    $riskScore += 20;
} elseif ($totalSymptoms >= 1) {
    $riskScore += 10;
}

$riskLevel = "Low";
$recommendation = "Continue regular checkups and monitor your symptoms.";

if ($riskScore >= 70) {
    $riskLevel = "High";
    $facility = "a health facility";
    $result = $conn->query("SELECT nearest_health FROM user_profiles ORDER BY id DESC LIMIT 1");
    if ($result && $row = $result->fetch_assoc()) {
        $facility = $row['nearest_health'];
    }
    $recommendation = "High risk detected. Seek immediate medical attention at $facility without delay.";

} elseif ($riskScore >= 40) {
    $riskLevel = "Moderate";
    $recommendation = "Consult your healthcare provider soon.";
}

$preparedSymptoms = $conn->real_escape_string(implode(", ", $symptoms));
$sql = "INSERT INTO symptom_checker (symptoms, blood_pressure, urinalysis_taken, protein_in_urine) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(["message" => "Prepare failed: " . $conn->error]);
    exit();
}

$stmt->bind_param("ssis", $preparedSymptoms, $bloodPressure, $urinalysisTaken, $proteinInUrine);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(["message" => "Execute failed: " . $stmt->error]);
    exit();
}

echo json_encode([
    "message" => $recommendation,
    "risk_score" => $riskScore,
    "risk_level" => $riskLevel
]);

$stmt->close();
$conn->close();
?>