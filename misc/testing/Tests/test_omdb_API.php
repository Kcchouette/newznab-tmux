<?php

require_once dirname(__DIR__, 3).DIRECTORY_SEPARATOR.'bootstrap/autoload.php';

use aharen\OMDbAPI;
use nntmux\ColorCLI;

$omdb = new OMDbAPI();

if (! empty($argv[1]) && ! empty($argv[2]) && ($argv[2] !== 'series' || $argv[2] !== 'movie')) {

    // Test if your OMDb API key and configuration are working
    // If it works you should get a printed array of the show entered

    // Search for a show
    $search = $omdb->search((string) $argv[1], (string) $argv[2]);
    if (is_object($search) && $search->data->Response !== 'False') {
        print_r($search->data->Search[0]->Title.PHP_EOL);
    }

    // Use the first show found (highest match) and get the requested season/episode from $argv
    if (is_object($search) && $search->data->Response !== 'False') {
        $search = $omdb->fetch('i', $search->data->Search[0]->imdbID);

        print_r($search);
    } else {
        exit(ColorCLI::error('Error retrieving OMDb API data.'));
    }
} else {
    exit(ColorCLI::error('Invalid arguments. This script requires a text string (show name), and a second argument, movie or series.'));
}
