<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220825155715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reference ADD pays VARCHAR(255) NOT NULL, ADD nom_client VARCHAR(255) NOT NULL, ADD contact_client VARCHAR(255) NOT NULL, ADD adresse_client VARCHAR(255) NOT NULL, ADD valeur_mission VARCHAR(255) NOT NULL, ADD services_rendus VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reference DROP pays, DROP nom_client, DROP contact_client, DROP adresse_client, DROP valeur_mission, DROP services_rendus');
    }
}
