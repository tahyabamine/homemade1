<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220605175314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, contenue LONGTEXT DEFAULT NULL, date_de_publication DATETIME NOT NULL, prix DOUBLE PRECISION DEFAULT NULL, INDEX IDX_F65593E5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce_categorie (annonce_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_3C5A3DA68805AB2F (annonce_id), INDEX IDX_3C5A3DA6BCF5E72D (categorie_id), PRIMARY KEY(annonce_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, annonce_id INT DEFAULT NULL, img VARCHAR(255) NOT NULL, INDEX IDX_C53D045F8805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger (id INT AUTO_INCREMENT NOT NULL, envoyeur_id INT DEFAULT NULL, recepteur_id INT DEFAULT NULL, is_read TINYINT(1) DEFAULT NULL, contenue LONGTEXT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_E22A43014795A786 (envoyeur_id), INDEX IDX_E22A43013B49782D (recepteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rate (id INT AUTO_INCREMENT NOT NULL, user_voteur_id INT DEFAULT NULL, user_vote_id INT NOT NULL, etoile DOUBLE PRECISION NOT NULL, commentaire LONGTEXT DEFAULT NULL, date_de_publication DATE NOT NULL, INDEX IDX_DFEC3F394581E059 (user_voteur_id), INDEX IDX_DFEC3F392AD1C4F6 (user_vote_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, genre_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, code_postal INT NOT NULL, nom_rue VARCHAR(255) NOT NULL, numero_rue INT NOT NULL, complement_adresse LONGTEXT DEFAULT NULL, pseudo VARCHAR(255) NOT NULL, avatar LONGTEXT DEFAULT NULL, is_verified TINYINT(1) NOT NULL, ville VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64998260155 (region_id), INDEX IDX_8D93D6494296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_specialite (user_id INT NOT NULL, specialite_id INT NOT NULL, INDEX IDX_40B13A2DA76ED395 (user_id), INDEX IDX_40B13A2D2195E0F0 (specialite_id), PRIMARY KEY(user_id, specialite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_annonce (user_id INT NOT NULL, annonce_id INT NOT NULL, INDEX IDX_AE588DEFA76ED395 (user_id), INDEX IDX_AE588DEF8805AB2F (annonce_id), PRIMARY KEY(user_id, annonce_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE annonce_categorie ADD CONSTRAINT FK_3C5A3DA68805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_categorie ADD CONSTRAINT FK_3C5A3DA6BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE messenger ADD CONSTRAINT FK_E22A43014795A786 FOREIGN KEY (envoyeur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE messenger ADD CONSTRAINT FK_E22A43013B49782D FOREIGN KEY (recepteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F394581E059 FOREIGN KEY (user_voteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F392AD1C4F6 FOREIGN KEY (user_vote_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64998260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE user_specialite ADD CONSTRAINT FK_40B13A2DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_specialite ADD CONSTRAINT FK_40B13A2D2195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_annonce ADD CONSTRAINT FK_AE588DEFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_annonce ADD CONSTRAINT FK_AE588DEF8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce_categorie DROP FOREIGN KEY FK_3C5A3DA68805AB2F');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F8805AB2F');
        $this->addSql('ALTER TABLE user_annonce DROP FOREIGN KEY FK_AE588DEF8805AB2F');
        $this->addSql('ALTER TABLE annonce_categorie DROP FOREIGN KEY FK_3C5A3DA6BCF5E72D');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494296D31F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64998260155');
        $this->addSql('ALTER TABLE user_specialite DROP FOREIGN KEY FK_40B13A2D2195E0F0');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5A76ED395');
        $this->addSql('ALTER TABLE messenger DROP FOREIGN KEY FK_E22A43014795A786');
        $this->addSql('ALTER TABLE messenger DROP FOREIGN KEY FK_E22A43013B49782D');
        $this->addSql('ALTER TABLE rate DROP FOREIGN KEY FK_DFEC3F394581E059');
        $this->addSql('ALTER TABLE rate DROP FOREIGN KEY FK_DFEC3F392AD1C4F6');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user_specialite DROP FOREIGN KEY FK_40B13A2DA76ED395');
        $this->addSql('ALTER TABLE user_annonce DROP FOREIGN KEY FK_AE588DEFA76ED395');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE annonce_categorie');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE messenger');
        $this->addSql('DROP TABLE rate');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_specialite');
        $this->addSql('DROP TABLE user_annonce');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
