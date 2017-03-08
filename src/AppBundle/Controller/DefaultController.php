<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use AppBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $texto = $this->getTestDescription();
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $factory = $this->get('security.encoder_factory');

            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);
//            $registration = $form->getData();
            $user->setEmail($user->getUsername() . "@a.com");
            $userManager->updateUser($user);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("questions");
        }

        return $this->render('/home.html.twig', array ('home_text' => $texto,
                                                        'form' => $form->createView()));
        // replace this example code with whatever you need
//        return $this->render('default/index.html.twig', [
//            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
//        ]);
    }
    private function getTestDescription()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Test');
        $test = $repository->findAll();
        if ($test)
            return $test[0]->getDescription();

        return "";
    }
    /**
     * @Route("/questions", name="questions")
     */
    public function questionsAction(Request $request)
    {

        return $this->render('/questions.html.twig', array ('home_text' => "Ahora, las preguntas"));
        // replace this example code with whatever you need
//        return $this->render('default/index.html.twig', [
//            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
//        ]);
    }

}
