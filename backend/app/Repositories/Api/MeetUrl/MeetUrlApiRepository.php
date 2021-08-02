<?php


namespace App\Repositories\Api\MeetUrl;

use App\Repositories\Common\MeetUrl\MeetUrlRepository;

interface MeetUrlApiRepository extends MeetUrlRepository
{
    public function findMeetUrlByLessonId(int $id);
}
