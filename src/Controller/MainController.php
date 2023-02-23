<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Annotation\Route;

// Chargement du service
use App\Service\Capitalize;
use App\Util\Censurator;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */ 
    public function index() :Response
    {		
        return $this->render('main/home.html.twig');
    } // -- index()
	
	/**
     * @Route("/test", name="main_test")
     */
    public function test(Capitalize $capitalize): Response
    {
        if ($this->getUser()) {
            $participant = $this->getUser();

            $sFirstname = $participant->getFirstname();

            // Utilisation d'une méthode du service
            $sFirstname = $capitalize->toUpper($sFirstname);

            $participant->setFirstname($sFirstname);
        }

        return $this->render('main/test.html.twig');
    } // -- test()

     /**
     * @Route("/censur", name="main_censur")
     */
    public function censur(Censurator $censurator): Response
    {
        $s = "Dave Loper is a very bad guy who plays casino, eats bananas and takes viagra.";

        //censure les méchants mots
        $sPurified = $censurator->purify($s);

        return $this->render('main/censur.html.twig', ['description' => $s, 'purified' => $sPurified]);
    } // -- censur()

    /**
     * @Route("/imgtst", name="main_imgtst")
     */
    public function imgtst(): Response
    {
        return $this->render('main/imgtst.html.twig');
    } // -- imgtst()

} // -- class