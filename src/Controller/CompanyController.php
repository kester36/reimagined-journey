<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Company;
use App\Model\Price;
use App\Service\GetHistoricalQuotes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\RuntimeException;

class CompanyController extends AbstractController
{
    #[Route('/company/{symbol}/quotes', name: 'company_quotes', methods: 'GET')]
    public function test(
        Company $company,
        Request $request,
        GetHistoricalQuotes $getHistoricalQuotes,
    ): Response {
        $startDate = new \DateTimeImmutable($request->query->get('startDate'));
        $endDate = new \DateTimeImmutable($request->query->get('endDate'));

        if ($startDate > $endDate) {
            throw new RuntimeException('Start Date can\'t be later than End Date');
        }

        /** @var Price[] */
        $quotes = $getHistoricalQuotes($company->getSymbol(), $startDate, $endDate);

        return $this->render('company-quotes.html.twig', [
            'company' => $company,
            'fromDate' => $startDate,
            'toDate' => $endDate,
            'quotes' => $quotes,
        ]);
    }
}
