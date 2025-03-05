<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=localhost;dbname=ai_resume_db', // Change 'ai_resume_db' to your actual database name
    'username' => 'your_pg_username', // Replace with your PostgreSQL username
    'password' => 'your_pg_password', // Replace with your PostgreSQL password
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
