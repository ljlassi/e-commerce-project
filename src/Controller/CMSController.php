<?php


namespace App\Controller;


use App\Entity\CMSBanner;
use App\Form\Type\CMSBannerFormType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Environment;

class CMSController extends AbstractController
{

    /**
     * @Route("/admin/cms/banner", name="cms_change_banner")
     *
     * @param Environment $twig
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function changeBanner(Environment $twig, Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $cmsBanner = $this->getDoctrine()->getRepository(CMSBanner::class)
            ->findOneBy(array("role" => "frontpage"));
        if($cmsBanner == null) {
            $cmsBanner = new CMSBanner();
        }
        $form = $this->createForm(CMSBannerFormType::class, $cmsBanner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageUrl')->getData();

            // this condition is needed because the 'image' field is not required
            // so the image file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    echo $e->getMessage();
                }

                // updates the 'imageFilename' property to store the image file name
                // instead of its contents
                $cmsBanner->setImageUrl($newFilename);
            }
            $cmsBanner = $form->getData();

            $entityManager->persist($cmsBanner);
            $entityManager->flush();

            $form = $form->createView();
            $cmsBanner = $this->getDoctrine()->getRepository(CMSBanner::class)
                ->findOneBy(array("role" => "frontpage"));

            return new Response($twig->render('admin/cms/change_banner.html.twig', ['form' => $form, 'cmsBanner' => $cmsBanner, 'message' => 'Successfully changed banner image.']));

        }
        else {
            $form = $form->createView();
            $cmsBanner = $this->getDoctrine()->getRepository(CMSBanner::class)
                ->findOneBy(array("role" => "frontpage"));
            return new Response($twig->render('admin/cms/change_banner.html.twig', ['form' => $form, 'cmsBanner' => $cmsBanner]));
        }
    }

    /**
     * Retrieve CMSBanner
     *
     * @Rest\Get("/api/cms/banner/get", name="get_cms_banner")
     *
     * @return Response
     */

    public function getCMSBanner() : Response {
        $cmsBanner = $this->getDoctrine()->getRepository(CMSBanner::class)
            ->findOneBy(array("role" => "frontpage"));
        return new Response($cmsBanner->getImageUrl());
    }
}