<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: https://coingas-exchange.web.app');
header("Access-Control-Allow-Headers: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$method = $_SERVER['REQUEST_METHOD'];
switch($method) {
    case "GET": 
        $sql = "SELECT * FROM Exchange";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $jsoninfo = json_encode($info);
        $infoArray = json_decode($jsoninfo, true);
        $lastElement = end($infoArray);
        echo json_encode($lastElement);
        break;
    case "POST":
        $exchangeInfo = json_decode(file_get_contents('php://input'));
        $sql = "INSERT INTO Exchange(id, count, total_price, wallet, memo, email, ticker1, ticker2, created_at) VALUES(null, :count, :total_price, :wallet, :memo, :email, :ticker1, :ticker2, :created_at)";
        $stmt = $conn->prepare($sql);
        $created_at = date('Y-m-d');
        $stmt->bindParam(':count', $exchangeInfo->count);
        $stmt->bindParam(':total_price', $exchangeInfo->total_price);
        $stmt->bindParam(':wallet', $exchangeInfo->wallet);
        $stmt->bindParam(':memo', $exchangeInfo->memo);
        $stmt->bindParam(':email', $exchangeInfo->email);
        $stmt->bindParam(':ticker1', $exchangeInfo->ticker1);
        $stmt->bindParam(':ticker2', $exchangeInfo->ticker2);
        $stmt->bindParam(':created_at', $created_at);
        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record created successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }
        echo json_encode($response);
        break;
}
