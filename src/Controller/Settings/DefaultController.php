<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Settings;

use App\Service\ConfigurationFormService;
use App\Service\ConfigurationService;
use App\Service\LanguageFormService;
use App\Service\LanguageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Exception\InvalidConfigurationException;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\Exception\InvalidTypeException;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController {

    public function __construct(
            private ConfigurationService $configurationService,
            private ConfigurationFormService $configurationFormService,
            private LanguageService $languageService,
            private LanguageFormService $languageFormService) {
        
    }

    #[Route('/settings/{type}', name: 'settings', requirements: ['type' => 'inventory|distribution'])]
    public function index(Request $request, string $type): Response {

        $configuration = $this->configurationService->getConfiguration($type);
        $yaml = $this->configurationService->getYamlConfiguration($type);
        $form = $this->configurationFormService->form($type, $configuration, $yaml);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = [$type => $form->getData()];
            $updatedConfigurationData = [$formData];
            try {
                $this->configurationService->updateYamlConfiguration($type, $configuration, $updatedConfigurationData);
                return $this->redirectToRoute('settings', ['type' => $type]);
            } catch (InvalidTypeException |
                    InvalidConfigurationException $e) {
                $formError = new FormError($e->getMessage());
                $form->addError($formError);
            }
        }

        return $this->render('settings/index.html.twig', ['form' => $form]);
    }

    #[Route('/language/{language}/{type}', name: 'language', requirements: ['language' => '[a-z]{2}', 'type' => 'messages',])]
    public function language(Request $request, string $language = 'en', string $type = 'messages'): Response {
        $languageText = $this->languageService->getLanguage($language, $type);
        $form = $this->languageFormService->form($type, $languageText);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $updatedLanguageText = $form->getData();
            $this->languageService->updateLanguage($language, $type, $updatedLanguageText);
            return $this->redirectToRoute('language', ['type' => $type, 'language' => $language]);
        }

        return $this->render('settings/language.html.twig', ['form' => $form, 'type' => $type, 'language' => $language]);
    }
}
