<?php

namespace App\Controller;

use App\Form\WeatherType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\WeatherService;

class WeatherController extends AbstractController
{
    private WeatherService $weatherService;
    

    public function __construct(WeatherService $weatherService){
        $this->weatherService = $weatherService;
    }

    #[Route('/weather', name: 'app_weather')]
    public function showWeather(): Response
    {
        $meteo = $this->weatherService->getWeather();
        //dd($meteo);
        return $this->render('weather/index.html.twig', [
            'meteo' => $meteo,
        ]);
    }

    #[Route('/weather/city', name: 'app_weather_city')]
    public function weather(Request $request) : Response {

        $meteo = [];
        $form = $this->createForm(WeatherType::class);
        $form->handleRequest($request);  

        if($form->isSubmitted()){
            $meteo = $this->weatherService->cityWeather($form->getData()["name"]);
 
        }

        return $this->render('weather/city.html.twig', [
            'form' => $form->createView(),
            'meteo' => $meteo ? $meteo : null,
            
        ]);
    }
}
