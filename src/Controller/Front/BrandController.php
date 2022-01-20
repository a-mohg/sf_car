<?php

namespace App\Controller\Front;


use App\Repository\BrandRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BrandController extends AbstractController
{

    public function brandList(BrandRepository $brandRepository)
    {
        $brands = $brandRepository->findAll();

        return $this->render("front/brands.html.twig", ['brands' => $brands]);
    }

    public function brandShow($id, BrandRepository $brandRepository)
    {
        $brand = $brandRepository->find($id);

        return $this->render("front/brand.html.twig", ['brand' => $brand]);
    }
}