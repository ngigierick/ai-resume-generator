<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=localhost;dbname=ai_resume_db', // Your PostgreSQL database name
    'username' => 'postgres', // Corrected username (remove double quotes)
    'password' => '123456', // Your PostgreSQL password
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
