<?php


namespace App\Repositories\Api\Quiz;


use App\Entities\User;
use App\Repositories\Api\Quiz\Filter\QuizApiFilter;
use App\Repositories\Common\Quiz\QuizRepository;

interface QuizApiRepository extends QuizRepository
{
    public function findAllByWithPaginated(User $user, QuizApiFilter $filter);

    public function findQuizById(int $id);

    public function findAllByUserWithPaginated(User $user);
}
