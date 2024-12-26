<?php

namespace App\DataFixtures;

use App\Entity\EducationLevel;
use App\Entity\ResumeStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Статусы резюме
        $resumeStatuses = ['Новый', 'Назначено собеседование', 'Принят', 'Отказ'];
        foreach ($resumeStatuses as $resumeStatus) {
            $status = new ResumeStatus();
            $status->setValue($resumeStatus);
            $manager->persist($status);
        }

        // Уровни образования
        $eduLevels = ['Среднее', 'Среднее специальное', 'Высшее', 'Неоконченное высшее'];
        foreach ($eduLevels as $eduLevel) {
            $level = new EducationLevel();
            $level->setValue($eduLevel);
            $manager->persist($level);
        }

        $manager->flush();
    }
}
