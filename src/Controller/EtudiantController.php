<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Http\Message\ResponseInterface;


class EtudiantController extends AbstractController
{
    #[Route("/etudiants", name:"etudiant_index", methods:["GET"])]
    public function apiIndex(): JsonResponse
    {
        // Envoyer une requête GET au serveur JSON pour récupérer tous les étudiants
        $response = $this->sendJsonServerRequest('GET', 'http://localhost:3000/etudiants');
        return new JsonResponse($response->getBody()->getContents(), $response->getStatusCode());
    }

    #[Route("/etudiants/create", name:"etudiant_create", methods:["POST"])]
    public function apiCreate(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Valider les données reçues du client

        // Envoyer une requête POST au serveur JSON pour créer un nouvel étudiant
        $response = $this->sendJsonServerRequest('POST', 'http://localhost:3000/etudiants', $data);
        return new JsonResponse($response->getBody()->getContents(), $response->getStatusCode());
    }

    #[Route("/etudiants/show/{id}", name:"etudiant_show",methods:["GET"])]
    public function apiShow(int $id): JsonResponse
    {
        // Envoyer une requête GET au serveur JSON pour récupérer un étudiant spécifique par son ID
        $response = $this->sendJsonServerRequest('GET', 'http://localhost:3000/etudiants/' . $id);
        return new JsonResponse($response->getBody()->getContents(), $response->getStatusCode());
    }

    #[Route("/etudiants/edit/{id}", name:"etudiant_edit", methods:["PUT"])]
    public function apiEdit(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Valider les données reçues du client

        // Envoyer une requête PUT au serveur JSON pour mettre à jour un étudiant existant
        $response = $this->sendJsonServerRequest('PUT', 'http://localhost:3000/etudiants/' . $id, $data);
        return new JsonResponse($response->getBody()->getContents(), $response->getStatusCode());
    }

    #[Route("/etudiants/delete/{id}", name:"etudiant_delete", methods:["DELETE"])]
    public function apiDelete(int $id): JsonResponse
    {
        // Envoyer une requête DELETE au serveur JSON pour supprimer un étudiant par son ID
        $response = $this->sendJsonServerRequest('DELETE', 'http://localhost:3000/etudiants/' . $id);
        return new JsonResponse($response->getBody()->getContents(), $response->getStatusCode());
    }

    private function sendJsonServerRequest(string $method, string $url, array $data = null)
    {
        $client = new \GuzzleHttp\Client();
        $options = ['headers' => ['Content-Type' => 'application/json']];
        
        if ($data !== null) {
            $options['json'] = $data;
        }

        return $client->request($method, $url, $options);
    }
}
