<?php

// Check if the "prompt" parameter exists
if (!isset($_POST['prompt'])) {
    die('Invalid request');
}

$host = '192.168.2.137';
$port = 5000;
$uri = "http://$host:$port/api/v1/generate";

$request = array(
    'prompt' => $_POST['prompt'],
    'max_new_tokens' => 250,
    'do_sample' => true,
    'temperature' => 0.7,
    'top_p' => 0.1,
    'typical_p' => 1,
    'epsilon_cutoff' => 0,
    'eta_cutoff' => 0,
    'tfs' => 1,
    'top_a' => 0,
    'repetition_penalty' => 1.18,
    'top_k' => 40,
    'min_length' => 0,
    'no_repeat_ngram_size' => 0,
    'num_beams' => 1,
    'penalty_alpha' => 0,
    'length_penalty' => 1,
    'early_stopping' => false,
    'mirostat_mode' => 0,
    'mirostat_tau' => 5,
    'mirostat_eta' => 0.1,
    'seed' => -1,
    'add_bos_token' => true,
    'truncation_length' => 2048,
    'ban_eos_token' => false,
    'skip_special_tokens' => true,
    'stopping_strings' => array()
);

// Convert the request data to JSON
$jsonRequest = json_encode($request);

// Make the POST request to the Python API
$ch = curl_init($uri);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonRequest);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$response = curl_exec($ch);
curl_close($ch);

// Process the response
if ($response) {
    $result = json_decode($response, true)['results'][0]['text'];
    echo $_POST['prompt'] . $result;
} else {
    echo 'Error occurred while executing the Python code.';
}

?>
