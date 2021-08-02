<?php

namespace App\Repositories\Api\Quiz;

use App\Entities\Quiz;
use App\Entities\User;
use App\Repositories\Api\Quiz\Filter\QuizApiFilter;
use App\Repositories\DoctrineRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class DoctrineQuizApiRepository extends DoctrineRepository implements QuizApiRepository
{
    /**
     * @param User $user
     * @param QuizApiFilter $filter
     * @return array|LengthAwarePaginator|int|string
     */
    public function findAllByWithPaginated(User $user, QuizApiFilter $filter)
    {
        $qb = $this->createQueryBuilder('quiz')
            ->select('quiz', 'question', 'answer', 'user')
            ->innerJoin('quiz.questions', 'question')
            ->innerJoin('question.answers', 'answer')
            ->innerJoin('quiz.teacher', 'user')
            ->where('quiz.teacher = :teacher')
            ->setParameters([
                'teacher' => $user
            ]);
        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param int $id
     * @param QuizApiFilter $filter
     * @return array|LengthAwarePaginator|int|string
     */
    public function findQuizById(int $id)
    {
        $qb = $this->createQueryBuilder('quiz')
            ->select('quiz', 'question', 'answer')
            ->innerJoin('quiz.questions', 'question')
            ->innerJoin('question.answers', 'answer')
            ->where('quiz.id = :id')
            ->setParameters([
                'id' => $id
            ]);
        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param User $user
     * @return array|LengthAwarePaginator|int|string
     */
    public function findAllByUserWithPaginated(User $user)
    {
        $qb = $this->createQueryBuilder('quiz')
            ->select('quiz', 'question', 'answer', 'teacher', 'request', 'user')
            ->innerJoin('quiz.teacher', 'teacher')
            ->innerjoin('teacher.requestTeacher', 'request')
            ->innerJoin('request.user', 'user')
            ->innerJoin('quiz.questions', 'question')
            ->innerJoin('question.answers', 'answer')
            ->where('user = :user')
            ->setParameters([
                'user' => $user
            ]);
        return $qb->getQuery()->getArrayResult();


    }
}
