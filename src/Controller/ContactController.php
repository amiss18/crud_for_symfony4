<?php

namespace App\Controller;

use function dump;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use function strlen;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController {
    /**
     * @Route("/contact", name="contact")
     */
    public function index() {

        return $this->render('contact/index.html.twig');
    }

    /**
     * @Route("sendMail", name="send_mail")
     */
    public function  sendEmail( Request $request, \Swift_Mailer $mailer ){
        $name = $request->get('name');
        $body = $request->get('message');
        $email = $request->get('email');


        if( empty($email) && empty($body)){
            return new  Response("thoses fields are requires");
        }


        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo('admin@campany.com')
            ->setBody(
                $this->renderView(
                    'contact/email.html.twig',
                    array('name' => $name)
                ),
                'text/html'
            );


        $mailer->send($message);

        return $this->render('contact/success.html.twig');
    }

}
