<?php

namespace App\Controller\Admin;

use App\Entity\Brand;
use App\Form\BrandType;
use Symfony\Component\Mime\Email;
use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBrandController extends AbstractController
{

    public function adminListBrand(BrandRepository $brandRepository)
    {
        $brands = $brandRepository->findAll();

        return $this->render("admin/brands.html.twig", ['brands' => $brands]);
    }

    public function adminShowBrand($id, BrandRepository $brandRepository)
    {
        $brand = $brandRepository->find($id);

        return $this->render("admin/brand.html.twig", ['brand' => $brand]);
    }

    public function adminUpdateBrand(
        $id,
        BrandRepository $brandRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ) {

        $brand = $brandRepository->find($id);

        $brandForm = $this->createForm(BrandType::class, $brand);

        $brandForm->handleRequest($request);

        if ($brandForm->isSubmitted() && $brandForm->isValid()) {

            $entityManagerInterface->persist($brand);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_brand_list");
        }


        return $this->render("admin/brandform.html.twig", ['brandForm' => $brandForm->createView()]);
    }

    public function adminBrandCreate(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        MailerInterface $mailerInterface
    ) {
        $brand = new Brand();

        $brandForm = $this->createForm(WriterType::class, $brand);

        $brandForm->handleRequest($request);

        if ($brandForm->isSubmitted() && $brandForm->isValid()) {


            $entityManagerInterface->persist($brand);
            $entityManagerInterface->flush();

            $email = (new Email())
                ->from('test@test.com')
                ->to('test@test.fr')
                ->subject('Création d\'un auteur')
                ->html('<p>Vous êtes un nouvel auteur su le projet</p>');

            $mailerInterface->send($email);

            return $this->redirectToRoute("admin_brand_list");
        }


        return $this->render("admin/brandform.html.twig", ['brandForm' => $brandForm->createView()]);
    }

    public function adminDeleteBrand(
        $id,
        BrandRepository $brandRepository,
        EntityManagerInterface $entityManagerInterface
    ) {

        $brand = $brandRepository->find($id);

        $entityManagerInterface->remove($brand);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_brand_list");
    }


    public function adminSearch(BrandRepository $brandRepository, Request $request)
    {
        $term = $request->query->get('term');

        $brands = $brandRepository->searchByTerm($term);

        return $this->render('admin/search.html.twig', ['term' => $term, 'brands' => $brands]);
    }
}