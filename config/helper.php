<?php

function renderPartial(string $name): void
{
    $path = __DIR__ . '/../views/partials/' . $name . '.php';
    
    if (file_exists($path)) {
        require $path;
    } else {
        echo "<!-- Partial $name introuvable -->";
    }
}
