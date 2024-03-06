<?php

// src/Controller/CountryController.php

namespace App\Controller;

use App\Service\CountryInfoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{
    /**
     * @Route("/country", name="country_select")
     */
    public function select(): Response
    {
        // You can fetch a list of countries to populate the select input
        // For example, $countries = $this->getDoctrine()->getRepository(Country::class)->findAll();

        return $this->render('country/select.html.twig', [
            // Pass the list of countries to the template if needed
        ]);
    }

    /**
     * @Route("/country/{countryCode}", name="country_info")
     */
    public function index(CountryInfoService $countryService, string $countryCode): Response
    {
        $countryInfo = $countryService->getCountryInfo($countryCode);

        // Handle and display the country information as needed

        return $this->render('country/index.html.twig', [
            'countryInfo' => $countryInfo,
        ]);
    }

    /**
     * @Route("/country/info", name="country_info_submit", methods={"POST"})
     */
    public function getInfoByForm(Request $request, CountryInfoService $countryService): Response
    {
        $countryCode = $request->request->get('country_code');
        $countryInfo = $countryService->getCountryInfo($countryCode);

        // Handle and display the country information as needed

        return $this->render('country/index.html.twig', [
            'countryInfo' => $countryInfo,
        ]);
    }
}