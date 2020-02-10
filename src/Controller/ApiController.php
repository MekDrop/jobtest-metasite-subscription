<?php

namespace App\Controller;

use App\Entities\Subscriber;
use App\Repository\SubscriberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api", name="api.")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/subscribe", name="subscribe", methods="POST")
     *
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param SubscriberRepository $repository
     * @return JsonResponse
     * @throws \Exception
     */
   public function subscribe(Request $request, ValidatorInterface $validator, SubscriberRepository $repository) {
        $subscriber = new Subscriber();
        $subscriber
            ->setEmail(
                $request->get('email')
            )
            ->setCategories(
                array_filter(
                    explode(
                        ',',
                        $request->get('categories')
                    )
                )
            )
            ->setName(
                $request->get('name')
            );

       $errors = $validator->validate($subscriber);
       if (count($errors) > 0) {
           $ret = [];
           /**
            * @var ConstraintViolationInterface $error
            */
           foreach ($errors as $error) {
               $elName = $error->getPropertyPath();
               if (!isset($ret[$elName])) {
                   $ret[$elName] = [];
               }
               $ret[$elName][] = $error->getMessage();
           }
           return new JsonResponse(['errors' => $ret]);
       }

       $repository->save($subscriber);

       return new JsonResponse([]);
   }

    /**
     * @Route("/login", name="login", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $user = $this->getUser();

        return new JsonResponse([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ]);
    }
}
