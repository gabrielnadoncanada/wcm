<?php

namespace Nadmin\WcmBundle\Controller;

use Nadmin\WcmBundle\Entity\Product;
use Nadmin\WcmBundle\Entity\Image;
use Nadmin\WcmBundle\Form\ProductType;
use Nadmin\WcmBundle\Helper\ControllerTrait;
use Nadmin\WcmBundle\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/admin/product")
 */
class ProductController extends AbstractController
{
    use ControllerTrait;

    /**
     * @Route("s", name="wcm_products_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('@Wcm/product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="wcm_product_add", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($product->getImages() as $linkedImage)
            {
                if ( $linkedImage->getFileTemp()!= null)
                {
                    $linkedImage->setFile($this->uploadFile($linkedImage->getFileTemp()));
                }
                else
                {
                    $product->removeImage($linkedImage);
                }
            }
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('wcm_product_index');
        }

        return $this->render('@Wcm/product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="wcm_product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles = array();
            foreach ($form['images'] as $doc)
            {
                array_push($uploadedFiles, $doc['fileTemp']->getData());
            }
            if ($uploadedFiles)
            {
                $cmpt = 0;
                foreach ($product->getImages() as $linkedImage)
                {
                    if ($uploadedFiles[$cmpt])
                    {
                        $linkedImage->setFile($this->uploadFile($uploadedFiles[$cmpt]));
                    }
                    $cmpt++;
                }
            }
            // Remove images where files are null.
            // Ex: user click add images but doesnt link a file.
            $this->removeEmptyImages($product);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wcm_product_index');
        }

        return $this->render('@Wcm/product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wcm_product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('wcm_product_index');
    }

    /**
     * @Route("{productID}/{id}/deleteImage", name="product_deleteImage", methods={"DELETE"})
     * @ParamConverter("product", options={"id" = "productID"})
     */
    public function deleteImage(Request $request, Product $product, Image $image): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token')))
        {
            $product->removeImage($image);
            $this->remove($image);
            $this->save($product);
        }
        return $this->redirectToRoute('wcm_product_edit',["id" => $product->getId()]);
    }

    /**
     * @Route("{imageID}/{productID}/setImagePrincipal/", name="setImagePrincipal")
     * @ParamConverter("product", options={"id" = "productID"})
     * @ParamConverter("image", options={"id" = "imageID"})
     */
    public function setImagePrincipal(Request $request, Product $product, Image $image )
    {
        foreach ($product->getImages() as $img)
        {
            $img->setIsPrincipal(false);
        }

        $image->setIsPrincipal(true);
        $this->getEm()->flush();

        if ($image->getIsPrincipal())
        {
            return  new JsonResponse('OK', Response::HTTP_OK);
        }
        else
        {
            return new JsonResponse('Image not set as principal', Response::HTTP_NOT_MODIFIED);
        }
    }

    /**
     * @Route("{imageID}/setImageTitle/", name="setImageTitle")
     * @ParamConverter("image", options={"id" = "imageID"})
     */
    public function setImageTitle(Request $request, Image $image )
    {
        $newTitle = $request->get('newTitle');
        $newAlt = $request->get('newAlt');
        $image
            ->setTitle($newTitle)
            ->setAlt($newAlt)
        ;

        $this->getEm()->flush();

        if ($image->getTitle() == $newTitle)
        {
            return  new JsonResponse('OK', Response::HTTP_OK);
        }
        else
        {
            return new JsonResponse('Image title/alt not modified', Response::HTTP_NOT_MODIFIED);
        }
    }
}
