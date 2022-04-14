<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414090707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger (id INT AUTO_INCREMENT NOT NULL, envoyeur_id INT DEFAULT NULL, recepteur_id INT DEFAULT NULL, is_read TINYINT(1) DEFAULT NULL, contenue LONGTEXT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_E22A43014795A786 (envoyeur_id), INDEX IDX_E22A43013B49782D (recepteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_annonce (user_id INT NOT NULL, annonce_id INT NOT NULL, INDEX IDX_AE588DEFA76ED395 (user_id), INDEX IDX_AE588DEF8805AB2F (annonce_id), PRIMARY KEY(user_id, annonce_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE messenger ADD CONSTRAINT FK_E22A43014795A786 FOREIGN KEY (envoyeur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE messenger ADD CONSTRAINT FK_E22A43013B49782D FOREIGN KEY (recepteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_annonce ADD CONSTRAINT FK_AE588DEFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_annonce ADD CONSTRAINT FK_AE588DEF8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger');
        $this->addSql('DROP TABLE user_annonce');
    }
}
