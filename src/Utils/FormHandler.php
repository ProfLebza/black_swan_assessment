<?php


namespace App\Utils;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class FormHandler
{

    /**
     * Saves a symfony form, reduces code duplication in the controllers.
     *
     * @param FormInterface $form
     * @param int $id
     * @param Object $entity This should be an instance of an Entity.
     * @param EntityManagerInterface $manager
     * @param string $descriptor Should describe what the entity is about
     * @param mixed $callBackFunction This can either be a function or array of both and object and a function respectively
     * @return array
     */
    public static function saveForm(FormInterface $form, int &$id, $entity, EntityManagerInterface $manager, string $descriptor, $callBackFunction = null): array
    {
        $response = ['success' => false, 'message' => '', 'type' => 'create', 'submitted' => false];

        if ($id > 0) {
            $response['type'] = 'update';
        }

        if ($form->isSubmitted() && $form->isValid()) {

            self::handleCallBackFunction($callBackFunction, $entity);
            $response['submitted'] = true;
            if ($id == 0) {
                $manager->persist($entity);
            }
            $manager->flush();
            self::handleSuccessfulSave($entity, $id, $descriptor, $response);

        } else if ($form->isSubmitted() && !$form->isValid()) {
            self::handleFormErrors($form, $descriptor, $response);
        }
        return $response;
    }


    /**
     * @param FormInterface $form
     * @param string $descriptor
     * @param array $response
     */
    protected static function handleFormErrors(FormInterface $form, string $descriptor, array  &$response): void
    {
        $formErrorMessage = "";
        foreach ($form->getErrors() as $errorMessage) {
            $formErrorMessage .= $errorMessage->getMessage();
        }
        $response['message'] = "Could not {$response['type']} {$descriptor}, some of the fields in the form are not valid" . $formErrorMessage;
        $response['success'] = false;
    }


    /**
     * @param $callBackFunction
     * @param Object $entity
     */
    protected static function handleCallBackFunction($callBackFunction, $entity): void
    {
        if (null !== $callBackFunction) {
            if (is_array($callBackFunction)) {
                $callBackFunction[0]->$callBackFunction[1]($entity);
            } else {
                $callBackFunction($entity);
            }
        }
    }
    
    /**
     * @param Object $entity
     * @param $id
     * @param string $descriptor
     * @param  array $response
     */
    protected static function handleSuccessfulSave($entity, &$id, string $descriptor, array &$response): void
    {
        $id = $entity->getId();
        if ($id !== null) {
            $response['success'] = true;
            $response['message'] = "{$descriptor} has been successfully {$response['type']}d.";
        } else {
            $response['success'] = false;
            $response['message'] = "{$descriptor} was not {$response['type']}d due to database related issues. Please notify the admin";
        }
    }

}