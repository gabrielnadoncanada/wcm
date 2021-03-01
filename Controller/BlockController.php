<?php

namespace Nadmin\WcmBundle\Controller;

use Nadmin\WcmBundle\Entity\Block;
use Nadmin\WcmBundle\Form\BlockType;
use Nadmin\WcmBundle\Repository\BlockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/block")
 */
class BlockController extends AbstractController
{
    /**
     * @Route("s", name="wcm_blocks_index", methods={"GET"})
     */
    public function index(BlockRepository $blockRepository): Response
    {
        return $this->render('@Wcm/block/index.html.twig', [
            'blocks' => $blockRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="wcm_block_add", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $block = new Block();
        $form = $this->createForm(BlockType::class, $block);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($block);
            $entityManager->flush();

            return $this->redirectToRoute('wcm_blocks_index');
        }

        return $this->render('@Wcm/block/new.html.twig', [
            'block' => $block,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="wcm_block_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Block $block): Response
    {
        $form = $this->createForm(BlockType::class, $block);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wcm_blocks_index');
        }

        return $this->render('@Wcm/block/edit.html.twig', [
            'block' => $block,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wcm_block_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Block $block): Response
    {
        if ($this->isCsrfTokenValid('delete'.$block->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($block);
            $entityManager->flush();
        }

        return $this->redirectToRoute('wcm_blocks_index');
    }
}
