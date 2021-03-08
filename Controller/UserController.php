<?php

namespace Nadmin\WcmBundle\Controller;


use Nadmin\WcmBundle\Entity\User;
use Nadmin\WcmBundle\Form\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Config\Route("/admin/users")
 */
class UserController
    extends AbstractController {

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Config\Route("/", name="wcm_users_index")
     *
     * @Config\Template
     * @return array
     */
    public function index()
    {

        return $this->render('@Wcm/_shared/_index.html.twig',[
            'entity' => $this->getDoctrine()->getRepository(User::class)->findAll(),
            'entity_title' => 'users',
            'fields' => ['id','username']
        ]);
    }

    /**
     * @Config\Route("/new", name="wcm_users_new", methods="GET|POST")
     *
     * @Config\Template
     * @return array
     */
    public function new(Request $request)
    {
        $encoder = $this->passwordEncoder;
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_wcm_edit_user', ['id' => $user->getId()]);
        }

        return $this->render('@Wcm/_shared/_new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Config\Route("/{id}/edit", name="wcm_users_edit", methods="GET|POST")
     *
     * @Config\Template
     * @return array
     */
    public function edit(Request $request, User $user)
    {
        $password = $user->getPassword();
        $encoder = $this->passwordEncoder;
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form['password']->getData() != '') {
                $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            } else {
                $user->setPassword($password);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_wcm_edit_user', ['id' => $user->getId()]);
        }

        return $this->render('@Wcm/_shared/_edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Config\Route("/{id}/edit", name="wcm_users_delete", methods="DELETE")
     */
    public function delete(Request $request, User $user)
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('app_wcm_users');
    }
}
