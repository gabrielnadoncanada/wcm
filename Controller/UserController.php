<?php

namespace Nadmin\WcmBundle\Controller;


use Nadmin\WcmBundle\Entity\User;
use Nadmin\WcmBundle\Form\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Config\Route("/admin/user")
 */
class UserController
    extends AbstractController {

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Config\Route("s", name="app_wcm_users")
     *
     * @Config\Template
     * @return array
     */
    public function index()
    {
        return [
            'title' => 'WCM - Users',
            'users' => $this->getDoctrine()->getRepository(User::class)->findAll()
        ];
    }

    /**
     * @Config\Route("/new", name="app_wcm_add_user", methods="GET|POST")
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

        return [
            'user' => $user,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Config\Route("/{id}/edit", name="app_wcm_edit_user", methods="GET|POST")
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

        return [
            'user' => $user,
            'form' => $form->createView()
        ];
    }

    /**
     * @Config\Route("/{id}", name="app_wcm_delete_user", methods="DELETE")
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

    /**
     * @Config\Route("/", name="app_wcm_user_show")
     *
     * @Config\Template
     * @return array
     */
    public function show(Request $request)
    {
        $id = $request->query->get('id');
        return [
            'title' => 'WCM - User',
            'user' => $this->getDoctrine()->getRepository(User::class)->find($id)

        ];
    }

}
