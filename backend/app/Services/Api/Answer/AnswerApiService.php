<?php


namespace App\Services\Api\Answer;


use App\Entities\Answers;
use App\Entities\Question;
use App\Exceptions\BadRequestException;
use App\Repositories\Api\Answer\AnswerApiRepository;
use App\Repositories\Common\Answer\AnswerRepository;
use App\Services\AbstractService;
use App\Services\Response\Code;
use App\Services\Response\Status;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class AnswerApiService extends AbstractService
{
    protected Answers $entity;
    protected AnswerRepository $repository;
    protected AnswerApiRepository $answerApiRepository;
    protected EntityManager $em;

    /**
     * @param EntityManager $em
     * @param Answers $entity
     * @param AnswerRepository $repository
     * @param AnswerApiRepository $answerApiRepository
     */

    public function __construct(EntityManager $em, Answers $entity, AnswerRepository $repository, AnswerApiRepository $answerApiRepository)
    {
        parent::__construct($em);
        $this->entity = $entity;
        $this->repository = $repository;
        $this->answerApiRepository = $answerApiRepository;
    }


    /**
     * @param Question $question
     * @param $answers
     * @throws ORMException|ConnectionException|BadRequestException
     */
    public function setAnswer(Question $question, $answers)
    {
        try {
            foreach ($answers as $value) {
                if (array_key_exists('id', $value)) {
                    /** @var Answers $answer */
                    $answer = $this->em->getReference(Answers::class, $value['id']);
                    $answer->setTitle($value['answerTitle']);
                    $answer->setCorrect($value['correct']);
                    $this->answerApiRepository->update($answer);
                } else {
                    $answer = new Answers();
                    $answer->setQuestion($question);
                    $answer->setTitle($value['answerTitle']);
                    $answer->setCorrect($value['correct']);
                    $this->answerApiRepository->create($answer);
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
    public function deleteAnswer(int $id)
    {
        try{
            $this->em->getConnection()->beginTransaction();
            /** @var Answers $answer */
            $answer = $this->em->getReference(Answers::class, $id);
            $this->answerApiRepository->remove($answer);
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
