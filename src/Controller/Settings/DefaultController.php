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

use App\Configuration\InventoryConfiguration;
use App\Service\ConfigurationFormService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Yaml\Yaml;

class DefaultController extends AbstractController {

    public function __construct(private ConfigurationFormService $configurationFormService) {
        
    }

    #[Route('/settings/{type}', name: 'settings', requirements: ['type' => 'inventory|distribution'])]
    public function index(Request $request, string $type): Response {

        $yamlFilename = $this->getParameter('kernel.project_dir') . '/config/app/' . $type . '.yml';

        if (!is_file($yamlFilename)) {
            $this->createNotFoundException($yamlFilename);
        }

        $yaml = Yaml::parse(
                        \file_get_contents($yamlFilename)
        );
        $inventoryConfiguration = new InventoryConfiguration();

        $form = $this->configurationFormService->form($type, $inventoryConfiguration, $yaml);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = [$type => [$type => $form->getData()]];

            $configs = [$formData];
            $processor = new Processor();
            try {
                $processedConfiguration = $processor->processConfiguration(
                        $inventoryConfiguration, $configs
                );
                $updatedYaml = Yaml::dump($processedConfiguration);
                file_put_contents($yamlFilename, $updatedYaml);
                return $this->redirectToRoute('settings');
            } catch (InvalidTypeException |
                    InvalidConfigurationException $e) {
                $formError = new FormError($e->getMessage());
                $form->addError($formError);
            }
        }

        return $this->render('settings/index.html.twig', ['form' => $form]);
    }
}
