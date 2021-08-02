<?php

namespace App\Repositories\Common\Language;

use App\Repositories\InterfaceRepository;

interface LanguageRepository extends InterfaceRepository
{
    const ENGLISH_NAME = 'English';
    const ENGLISH_CODE = 'en';

    const FRENCH_NAME = 'French';
    const FRENCH_CODE = 'fr';

    const RUSSIAN_NAME = 'Russian';
    const RUSSIAN_CODE = 'ru';

    const GERMAN_NAME = 'German';
    const GERMAN_CODE = 'de';

    public function getList();
}