<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210213095453 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE promo_id promo_id INT DEFAULT NULL, CHANGE github github VARCHAR(255) DEFAULT NULL, CHANGE cv cv VARCHAR(255) DEFAULT NULL, CHANGE mobile mobile INT DEFAULT NULL, CHANGE mobile_zone mobile_zone INT DEFAULT NULL, CHANGE situation situation INT DEFAULT NULL, CHANGE pseudo_github pseudo_github VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` CHANGE promo_id promo_id INT NOT NULL, CHANGE github github VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pseudo_github pseudo_github VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cv cv VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mobile mobile INT NOT NULL, CHANGE situation situation INT NOT NULL, CHANGE mobile_zone mobile_zone INT NOT NULL');
    }
}
