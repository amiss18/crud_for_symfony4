<?php
/**
 *  * Created by PhpStorm.
 * User: armel ( @armel.m )
 * Date: 28/11/17
 * Time: 14:23
 */

namespace App\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Events;
use Twig_Environment;

class ProductNotification implements EventSubscriberInterface {


    private $mailer;
    private $sender;
    private $twig;

    public function __construct(\Swift_Mailer $mailer,Twig_Environment $twig, string $sender) {
        $this->mailer = $mailer;
        $this->sender = $sender;
        $this->twig =   $twig;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents(): array {
        return [
            Events::PRODUCT_DELETE => 'onProductDeleted',
        ];
    }


    public function onProductDeleted(): void {

        $subject = "Remove entity";

        $body ="the product number is delete";
        $name = "anonymous";
        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setTo("author@dev.com")
            ->setFrom($this->sender)
            ->setBody( $this->twig->render( "email.html.twig",
                [
                    "subject"    => $subject,
                    "name"      => $name,
                ]), 'text/html')
        ;

        // In app/config/config_dev.yml the 'disable_delivery' option is set to 'true'.
        // That's why in the development environment you won't actually receive any email.
        // However, you can inspect the contents of those unsent emails using the debug toolbar.
        // See https://symfony.com/doc/current/email/dev_environment.html#viewing-from-the-web-debug-toolbar
        $this->mailer->send($message);
    }



}