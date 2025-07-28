<?php
$passwords = [
    'cnweb' => '123456',
    'hoangnhon' => '123456',
    'thuykha' => '123456'
];

foreach ($passwords as $username => $plain) {
    $hash = password_hash($plain, PASSWORD_BCRYPT);
    echo "('$username', '$hash'),<br>";
}
