<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240308175729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Retirando campo watched';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE episode DROP COLUMN watched;');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
