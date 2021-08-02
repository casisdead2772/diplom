<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity
 * @ORM\Table(uniqueConstraints={
 *        @UniqueConstraint(
 *            columns={"teacher_information_id", "language_id", "language_grade_id"})
 *    })
 */
class TeacherInformationLanguageGrade extends BaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="TeacherInformation")
     * @ORM\JoinColumn(name="teacher_information_id", referencedColumnName="id", onDelete="NO ACTION")
     */
    private TeacherInformation $teacherInformation;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id", onDelete="NO ACTION")
     */
    private Language $language;

    /**
     * @ORM\ManyToOne(targetEntity="LanguageGrade")
     * @ORM\JoinColumn(name="language_grade_id", referencedColumnName="id", onDelete="NO ACTION")
     */
    private LanguageGrade $languageGrade;

    /**
     * @return TeacherInformation
     */
    public function getTeacherInformation(): TeacherInformation
    {
        return $this->teacherInformation;
    }

    /**
     * @param TeacherInformation $teacherInformation
     */
    public function setTeacherInformation(TeacherInformation $teacherInformation): void
    {
        $this->teacherInformation = $teacherInformation;
    }

    /**
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }

    /**
     * @param Language $language
     */
    public function setLanguage(Language $language): void
    {
        $this->language = $language;
    }

    /**
     * @return LanguageGrade
     */
    public function getLanguageGrade(): LanguageGrade
    {
        return $this->languageGrade;
    }

    /**
     * @param LanguageGrade $languageGrade
     */
    public function setLanguageGrade(LanguageGrade $languageGrade): void
    {
        $this->languageGrade = $languageGrade;
    }
}