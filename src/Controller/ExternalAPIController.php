<?php

namespace App\Controller;

use App\Form\ExternalAPIType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ExternalAPIController extends AbstractController
{
    #[Route('/external/a/p/i', name: 'app_external_a_p_i')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ExternalAPIType::class);
        $form->handleRequest($request);

        // --- POST: redirect (required by Turbo) ---
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            return $this->redirectToRoute('app_external_a_p_i', [
                'lat' => $data['latitude'],
                'lon' => $data['longitude'],
            ]);
        }

        // --- GET: handle weather fetch ---
        $lat = $request->query->get('lat');
        $lon = $request->query->get('lon');

        $weatherData = null;

        if ($lat !== null && $lon !== null) {
            $apiUrl = sprintf(
                'https://api.open-meteo.com/v1/forecast?latitude=%s&longitude=%s&daily=temperature_2m_max,temperature_2m_min,precipitation_sum&timezone=UTC',
                $lat,
                $lon
            );

            $response = file_get_contents($apiUrl);
            $weatherData = json_decode($response, true);
        }

        return $this->render('external_api/index.html.twig', [
            'form' => $form->createView(),
            'weather_data' => $weatherData,
        ]);
    }
}
