<?php
require 'database.php';
require_once 'userhelper.php';

$db = Database::getInstance()->getConnection();

$result = $db->query('SELECT * FROM Users');
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    foreach ($row as $column => $value) {
        echo "$column: $value<br>";
    }
    echo "<hr>";
}

//simple login test
$emailToLogin = "admin@project2.com";
$passwordToLogin = "password123";

if (UserHelper::login($db, $emailToLogin, $passwordToLogin)) {
    echo "Login successful for $emailToLogin";
} else {
    echo "Login failed for $emailToLogin";
}
echo '<br>';

if (UserHelper::register($db, "Raheed", "Samari", "TheEscape2", "raheed555@gmail.com", "Admin")) {
    echo "Registration successful";
} else {
    echo "Registration failed, email exists";
}
echo '<br>';

UserHelper::logout();
echo '<br>';
if (UserHelper::login($db, "raheed555@gmail.com", "TheEscape2")) {
    echo "Login successful for raheed555@gmail.com";
} else {
    echo "Login failed for raheed";
}

echo '<br>';
if (UserHelper::register($db, "Raheed", "Samari", "TheEscape2", "raheed515@gmail.com", "Admin")) {
    echo "Registration successful Samari";
} else {
    echo "Registration failed";
}

echo json_encode(UserHelper::getUsers($db));
UserHelper::logout();


?>