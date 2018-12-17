<?php

namespace Controller;

use Twig_Loader_Filesystem;
use Twig_Environment;

class ContactFormController extends AbstractController
{

    public function contactForm()
    {

        $formErrors = [
            'errLastname' => [''],
            'errFirstname' => [''],
            'errTypo' => [''],
            'errMail' => [''],
            'errBadMail' => [''],
            'errMessage' => [''],
            'success' => [''],
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['lastname'])) {
                $formErrors['errLastname'][0] = 'Veuillez renseigner votre nom de famille.';
            } else {
                $lastname = $this->testInput($_POST["lastname"]);
                if (!preg_match("/^[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ ]*$/", $lastname)) {
                    $formErrors['errLastname'][0] = 'Seuls les lettres et les espaces sont autorisés.';
                }
            }

            if (empty($_POST['firstname'])) {
                $formErrors['errFirstname'][0] = 'Veuillez renseigner votre prénom.';
            } else {
                $firstname = $this->testInput($_POST["firstname"]);
                if (!preg_match("/^[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ ]*$/", $firstname)) {
                    $formErrors['errFirstname'][0] = 'Seuls les lettres et les espaces sont autorisés.';
                }
            }

            if (empty($_POST['mail'])) {
                $formErrors['errMail'][0] = 'Veuillez renseigner votre adresse email.';
            } else {
                if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                    $formErrors['errMail'][0] = 'Votre adresse email est invalide.';
                }
            }

            if (empty($_POST['message'])) {
                $formErrors['errMessage'][0] = 'Veuillez renseigner un message.';
            }

            if ($formErrors['errLastname'][0] == '' and $formErrors['errFirstname'][0] == ''
                and $formErrors['errMail'][0] == '' and $formErrors['errMessage'][0] == '') {
                $nom = htmlentities($_POST['lastname']);
                $prenom = htmlentities($_POST['firstname']);
                $email = htmlentities($_POST['mail']);
                $message = htmlentities($_POST['message']);

                $destinataire = 'luanalorthios@windowslive.com';
                $sujet = 'Formulaire de contact';

                $contenu = '<html><head><title>Titre du message</title></head><body>';
                $contenu .= '<p>Bonjour, vous avez reçu un message à partir de votre site web.</p>';
                $contenu .= '<p><strong>Nom</strong>: ' . $nom . '</p>';
                $contenu .= '<p><strong>Prénom</strong>: ' . $prenom . '</p>';
                $contenu .= '<p><strong>Email</strong>: ' . $email . '</p>';
                $contenu .= '<p><strong>Message</strong>: ' . $message . '</p>';
                $contenu .= '</body></html>';

                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                mail($destinataire, $sujet, $contenu, $headers);
                $formErrors['success'][0] = 'Message envoyé.';
            }
        }
        return $this->twig->render('Homepage/ContactForm.html.twig', ['formErrors' => $formErrors]);
    }

    public function testInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
