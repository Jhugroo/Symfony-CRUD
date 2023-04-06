<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

use FOS\RestBundle\Controller\AbstractFOSRestController;
abstract class AbstractApiController extends AbstractFOSRestController {

    protected function buildForm(string $type, $data = null, array $options = []): FormInterface {

        return $this->container->get('form.factory')->createNamed('', $type, $data, $options);
    }

    protected function respond($data, int $statusCode = Response::HTTP_OK): Response {
        return $this->handleView($this->view($data, $statusCode));
    }
}
