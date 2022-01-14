<?php


function PokazKontakt()
{
    return '
        <div>
            <h2>Skontaktuj się z nami</h2>
            <form method="POST" action="contact.php" id="contact-form">
                <div class="contact">
                  <span>Nazwa</span>
                  <input type="text" name="name" id="">
                </div>
                <div class="contact">
                  <span>E-mail</span>
                  <input type="email" name="email" id="">
                </div>
                <div class="contact">
                  <span>Temat</span>
                  <input type="text" name="subject" id="">
                </div>
                <div class="contact">
                  <span>Treść</span>
                  <textarea name="message" id="" cols="30" rows="10"></textarea>
                </div>
                <button type="submit">Wyślij</button>
              </form> 
        </div>  
        ';
}

function WyslijMailKontakt($odbiorca){
    $errors = [];
    $errorMessage = '';

    if (!empty($_POST)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $subject = $_POST['subject'];

        if (empty($name)) {
            $errors[] = 'Name is empty';
        }

        if (empty($email)) {
            $errors[] = 'Email is empty';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email is invalid';
        }

        if (empty($message)) {
            $errors[] = 'Message is empty';
        }

        if (empty($subject)) {
            $errors[] = 'Subject is empty';
        }


        if (empty($errors)) {
            $toEmail = 'example@example.com';
            $emailSubject = $subject;
            $headers = ['From' => $email, 'Reply-To' => $email, 'Content-type' => 'text/html; charset=iso-8859-1'];

            $bodyParagraphs = ["Name: {$name}", "Email: {$email}", "Message:", $message];
            $body = join(PHP_EOL, $bodyParagraphs);

            if (mail($toEmail, $emailSubject, $body, $headers)) {
                header('Location: thank-you.html');
            } else {
                $errorMessage = 'Oops, something went wrong. Please try again later';
            }
        } else {
            $allErrors = join('<br/>', $errors);
            $errorMessage = "<p style='color: red;'>{$allErrors}</p>";
        }
    }
}




?>