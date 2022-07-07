<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class CompanySymbol
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    public function __construct(
        #[ORM\Column(type: 'string', length: 255)]
        private string $companyName,
        #[ORM\Column(type: 'string', length: 1)]
        private string $financialStatus,
        #[ORM\Column(type: 'string', length: 1)]
        private string $marketCategory,
        #[ORM\Column(type: 'integer')]
        private int $roundLotSize,
        #[ORM\Column(type: 'string', length: 255)]
        private string $securityName,
        #[ORM\Column(type: 'string', length: 4, unique: true)]
        private string $symbol,
        #[ORM\Column(type: 'string', length: 1)]
        private string $testIssue,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getFinancialStatus(): string
    {
        return $this->financialStatus;
    }

    public function getMarketCategory(): string
    {
        return $this->marketCategory;
    }

    public function getRoundLotSize(): int
    {
        return $this->roundLotSize;
    }

    public function getSecurityName(): string
    {
        return $this->securityName;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getTestIssue(): string
    {
        return $this->testIssue;
    }
}
