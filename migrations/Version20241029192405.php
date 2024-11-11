<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241029192405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY cours_ibfk_1');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY cours_ibfk_2');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY cours_ibfk_3');
        $this->addSql('ALTER TABLE cours CHANGE classe_id classe_id INT DEFAULT NULL, CHANGE matiere_id matiere_id INT DEFAULT NULL, CHANGE annee_scolaire_id annee_scolaire_id INT DEFAULT NULL, CHANGE jour_semaine jour_semaine VARCHAR(20) NOT NULL, CHANGE repetition repetition TINYINT(1) NOT NULL, CHANGE semaine_type semaine_type VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C9331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id)');
        $this->addSql('ALTER TABLE cours RENAME INDEX classe_id TO IDX_FDCA8C9C8F5EA509');
        $this->addSql('ALTER TABLE cours RENAME INDEX matiere_id TO IDX_FDCA8C9CF46CD258');
        $this->addSql('ALTER TABLE cours RENAME INDEX annee_scolaire_id TO IDX_FDCA8C9C9331C741');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY presence_ibfk_1');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY presence_ibfk_2');
        $this->addSql('ALTER TABLE presence CHANGE cours_id cours_id INT DEFAULT NULL, CHANGE eleve_id eleve_id INT DEFAULT NULL, CHANGE present present TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A57ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE presence RENAME INDEX cours_id TO IDX_6977C7A57ECF78B0');
        $this->addSql('ALTER TABLE presence RENAME INDEX eleve_id TO IDX_6977C7A5A6CC7B2');
        $this->addSql('ALTER TABLE user DROP classe_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` ADD classe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C8F5EA509');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CF46CD258');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C9331C741');
        $this->addSql('ALTER TABLE cours CHANGE classe_id classe_id INT NOT NULL, CHANGE matiere_id matiere_id INT NOT NULL, CHANGE annee_scolaire_id annee_scolaire_id INT NOT NULL, CHANGE jour_semaine jour_semaine VARCHAR(255) NOT NULL, CHANGE repetition repetition TINYINT(1) DEFAULT 1, CHANGE semaine_type semaine_type VARCHAR(255) DEFAULT \'toutes\'');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT cours_ibfk_1 FOREIGN KEY (classe_id) REFERENCES classe (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT cours_ibfk_2 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT cours_ibfk_3 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours RENAME INDEX idx_fdca8c9c8f5ea509 TO classe_id');
        $this->addSql('ALTER TABLE cours RENAME INDEX idx_fdca8c9cf46cd258 TO matiere_id');
        $this->addSql('ALTER TABLE cours RENAME INDEX idx_fdca8c9c9331c741 TO annee_scolaire_id');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A57ECF78B0');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5A6CC7B2');
        $this->addSql('ALTER TABLE presence CHANGE cours_id cours_id INT NOT NULL, CHANGE eleve_id eleve_id INT NOT NULL, CHANGE present present TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT presence_ibfk_1 FOREIGN KEY (cours_id) REFERENCES cours (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT presence_ibfk_2 FOREIGN KEY (eleve_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE presence RENAME INDEX idx_6977c7a57ecf78b0 TO cours_id');
        $this->addSql('ALTER TABLE presence RENAME INDEX idx_6977c7a5a6cc7b2 TO eleve_id');
    }
}
