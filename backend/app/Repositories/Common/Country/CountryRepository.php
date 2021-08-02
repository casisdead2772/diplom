<?php

namespace App\Repositories\Common\Country;

use App\Repositories\InterfaceRepository;

interface CountryRepository extends InterfaceRepository
{
    const ENGLISH = 1;
    const FRENCH = 2;
    const RUSSIAN = 3;
    const GERMANY = 4;

    const NAME_ENGLISH = 'England';
    const NAME_FRENCH = 'France';
    const NAME_RUSSIAN = 'Russia';
    const NAME_GERMANY = 'Germany';

    const CODE_ENGLISH = 'en';
    const CODE_FRENCH = 'fr';
    const CODE_RUSSIAN = 'ru';
    const CODE_GERMANY = 'de';

    public function getList();
}
