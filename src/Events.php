<?php
namespace App;


/**
 *
 *  This interface defines the names of all the events dispatched in
 *  the application
 *
 * User: armel ( @armel.m )
 * Date: 28/11/17
 * Time: 14:31
 */

interface Events {

    /**
     * For the event naming conventions, see:
     * https://symfony.com/doc/current/components/event_dispatcher.html#naming-conventions.
     *
     * @Event("Symfony\Component\EventDispatcher\GenericEvent")
     *
     * @var string
     */
    const PRODUCT_DELETE='product.delete';
}