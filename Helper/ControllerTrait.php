<?php


namespace Nadmin\WcmBundle\Helper;


use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

Trait ControllerTrait
{

    public function uploadFile(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

        try
        {
            $file->move($this->getParameter('images_directory'), $fileName);
        }
        catch (FileException $e)
        {

        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }


    public function uploadFiles($fileCollection)
    {
        foreach ($fileCollection as $file)
        {
            $this->uploadFile($file);
        }
    }

    public function save($entity)
    {
        $this->getEm()->persist($entity);
        $this->getEm()->flush();
    }

    public function remove($entity)
    {
        $this->getEm()->remove($entity);
        $this->getEm()->flush();
    }

    public function removeEmptyImages(Product $product)
    {
        foreach ($product->getImages() as $image)
        {
            if ($image->getFile() == null)
            {
                $product->removeImage($image);
            }
        }
    }


    public function getEm()
    {
        return $this->getDoctrine()->getManager();
    }

    public function isValid(Form &$form, $request)
    {
        $form->handleRequest($request);

        return   $form->isSubmitted() && $form->isValid();
    }

}
