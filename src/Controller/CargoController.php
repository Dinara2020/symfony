<?php

namespace App\Controller;

use App\Entity\Cargo;
use App\Repository\CargoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CargoController extends AbstractController
{
//    /**
//     * @Route("/users", name="user")
//     */
//    public function index(): Response
//    {
//        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
//        dd($users);
//        foreach ($users as $user) {
//            $result['id'] = $user->getId();
//            $result['id'] = [];
//            $result['id'][$user->getId()] = [];
//            $result['id'][$user->getId()] = $user->getId();
//            $result['id'][$user->getId()]['name'] = [];
//            $result['id'][$user->getId()]['name'] = $user->getName();
//        }
//        return new Response(json_encode($result));
//    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param CargoRepository $cargoRepository
     * @return JsonResponse
     * @throws \Exception
     * @Route("/cargo", name="cargo_add", methods={"POST"})
     */
    public function addCargo(Request $request, EntityManagerInterface $entityManager, CargoRepository $cargoRepository): object
    {
        try {
            $request = $this->transformJsonBody($request);

            if (!$request || !$request->get('title')) {
                throw new \Exception();
            }
            $cargo = new Cargo();
            $cargo->setTitle($request->get('title'));
            $entityManager->persist($cargo);
            $entityManager->flush();

            $data = [
                'status' => 200,
                'success' => "Cargo added successfully",
            ];
            return $this->response($data);

        } catch (\Exception $e) {
            $data = [
                'status' => 422,
                'errors' => "Data no valid",
            ];
            return $this->response($data, 422);
        }

    }
    /**
     * Returns a JSON response
     *
     * @param array $data
     * @param $status
     * @param array $headers
     * @return JsonResponse
     */
    public function response($data, $status = 200, $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
    }

    protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}

