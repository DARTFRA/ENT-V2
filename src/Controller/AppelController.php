<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Presence;
use App\Repository\CoursRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/appel')]
class AppelController extends AbstractController
{
    
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}', name: 'faire_appel')]
    public function faireAppel(int $id, Request $request, CoursRepository $coursRepository, UserRepository $userRepository): Response
    {

          // Vérifie la session pour voir si l'utilisateur est connecté
          $session = $request->getSession();
          $username = $session->get('username');
  
          if (!$username) {
              // Redirige vers la page de connexion Discord si l'utilisateur n'est pas connecté
              return $this->redirectToRoute('connect_discord');
          }
          $roles = $session->get('current_role'); // Rôle par défaut si aucun rôle n'est trouvé
  
        // Récupère le cours et vérifie qu'il existe
        $cours = $coursRepository->find($id);
        if (!$cours) {
            throw $this->createNotFoundException('Cours introuvable');
        }
    
        // Vérifie si le cours est dispensé cette semaine (paire, impaire ou toutes les semaines)
        $semaineActuelle = date('W') % 2 === 0 ? 'paire' : 'impaire';
        if ($cours->getSemaineType() !== 'toutes' && $cours->getSemaineType() !== $semaineActuelle) {
            $this->addFlash('error', 'Ce cours n\'est pas dispensé cette semaine.');
            return $this->redirectToRoute('home');
        }
    
        // Récupère la liste des élèves de la classe
        $eleves = $userRepository->findBy(['classe' => $cours->getClasse()]);
    
        // Date de l'appel (aujourd'hui)
        $dateAppel = new \DateTime();
    
        // Initialise la variable pour les présences
        $presences = [];
    
        // Si c'est une requête POST, enregistre les présences
        if ($request->isMethod('POST')) {
            foreach ($eleves as $eleve) {
                // Crée une nouvelle instance de présence pour chaque élève
                $presence = new Presence();
                $presence->setCours($cours);
                $presence->setEleve($eleve);
                $presence->setDate($dateAppel);
                $presence->setPresent($request->request->get('presence_' . $eleve->getId()) === 'on');
                $this->entityManager->persist($presence);
    
                // Stocke chaque présence pour la confirmation
                $presences[$eleve->getId()] = $presence->isPresent();
            }
    
            // Enregistre toutes les présences
            $this->entityManager->flush();
    
            $this->addFlash('success', 'Appel enregistré avec succès.');
            return $this->redirectToRoute('home');
        } else {
            // Si ce n'est pas une requête POST, initialise chaque présence par défaut comme absente
            foreach ($eleves as $eleve) {
                $presences[$eleve->getId()] = false;
            }
        }
    
        return $this->render('appel/faire_appel.html.twig', [
            'cours' => $cours,
            'eleves' => $eleves,
            'presences' => $presences, // Envoie les présences au template
            'dateAppel' => $dateAppel,
            'username' => $username,
            'role' => $roles,
        ]);
    }
    
}
