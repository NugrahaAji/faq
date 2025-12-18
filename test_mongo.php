<?php
try {
    $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $command = new MongoDB\Driver\Command(['ping' => 1]);
    $cursor = $manager->executeCommand('admin', $command);
    echo "MongoDB Connection SUCCESS!";
} catch (Exception $e) {
    echo "MongoDB Connection FAILED: " . $e->getMessage();
}
