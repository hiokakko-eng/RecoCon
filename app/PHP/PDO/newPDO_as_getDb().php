<?php
function getDb(): PDO {
   $host = getenv('RECOCON_DB_HOST');
   $name = getenv('RECOCON_DB_NAME');
   $user = getenv('RECOCON_DB_USER');
   $password = getenv('RECOCON_DB_PASSWORD');
   if ($host === false || $name === false || $user === false || $password === false) {
      throw new RuntimeException('RecoCon database configuration is missing.');
   }
   return new PDO(
      'mysql:host='.$host.';dbname='.$name.';charset=utf8mb4',
      $user, $password,
      [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_CASE => PDO::CASE_NATURAL,
       PDO::ATTR_EMULATE_PREPARES => false]
   );
}
