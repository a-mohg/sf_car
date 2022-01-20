<?php

namespace App\Controller\Front;

use App\Repository\GroupeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{

    public function groupeList(GroupeRepository $groupeRepository)
    {
        $groupes = $groupeRepository->findAll();

        return $this->render("front/groupes.html.twig", ['groupes' => $groupes]);
    }

    public function groupeShow($id, GroupeRepository $groupeRepository)
    {
        $groupe = $groupeRepository->find($id);

        return $this->render("front/groupe.html.twig", ['groupe' => $groupe]);
    }
}