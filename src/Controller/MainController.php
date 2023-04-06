<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use App\Entity\Equipment;
use  App\Form\EquipmentType;
use App\Controller\AbstractApiController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;




class MainController extends AbstractApiController {

    public function indexAction(Request $request, PersistenceManagerRegistry $doctrine): Response {
        $equipments = $doctrine->getRepository(Equipment::class)->findAll();

        return $this->respond($equipments);
    }

    public function createAction(Request $request, PersistenceManagerRegistry $doctrine): Response {

        $form = $this->buildForm(EquipmentType::class);
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }
        /** @var equipment equipment */
        $equipment = $form->getData();
        $doctrine->getManager()->persist($equipment);
        $doctrine->getManager()->flush();

        return $this->respond($equipment);
    }

    public function updateAction(Request $request, PersistenceManagerRegistry $doctrine): Response {

        $equipmentId = $request->get('equipmentId');
        $equipment = $doctrine->getRepository(Equipment::class)->findoneBy(['id' => $equipmentId]);
        if (!$equipment) {
            throw new NotFoundHttpException('Equipment not found');
        }

        $form = $this->buildForm(EquipmentType::class, $equipment, [
            'method' => $request->getMethod()
        ]);
        $form->submit($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }
        /** @var equipment equipment */
        $equipment = $form->getData();
        $doctrine->getManager()->persist($equipment);
        $doctrine->getManager()->flush();

        return $this->respond($equipment);
    }

    public function deleteAction(Request $request, PersistenceManagerRegistry $doctrine): Response {

        $equipmentId = $request->get('equipmentId');
        $equipment = $doctrine->getRepository(Equipment::class)->findoneBy(['id' => $equipmentId]);
        if (!$equipment) {
            throw new NotFoundHttpException('Equipment not found');
        }

        $doctrine->getManager()->remove($equipment);
        $doctrine->getManager()->flush();

        return $this->respond($equipment);
    }
}
