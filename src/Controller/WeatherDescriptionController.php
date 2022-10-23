<?php

namespace App\Controller;

use App\Entity\WeatherDescription;
use App\Form\WeatherDescriptionType;
use App\Repository\WeatherDescriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherDescriptionController extends AbstractController
{
    public function index(WeatherDescriptionRepository $weatherDescriptionRepository): Response
    {
        return $this->render('weather_description/index.html.twig', [
            'weather_descriptions' => $weatherDescriptionRepository->findAll(),
        ]);
    }

    public function new(Request $request, WeatherDescriptionRepository $weatherDescriptionRepository): Response
    {
        $weatherDescription = new WeatherDescription();
        $form = $this->createForm(WeatherDescriptionType::class, $weatherDescription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $weatherDescriptionRepository->save($weatherDescription, true);

            return $this->redirectToRoute('app_weather_description_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('weather_description/new.html.twig', [
            'weather_description' => $weatherDescription,
            'form' => $form,
        ]);
    }

    public function show(WeatherDescription $weatherDescription): Response
    {
        return $this->render('weather_description/show.html.twig', [
            'weather_description' => $weatherDescription,
        ]);
    }

    public function edit(Request $request, WeatherDescription $weatherDescription, WeatherDescriptionRepository $weatherDescriptionRepository): Response
    {
        $form = $this->createForm(WeatherDescriptionType::class, $weatherDescription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $weatherDescriptionRepository->save($weatherDescription, true);

            return $this->redirectToRoute('app_weather_description_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('weather_description/edit.html.twig', [
            'weather_description' => $weatherDescription,
            'form' => $form,
        ]);
    }

    public function delete(Request $request, WeatherDescription $weatherDescription, WeatherDescriptionRepository $weatherDescriptionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$weatherDescription->getId(), $request->request->get('_token'))) {
            $weatherDescriptionRepository->remove($weatherDescription, true);
        }

        return $this->redirectToRoute('app_weather_description_index', [], Response::HTTP_SEE_OTHER);
    }
}
