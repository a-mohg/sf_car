<?php

namespace App\Controller\Admin;

use App\Form\GroupeType;
use App\Entity\Groupe;
use App\Repository\GroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminGroupeController extends AbstractController
{

    public function adminListGroupe(GroupeRepository $groupeRepository)
    {
        $groupes = $groupeRepository->findAll();

        return $this->render("admin/groupes.html.twig", ['groupes' => $groupes]);
    }

    public function adminShowGroupe($id, GroupeRepository $groupeRepository)
    {
        $groupe = $groupeRepository->find($id);

        return $this->render("admin/groupe.html.twig", ['groupe' => $groupe]);
    }

    public function adminUpdateGroupe(
        $id,
        GroupeRepository $groupeRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ) {

        $groupe = $groupeRepository->find($id);

        $groupeForm = $this->createForm(GroupeType::class, $groupe);

        $groupeForm->handleRequest($request);

        if ($groupeForm->isSubmitted() && $groupeForm->isValid()) {

            $entityManagerInterface->persist($groupe);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_groupe_list");
        }


        return $this->render("admin/groupeform.html.twig", ['groupeForm' => $groupeForm->createView()]);
    }

    public function adminGroupeCreate(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $groupe = new Groupe();

        $groupeForm = $this->createForm(GroupeType::class, $groupe);

        $groupeForm->handleRequest($request);

        if ($groupeForm->isSubmitted() && $groupeForm->isValid()) {

            $entityManagerInterface->persist($groupe);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_groupe_list");
        }


        return $this->render("admin/groupeform.html.twig", ['groupeForm' => $groupeForm->createView()]);
    }

    public function adminDeleteGroupe(
        $id,
        GroupeRepository $groupeRepository,
        EntityManagerInterface $entityManagerInterface
    ) {

        $groupe = $groupeRepository->find($id);

        $entityManagerInterface->remove($groupe);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_groupe_list");
    }
}