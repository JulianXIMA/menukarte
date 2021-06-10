<?php

namespace App\Controller;

use App\Entity\Bestellung;
use App\Entity\Gericht;
use App\Repository\BestellungRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BestellungController extends AbstractController
{
    #[Route('/bestellung', name: 'bestellung')]
    public function index(BestellungRepository $bestellungRepository): Response
    {


        return $this->render('bestellung/index.html.twig', [
            'controller_name' => 'BestellungController',
        ]);
    }

    #[Route('/bestellen/{id}', name: 'bestellen')]
    public function bestellen(Gericht $gericht): Response
    {
        $bestellung = new Bestellung();
        $bestellung->setTisch('tisch1');
        $bestellung->setName($gericht->getName());
        $bestellung->setBnummer($gericht->getId());
        $bestellung->setPreis($gericht->getPreis());
        $bestellung->setStatus('offen');

        $em = $this->getDoctrine()->getManager();
        $em->persist($bestellung);
        $em->flush();

        $this->addFlash('bestell', $bestellung->getName() . ' wurde zur Bestellung hinzugefügt');

        return $this->redirect($this->generateUrl('menu'));
    }
}
