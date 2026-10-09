<?php

return [
    'driver' => env('HASH_DRIVER', 'bcrypt'),
    // password_verify accepts existing bcrypt and Argon2 hashes during migration.
    'bcrypt' => ['rounds' => env('BCRYPT_ROUNDS', 12), 'verify' => false],
    'argon' => ['memory' => 65536, 'threads' => 1, 'time' => 4, 'verify' => false],
    'rehash_on_login' => true,
];
