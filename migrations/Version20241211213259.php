<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211213259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, nom_c VARCHAR(255) NOT NULL, duree_c INT NOT NULL, periode_c INT NOT NULL, description_c VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant_examen (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, examen_id INT NOT NULL, numero_etudiant VARCHAR(255) NOT NULL, note DOUBLE PRECISION DEFAULT NULL, INDEX IDX_4532E98FDDEAB1A3 (etudiant_id), INDEX IDX_4532E98F5C8659A (examen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE examen (id INT AUTO_INCREMENT NOT NULL, matiere_id INT NOT NULL, enseignant_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_514C8FECF46CD258 (matiere_id), INDEX IDX_514C8FECE455FCC0 (enseignant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, id_p INT NOT NULL, nom_p VARCHAR(255) NOT NULL, description_p VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, statuts VARCHAR(255) NOT NULL, pdfprojet VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ressource (id INT AUTO_INCREMENT NOT NULL, type_r VARCHAR(255) NOT NULL, nom_r VARCHAR(255) NOT NULL, file_r VARCHAR(255) NOT NULL, duree_r VARCHAR(255) DEFAULT NULL, pdfressource VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, projet_t_id INT DEFAULT NULL, id_t INT NOT NULL, nom_t VARCHAR(255) NOT NULL, description_t VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, status_t VARCHAR(255) NOT NULL, INDEX IDX_938720752BCB1BDA (projet_t_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etudiant_examen ADD CONSTRAINT FK_4532E98FDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE etudiant_examen ADD CONSTRAINT FK_4532E98F5C8659A FOREIGN KEY (examen_id) REFERENCES examen (id)');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT FK_514C8FECF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT FK_514C8FECE455FCC0 FOREIGN KEY (enseignant_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_938720752BCB1BDA FOREIGN KEY (projet_t_id) REFERENCES projet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant_examen DROP FOREIGN KEY FK_4532E98FDDEAB1A3');
        $this->addSql('ALTER TABLE etudiant_examen DROP FOREIGN KEY FK_4532E98F5C8659A');
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY FK_514C8FECF46CD258');
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY FK_514C8FECE455FCC0');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_938720752BCB1BDA');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE etudiant_examen');
        $this->addSql('DROP TABLE examen');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
