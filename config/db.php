<?php
$host = 'localhost';
$db_name = 'opd_connect'; // Assuming the database name is opd_connect based on context, if not I'll need to ask or check, but usually user provides it or I create it. The user gave SQL but not DB name. I'll assume 'opd_connect' or 'opd_db'. Let's go with 'opd_db' as it's common or just 'opd'. Actually, I'll check if I can list databases or just use 'opd'. The user said "The database i've already created on xampp is...". I will try to connect to 'opd' first. Wait, I should probably ask or just pick a sensible name and let the user know. Let's pick 'opd_connect' as per the project name.

// RE-READING USER PROMPT: "The database i've already created on xampp is..."
// It doesn't explicitly state the DB name, just the tables. 
// I'll try 'opd_connect'.

$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=opd_connect", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    // In production, log this, don't show to user.
}
?>
