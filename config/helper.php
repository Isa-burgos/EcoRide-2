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

function formatDateFr(string $dateStr): string
{
    if(empty($dateStr)) return'--';

    $date = new DateTime(($dateStr));
    $formatter = new IntlDateFormatter(
        'fr-FR',
        IntlDateFormatter::FULL,
        IntlDateFormatter::NONE,
        'Europe/Paris',
        IntlDateFormatter::GREGORIAN,
        'EEEE d MMMM yyyy'
    );
    return ucfirst($formatter->format($date));
}

function formatHeureFr(string $timeStr): string {
    $formatter = new \IntlDateFormatter(
        'fr_FR',
        \IntlDateFormatter::NONE,
        \IntlDateFormatter::SHORT,
        'Europe/Paris',
        \IntlDateFormatter::GREGORIAN,
        'HH\'h\'mm'
    );

    $time = new DateTime($timeStr);
    return $formatter->format($time);
}

