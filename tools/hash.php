<?php
$passwords = [
    'nlcs' => 'hocky3',
    'nlcn' => 'hocky1',
    'luanvan' => 'hocky2'
];

foreach ($passwords as $username => $plain) {
    $hash = password_hash($plain, PASSWORD_BCRYPT);
    echo "('$username', '$hash'),<br>";
}
