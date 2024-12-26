<?php

namespace App\Controller;

use App\Entity\Resume;
use App\Entity\ResumeStatus;
use App\Repository\ResumeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/cv', name: 'api_cv_')]
class ResumeController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private ResumeRepository $resumeRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        ResumeRepository $resumeRepository
    ) {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->resumeRepository = $resumeRepository;
    }

    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(): Response
    {
        $resumes = $this->resumeRepository->findAll();

        return $this->json(
            $resumes, 
            Response::HTTP_OK, 
            [], 
            ['groups' => ['resume:read']]
        );
    }

    #[Route('/add', name: 'add', methods: ['POST'])]
    public function add(Request $request): Response
    {
        $resume = $this->serializer
            ->deserialize($request->getContent(), Resume::class, 'json', [
                'groups' => ['resume:write'],
        ]);

        $errors = $this->validator->validate($resume);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($resume);
        $this->entityManager->flush();

        return $this->json(
            $resume, 
            Response::HTTP_CREATED, 
            [], 
            ['groups' => ['resume:read']]
        );
    }

    #[Route('/{id}/status/update', name:'update_status', methods: ['POST'])]
    public function updateStatus(Request $request, int $id): Response
    {
        $resume = $this->resumeRepository->find($id);

        if (!$resume) {
            return $this->json(['error' => 'Resume not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->json(['error' => 'Invalid Json.'], Response::HTTP_BAD_REQUEST);
        }
        if (!isset($data['status'])) {
            return $this->json(['error' => 'Status value not found.'], Response::HTTP_BAD_REQUEST);
        }

        $statusValue = $data['status'];
        if (in_array($statusValue, ['Новый', 'Назначено собеседование', 'Принят', 'Отказ'])) {
            $status = $this->entityManager
                ->getRepository(ResumeStatus::class)
                ->findOneBy(['value' => $statusValue]);
            if (!$status) {
                return $this->json(['error' => 'Status entity not found.'], Response::HTTP_NOT_FOUND);
            }
            $resume->setStatus($status);
            $this->entityManager->flush();
            return $this->json(
                $resume, 
                Response::HTTP_OK, 
                [], 
                ['groups' => ['resume:read']]
            );
        } else {
            return $this->json(['error' => 'Invalid status value.'], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['POST'])]
    public function edit(Request $request, int $id): Response
    {
        $resume = $this->resumeRepository->find($id);

        if (!$resume) {
            return $this->json(['error' => 'Resume not found'], Response::HTTP_NOT_FOUND);
        }

        $this->serializer
            ->deserialize($request->getContent(), Resume::class, 'json', [
                'groups' => ['resume:write'],
                AbstractNormalizer::OBJECT_TO_POPULATE => $resume,
        ]);

        $errors = $this->validator->validate($resume);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        return $this->json(
            $resume, 
            Response::HTTP_OK, 
            [], 
            ['groups' => ['resume:read']]
        );
    }

    #[Route('/{id}', name: 'get', methods: ['GET'])]
    public function get(int $id): Response
    {
        $resume = $this->resumeRepository->find($id);

        if (!$resume) {
            return $this->json(['error' => 'Resume not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json(
            $resume, 
            Response::HTTP_OK, 
            [], 
            ['groups' => ['resume:read']]
        );
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        $resume = $this->resumeRepository->find($id);

        if (!$resume) {
            return $this->json(['error' => 'Resume not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($resume);
        $this->entityManager->flush();

        return $this->json(
            ['message' => 'Resume deleted'], 
            Response::HTTP_OK, 
            [], 
            ['groups' => ['resume:read']]
        );
    }
}