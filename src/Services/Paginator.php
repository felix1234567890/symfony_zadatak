<?php


namespace App\Services;

use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

class Paginator
{
  public $pagerfanta;

  public function __construct($queryBuilder, $currentPage, $perPage)
  {
      $this->pagerfanta = new Pagerfanta(new QueryAdapter($queryBuilder));
      $this->pagerfanta->setMaxPerPage($perPage);
      $this->pagerfanta->setCurrentPage($currentPage);
  }
}