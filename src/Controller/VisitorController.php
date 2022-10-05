<?php

namespace App\Controller;

use App\Repository\VisitorRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VisitorController extends AbstractController
{
    private $visitorRepository;

    public function __construct(VisitorRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }

    /**
     * @Route("/api/visitors", name="api_create_visitor", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $birthday = $data['birthday'];
        $type = $data['type'];
        $gender = $data['gender'];

        if (empty($name) || empty($type)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        //$this->visitorRepository->savevisitor($name, $type, $photoUrls);

        return new JsonResponse(['status' => 'visitor created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/visitors/{id}", name="api_get_visitor", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $visitor = $this->visitorRepository->findOneBy(['id' => $id]);

        $data = [
            'firstName' => $visitor->getFirstName(),
            'lastName' => $visitor->getLastName(),
            'birthday' => $visitor->getBirthday(),
            'type' => $visitor->getType(),
            'gender' => $visitor->getGender(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/visitors", name="api_get_all_visitors", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $visitors = $this->visitorRepository->findAll();
        $data = [];

        foreach ($visitors as $visitor) {
            $data[] = [
                'firstName' => $visitor->getFirstName(),
                'lastName' => $visitor->getLastName(),
                'birthday' => $visitor->getBirthday(),
                'type' => $visitor->getType(),
                'gender' => $visitor->getGender(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/find_visitor", name="api_find_visitor", methods={"POST"})
     */
    public function findVisitor(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $visitors = $this->visitorRepository->findFromReservationModule($data);
        $data = [];

        foreach ($visitors as $visitor) {
            $data[] = [
                'firstName' => $visitor->getFirstName(),
                'lastName' => $visitor->getLastName(),
                'birthday' => $visitor->getBirthday(),
                'type' => $visitor->getType(),
                'gender' => $visitor->getGender(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    
    
    
    /**
     * @Route("visitor/{id}", name="update_visitor", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        // $visitor = $this->visitorRepository->findOneBy(['id' => $id]);
        // $data = json_decode($request->getContent(), true);

        // empty($data['name']) ? true : $visitor->setName($data['name']);
        // empty($data['type']) ? true : $visitor->setType($data['type']);
        // empty($data['photoUrls']) ? true : $visitor->setPhotoUrls($data['photoUrls']);

        // $updatedvisitor = $this->visitorRepository->updatevisitor($visitor);

		return new JsonResponse(['status' => 'visitor updated!'], Response::HTTP_OK);
    }

    /**
     * @Route("visitor/{id}", name="delete_visitor", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        // $visitor = $this->visitorRepository->findOneBy(['id' => $id]);

        // $this->visitorRepository->removevisitor($visitor);

        return new JsonResponse(['status' => 'visitor deleted'], Response::HTTP_OK);
    }
    
}
