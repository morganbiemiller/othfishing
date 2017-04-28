<?php

// configure
$from = 'Demo contact form <captken@othfishing.com>';
$sendTo = 'Demo contact form <morganbiemiller@gmail.com>';
$subject = 'New booking inquiry';
$fields = array(
				'first_name' => 'First Name',
				'last_name' => 'Last Name',
				'phone' => 'Phone',
				'email' => 'Email',
				'address' => 'Address',
				'city' => 'City',
				'state' => 'State',
				'zip' => 'Zip',
				'date' => 'Preferred Date',
				'fish' => 'Fish Preference',
				'concerns' => 'Questions or Concerns'
			); // array variable name => Text to appear in the email
$okMessage = 'Thank you! Your booking inquiry was successfully submitted. We will get back to you soon!';
$errorMessage = 'There was an error while submitting the form. Please try again';

// let's do the sending
try
{
    $emailText = "You have new message from contact form\n=============================\n";

    foreach ($_POST as $key => $value) {
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}