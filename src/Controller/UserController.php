<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
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
     * @param UserRepository $userRepository
     * @param $id
     * @return JsonResponse
     * @Route("/users/{id}", name="posts_get", methods={"GET"})
     */
    public function getUser(UserRepository $userRepository, $id){
        $user = $userRepository->find($id);

        if (!$user){
            $data = [
                'status' => 404,
                'errors' => "User not found",
            ];
            return $this->response($data, 404);
        }
        return $this->response($user);
    }
    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @throws \Exception
     * @Route("/user", name="user_add", methods={"POST"})
     */
    public function addUser(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): object
    {
        try {
            $request = $this->transformJsonBody($request);

            if (!$request || !$request->get('name') || !$request->request->get('age')) {
                throw new \Exception();
            }
            $user = new User();
            $user->setName($request->get('name'));
            $user->setAge($request->get('age'));
            $entityManager->persist($user);
            $entityManager->flush();

            $data = [
                'status' => 200,
                'success' => "User added successfully",
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