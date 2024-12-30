<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Repository\PageRepository;

/**
 * Description of PageService
 *
 * @author bgamrat
 */
class PageService {

    public function __construct(private PageRepository $pageRepository) {

    }

    public function home(): ?string {
        $page = $this->pageRepository->findOneBy(['name' => 'home']);
        if ($page === null) {
            throw new ResourceNotFoundException("home");
        }
        return $page->getContent();
    }

    public function pages(): ?array {
        return $this->pageRepository->findAll();
    }
}
