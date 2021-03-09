<?php


namespace App\Controller;


use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;


class ApiController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/api/create-contact", name="api_create_contact", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {

        $response['data'] = [];
        parse_str($request->getQueryString(), $response['data']);
        $response['message'] = 'User not saved. No data was posted by the request';

        $responseCode = Response::HTTP_NO_CONTENT;

        if (count($response['data']) > 0) {
            $contact = new Contact();
            $contact->setName($response['data']['name'])
                ->setEmail($response['data']['email'])
                ->setMessage($response['data']['message']);

            $contactViolation = $this->validateContact($contact);

            if ($contactViolation->count()) {
                $this->handleBadRequest($request);
            }

            $this->entityManager->persist($contact);
            $this->entityManager->flush();

            $response['message'] = 'User has been successfully created';
            $responseCode = Response::HTTP_CREATED;
        }


        return new JsonResponse($response, $responseCode);

    }


    public function validateContact(Contact $contact): ConstraintViolationListInterface
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        return $validator->validate($contact);
    }

    private function handleBadRequest(Request $request)
    {
        throw new HttpException(
            400,
            sprintf('Invalid JSON: '.$request->getContent())
        );
    }


}