<?php

namespace Nadmin\WcmBundle\Controller;

use Nadmin\WcmBundle\Entity\Node;
use Nadmin\WcmBundle\Form\NodeType;
use Nadmin\WcmBundle\Repository\NodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/nodes")
 */
class NodeController extends AbstractController
{
    /**
     * @Route("/", name="wcm_nodes_index", methods={"GET"})
     */
    public function index(NodeRepository $nodeRepository): Response
    {
        return $this->render('@Wcm/_shared/_index.html.twig', [
            'entity' => $nodeRepository->findAll(),
            'entity_title' => 'nodes',
            'fields' => ['id','title', 'locale', 'slug']
        ]);
    }

    /**
     * @Route("/new", name="wcm_nodes_add", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $node = new Node();
        $form = $this->createForm(NodeType::class, $node);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($node);
            $entityManager->flush();

            return $this->redirectToRoute('wcm_nodes_index');
        }

        return $this->render('@Wcm/_shared/_new.html.twig', [
            'node' => $node,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="wcm_nodes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Node $node): Response
    {
        $form = $this->createForm(NodeType::class, $node);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wcm_nodes_index');
        }
        return $this->render('@Wcm/_shared/_edit.html.twig', [
            'node' => $node,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="wcm_nodes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Node $node): Response
    {
        if ($this->isCsrfTokenValid('delete'.$node->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($node);
            $entityManager->flush();
        }

        return $this->redirectToRoute('wcm_nodes_index');
    }
}
