<?php

namespace App\Services\Common\Country;

use App\Repositories\Common\Country\CountryRepository;
use App\Services\AbstractService;
use Doctrine\ORM\EntityManager;

class CountryService extends AbstractService
{
    private CountryRepository $countryRepository;

    /**
     * CountryService constructor.
     * @param EntityManager $em
     * @param CountryRepository $countryRepository
     */
    public function __construct(EntityManager $em, CountryRepository $countryRepository)
    {
        parent::__construct($em);
        $this->countryRepository = $countryRepository;
    }

    /**
     * @return mixed
     */
    public function getCountriesItems()
    {
        return $this->countryRepository->getList();
    }
}