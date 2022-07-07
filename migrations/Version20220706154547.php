<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220706154547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE company (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, company_name VARCHAR(255) NOT NULL, financial_status VARCHAR(1) NOT NULL, market_category VARCHAR(1) NOT NULL, round_lot_size INTEGER NOT NULL, security_name VARCHAR(255) NOT NULL, symbol VARCHAR(4) NOT NULL, test_issue VARCHAR(1) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094FECC836F9 ON company (symbol)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP INDEX UNIQ_4FBF094FECC836F9');
    }
}
