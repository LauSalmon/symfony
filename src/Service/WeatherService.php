<?php

 namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

 class WeatherService{

    private HttpClientInterface $client;
    private string $apikey;

    public function __construct($apikey, HttpClientInterface $client){
        $this->apikey = $apikey;
        $this->client = $client;
    }

    public function getWeather() : array {
        //Requete sur API
        $response = $this->client->request(
            'GET',
            'https://api.openweathermap.org/data/2.5/weather?lon=1.44&lat=43.6&appid=' . $this->apikey
        );
        //transforme la reponse en tableau
        $response = $response->toArray();
        //retoun le tableau
        return $response;
    }

    public function cityWeather(string $name) : array {

        try{
            //Requete sur API
            $response = $this->client->request(
                'GET',
                'https://api.openweathermap.org/data/2.5/weather?q='.$name.'&appid=' . $this->apikey,
            );
            //test si la ville n'existe pas
            if($response->getStatusCode()===404){
                //retourner une exception
                throw new \Exception ("La ville n'existe pas !"); 
            }
            //transforme la reponse en tableau
            $response = $response->toArray();
            //retoun le tableau
            return $response;

        } catch (\Throwable $th){
            return [
                "erreur" => $th->getMessage(), 
                "cod" => 404,
            ];
        }
    }
 }