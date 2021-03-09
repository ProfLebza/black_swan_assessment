<?php


namespace App\EventListener;


use ReCaptcha\ReCaptcha;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;

class ReCaptchaValidationListener implements EventSubscriberInterface
{

    private $reCaptcha;

    /**
     * ReCaptchaValidationListener constructor.
     * @param ReCaptcha $reCaptcha
     */
    public function __construct(ReCaptcha $reCaptcha)
    {
        $this->reCaptcha = $reCaptcha;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SUBMIT => 'onPostSubmit'
        ];
    }

    /**
     * @param FormEvent $event
     */
    public function onPostSubmit(FormEvent $event)
    {
        $request = Request::createFromGlobals();

        $result = $this->reCaptcha
            ->setExpectedHostname($request->getHost())
            ->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());

        if (!$result->isSuccess()) {
            $event->getForm()->addError(new FormError('The captcha is invalid. Please try again.'));
        }
    }
}