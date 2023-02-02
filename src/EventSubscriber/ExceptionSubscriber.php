<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        //récupération de l'exception
        $exception=$event->getThrowable();

        //vérification s'il s'agit d'une httpException
        //si oui récupération du code et du message
        if($exception instanceof HttpException){
            $data= [
                'status'=>$exception->getStatusCode(),
                'message'=>$exception->getMessage()
            ];

            //transformation de la réponse en Json
            $event->setResponse(new JsonResponse($data));
        }else

        //si non, ce sera une erreur générique
        {
            $data=[
                'status'=>500,
                'message'=>$exception->getMessage()
            ];

            $event->setResponse(new JsonResponse());
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
