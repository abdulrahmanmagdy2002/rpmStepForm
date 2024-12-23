<?php
// process.php

// Ensure request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve personal info
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $lastName  = isset($_POST['lastName'])  ? $_POST['lastName']  : '';
    $phone     = isset($_POST['phone'])     ? $_POST['phone']     : '';
    // Check TCPA box
    $tcpa      = isset($_POST['tcpa'])      ? $_POST['tcpa']      : '';

    // Retrieve multi-step answers from hidden field (JSON)
    $answersJson = isset($_POST['answers']) ? $_POST['answers'] : '';
    // Convert JSON to array
    $answers = json_decode($answersJson, true);

    // Basic output (for demonstration)
    echo "<h1>Thank You for Your Submission</h1>";
    echo "<h2>User Info</h2>";
    echo "<p><strong>First Name:</strong> " . htmlspecialchars($firstName) . "</p>";
    echo "<p><strong>Last Name:</strong> " . htmlspecialchars($lastName) . "</p>";
    echo "<p><strong>Phone:</strong> " . htmlspecialchars($phone) . "</p>";
    echo "<p><strong>TCPA Consent:</strong> " . ($tcpa === 'Yes' ? 'Agreed' : 'Not Checked') . "</p>";

    echo "<hr>";
    echo "<h2>Answers to Multi-Step Questions</h2>";
    if (is_array($answers)) {
        foreach ($answers as $index => $answer) {
            $qNumber = $index + 1;
            // Escape output to prevent XSS
            $safeAnswer = htmlspecialchars($answer);
            echo "<p><strong>Question $qNumber:</strong> $safeAnswer</p>";
        }
    } else {
        echo "<p>No answers received.</p>";
    }

} else {
    // If someone accesses process.php directly (without POST)
    echo "Invalid request method. Please submit the form.";
}
?>
