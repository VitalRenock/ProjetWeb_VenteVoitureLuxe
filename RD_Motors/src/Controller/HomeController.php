<?php

namespace App\Controller;

use App\Entity\Order;
use App\Enum\PaymentType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name:'home.index')]
    public function index(EntityManagerInterface $manager): Response
    {
        $order = $manager->getRepository(Order::class)->find(1);


        return $this->render('home/index.html.twig', [
            'title' => 'marche stp 1',
            'testEnum' => strtolower(PaymentType::CASH->translateFR())
        ]);
    }
}
