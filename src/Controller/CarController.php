<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Cargo;
use App\Repository\CargoRepository;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
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
     * @return JsonResponse
     * @param CargoRepository $cargoRepository
     * @throws \Exception
     * @Route("/car", name="car_add", methods={"POST"})
     */

    public function addCar(Request $request, EntityManagerInterface $entityManager, CargoRepository $cargoRepository): object
    {
        try {
            $request = $this->transformJsonBody($request);

            if (!$request || !$request->get('number') || !$request->get('mark') || !$request->get('title')) {
                throw new \Exception();
            }
            $car = new Car();
            $cargo = $cargoRepository->findOneBy(['title' => $request->get('title')]);
            $car->setNumber($request->get('number'));
            $car->setMark($request->get('mark'));
            $car->setCargo($cargo);
            $entityManager->persist($car);
            $entityManager->flush();
            $data = [
                'status' => 200,
                'success' => "Car added successfully",
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
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param CarRepository $carRepository
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @throws \Exception
     * @Route("/user/add_car", name="user_add_car", methods={"POST"})
     */
    public function addCarToUser(Request $request, EntityManagerInterface $entityManager, CarRepository $carRepository, UserRepository $userRepository): object
    {
        try {
            $request = $this->transformJsonBody($request);

            if (!$request || !$request->get('name') || !$request->request->get('car_id')) {
                throw new \Exception();
            }
            $user = $userRepository->findOneBy(['name' => $request->get('name')]);
            $car  = $carRepository->findOneBy(['id' => $request->get('car_id')]);
            $car->setUserId($user);
            $entityManager->persist($car);
            $entityManager->flush();

            $data = [
                'status' => 200,
                'success' => "Car added successfully to user",
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

