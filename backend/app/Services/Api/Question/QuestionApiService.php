<?php


namespace App\Services\Api\Question;


use App\Entities\Question;
use App\Entities\Quiz;
use App\Exceptions\BadRequestException;
use App\Repositories\Api\Question\QuestionApiRepository;
use App\Repositories\Common\Question\QuestionRepository;
use App\Services\AbstractService;
use App\Services\Api\Answer\AnswerApiService;
use App\Services\Response\Code;
use App\Services\Response\Status;
use Doctrine\ORM\EntityManager;

class QuestionApiService extends AbstractService
{
    protected AnswerApiService $answerApiService;
    protected Question $entity;
    protected QuestionRepository $repository;
    protected QuestionApiRepository $questionApiRepository;
    protected EntityManager $em;

    /**
     * @param EntityManager $em
     * @param Question $entity
     * @param QuestionRepository $repository
     * @param QuestionApiRepository $questionApiRepository
     * @param AnswerApiService $answerApiService
     */

    public function __construct(EntityManager $em, Question $entity, AnswerApiService $answerApiService, QuestionRepository $repository, QuestionApiRepository $questionApiRepository)
    {
        parent::__construct($em);
        $this->entity = $entity;
        $this->repository = $repository;
        $this->questionApiRepository = $questionApiRepository;
        $this->answerApiService = $answerApiService;
    }

    /**
     * @param Quiz $quiz
     * @param $questions
     */
    public function setQuestion(Quiz $quiz, $questions)
    {
        try {
            foreach ($questions as $value) {
                if (array_key_exists('id', $value)) {
                    /** @var Question $question */
                    $question = $this->em->getReference(Question::class, $value['id']);
                    $question->setTitle($value['title']);
                    $question->setType($value['type']);
                    $answers = $value['answers'];
                    $this->answerApiService->setAnswer($question, $answers);
                    $this->questionApiRepository->update($question);
                } else {
                    $question = new Question();
                    $question->setQuiz($quiz);
                    $question->setTitle($value['title']);
                    $question->setType($value['type']);
                    $answers = $value['answers'];
                    $this->answerApiService->setAnswer($question, $answers);
                    $this->questionApiRepository->create($question);
                }
            }
        } catch (\Throwable $e) {
            $this->em->getConnection()->rollBack();
            throw new BadRequestException([Status::FAILURE => $e->getMessage()], $e->getMessage(), Code::UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteQuestion(int $id)
    {
        try{
            $this->em->getConnection()->beginTransaction();
            /** @var Question $question */
            $question = $this->em->getReference(Question::class, $id);
            $this->questionApiRepository->remove($question);
            $this->em->getConnection()->commit();
            return true;
        }
        catch
        (\Throwable $e) {
            $this->em->getConnection()->rollBack();
            throw new BadRequestException([Status::FAILURE => $e->getMessage()], $e->getMessage(), Code::UNPROCESSABLE_ENTITY);
        }
    }
}
