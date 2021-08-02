<?php

namespace App\Repositories\Common\LanguageGrade;

use App\Repositories\InterfaceRepository;

interface LanguageGradeRepository extends InterfaceRepository
{
    const GRADE_A1 = 'A1';
    const GRADE_A2 = 'A2';
    const GRADE_B1 = 'B1';
    const GRADE_B2 = 'B2';
    const GRADE_C1 = 'C1';
    const GRADE_C2 = 'C2';
    const GRADE_NATIVE = 'Native';

    public function getList();
}