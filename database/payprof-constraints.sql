ALTER TABLE etablissements
ALTER COLUMN "Nbrenseignants" SET DEFAULT 0;

-------------------

ALTER TABLE enseignants
ALTER COLUMN user_id DROP NOT NULL;

ALTER TABLE enseignants
ALTER COLUMN user_id DROP NOT NULL;

ALTER TABLE administrateurs
ALTER COLUMN user_id DROP NOT NULL;

-------------------

	   
ALTER TABLE interventions
ADD COLUMN paiement_id bigint;

ALTER TABLE interventions
ADD CONSTRAINT fk_constraint_paiement_id
FOREIGN KEY (paiement_id)
REFERENCES paiements (id);

ALTER TABLE interventions
ALTER COLUMN paiement_id DROP NOT NULL;