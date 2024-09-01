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
use App\Service\InventoryConfigurationFormService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Yaml\Yaml;
use function dump;

class DefaultController extends AbstractController {

    public function __construct(private InventoryConfigurationFormService $configurationFormService) {
        
    }

    #[Route('/settings', name: 'settings')]
    public function index(Request $request): Response {

        $inventoryConfig = Yaml::parse(
                        \file_get_contents($this->getParameter('kernel.project_dir') . '/config/app/inventory.yml')
        );
        $inventoryConfiguration = new InventoryConfiguration();

        $form = $this->configurationFormService->form($inventoryConfiguration, $inventoryConfig);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formConfigValues = ['inventory' => ['inventory' => $form->getData()]];
            
            $processor = new Processor();
            $processedConfiguration = $processor->processConfiguration(
                    $inventoryConfiguration, $formConfigValues
            );
            $yaml = Yaml::dump($processedConfiguration);

            file_put_contents($this->getParameter('kernel.project_dir') . '/config/app/inventory.yml', $yaml);
            return $this->redirectToRoute('home');
        }

        return $this->render('settings/index.html.twig', ['form' => $form]);
    }
}
