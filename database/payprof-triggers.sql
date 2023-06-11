
---------------------------------------------------------------------------------------------------------------------------------
-- Trigger pour faire un UPDATE du nombre des enseignants dans un etablissement 

CREATE OR REPLACE FUNCTION update_nbr_enseignant()
    RETURNS TRIGGER
    LANGUAGE plpgsql
AS $$
BEGIN
    IF TG_OP = 'UPDATE' THEN
        IF (new.etablissement_id <> old.etablissement_id) THEN
            UPDATE etablissements SET "Nbrenseignants" = "Nbrenseignants" - 1 WHERE id = old.etablissement_id;
            UPDATE etablissements SET "Nbrenseignants" = "Nbrenseignants" + 1 WHERE id = new.etablissement_id;
        END IF;
    END IF;

    IF TG_OP = 'INSERT' THEN
        UPDATE etablissements SET "Nbrenseignants" = "Nbrenseignants" + 1 WHERE id = new.etablissement_id;
    END IF;

    IF TG_OP = 'DELETE' THEN
        UPDATE etablissements SET "Nbrenseignants" = "Nbrenseignants" - 1 WHERE id = old.etablissement_id;
    END IF;

    RETURN NEW;
END
$$;

CREATE TRIGGER update_nbr_enseignant
    AFTER INSERT OR UPDATE OR DELETE
    ON enseignants
    FOR EACH ROW
    EXECUTE PROCEDURE update_nbr_enseignant();

----------------------------------------------------------------------------------------------------------------------------------------
-- Trigger pour rejeter la modification ou la supression d'une intervention apres qu'il est accepte par Admin UAE   

CREATE OR REPLACE FUNCTION b_limit_interventions()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$

BEGIN
    IF OLD.visa_uae = true  THEN
       raise exception 'intervention deja aprouvé par Admin UAE';
    END IF;

    RETURN OLD;
END;
$BODY$;

CREATE TRIGGER b_limit_interventions
  BEFORE DELETE OR UPDATE 
   ON interventions 
   FOR EACH ROW
       EXECUTE PROCEDURE b_limit_interventions();

-----------------------------------------------------------------------------------------------------------------------------------
-- Trigger pour rejeter une insertion des interventions invalides

CREATE OR REPLACE FUNCTION c_limit_interventions()
    RETURNS TRIGGER
    LANGUAGE plpgsql
AS $$
DECLARE
    count_interventions INT;
BEGIN

    IF NEW."Nbr_heures" > 250 THEN
        RAISE EXCEPTION 'Le nombre d''heures est très élevé.';
    END IF;

    SELECT COUNT(id) INTO count_interventions
    FROM interventions AS I
    WHERE I.enseignant_id = NEW.enseignant_id
        AND (I.date_debut <= NEW.date_fin AND I.date_fin >= NEW.date_debut)
        AND I.visa_uae = TRUE
        AND I.visa_etab = TRUE;

    IF count_interventions = 5 THEN
        RAISE EXCEPTION 'Le professeur ne peut pas effectuer une intervention à ce moment.';
    END IF;

    RETURN NEW;
END
$$;

CREATE TRIGGER c_limit_interventions
    BEFORE INSERT OR UPDATE
    ON interventions
    FOR EACH ROW
    EXECUTE PROCEDURE c_limit_interventions();


-----------------------------------------------------------------------------------------------------------------------------------
-- Trigger pour rejeter une insertion des interventions invalides

CREATE OR REPLACE FUNCTION a_limit_interventions()
    RETURNS TRIGGER
    LANGUAGE plpgsql
AS $$
DECLARE
    annee1 INT;
    annee2 INT;
    semestre INT;
    AUXdate_debut DATE;
    AUXdate_S2 DATE;
    AUXdate_fin DATE;
BEGIN
    SELECT (string_to_array(NEW.annee_univ, '/'))[1] INTO annee1;   
    SELECT (string_to_array(NEW.annee_univ, '/'))[2] INTO annee2;

    IF annee2 = annee1 + 1 AND NEW.date_debut < NEW.date_fin THEN
        SELECT CAST(SUBSTRING(NEW.semestre FROM 2 FOR 2) AS INT) INTO semestre;

        AUXdate_debut := CAST(annee1 || '-09-01' AS DATE); -- debut anneee
        AUXdate_fin := CAST(annee2 || '-07-01' AS DATE);   -- fin annee
        AUXdate_S2 := CAST(annee2 || '-02-01' AS DATE);     -- fin semestre 1

        CASE semestre
            WHEN 1 THEN
                IF AUXdate_debut > NEW.date_debut OR NEW.date_fin > AUXdate_S2 THEN
                    RAISE EXCEPTION 'Les dates insérées sont incompatibles.';
                END IF;
            WHEN 2 THEN
                IF AUXdate_S2 > NEW.date_debut OR NEW.date_fin > AUXdate_fin THEN
                    RAISE EXCEPTION 'Les dates insérées sont incompatibles.';
                END IF;
            ELSE
                RAISE EXCEPTION 'Semestre invalide.';
        END CASE;
    ELSE
        RAISE EXCEPTION 'Donnée invalide.';
    END IF;

    RETURN NEW;
END
$$;

CREATE TRIGGER a_limit_interventions
    BEFORE INSERT OR UPDATE
    ON interventions
    FOR EACH ROW
    EXECUTE PROCEDURE a_limit_interventions();


  ----------------------------------------------------------------------------------------------------------------------------------------


CREATE OR REPLACE FUNCTION check_pay()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
DECLARE
    sum_VH INT;
    AUXCS INT := (grade_infos(new.enseignant_id))[1];
    H_Etab_origine INT;
    ET_ID BIGINT;
    
BEGIN
    IF NEW.visa_uae = true AND OLD.visa_etab = true  THEN

    SELECT etablissement_id INTO ET_ID FROM enseignants WHERE id = OLD.enseignant_id;

        IF OLD.etablissement_id = ET_ID THEN  --  dans etab origine 

            SELECT SUM("Nbr_heures") INTO H_Etab_origine FROM interventions WHERE enseignant_id = OLD.enseignant_id
                AND etablissement_id = ET_ID AND annee_univ = OLD.annee_univ
                AND visa_etab=true AND visa_uae=true  GROUP BY enseignant_id;
                
            if H_Etab_origine IS NULL then
            H_Etab_origine := 0;
            END if;

            -- IF H_Etab_origine < AUXCS THEN  
                 -- IF H_Etab_origine + NEW."Nbr_heures" <= AUXCS then 
                    -- no pay : so do nothing in table paiements 

            IF H_Etab_origine < AUXCS AND H_Etab_origine + OLD."Nbr_heures" > AUXCS  then -- this only happens once in each semester 
                call  pay(OLD.enseignant_id, OLD.etablissement_id, H_Etab_origine + OLD."Nbr_heures" - AUXCS, OLD.annee_univ, OLD.semestre);
            END IF ;

            IF  H_Etab_origine >= AUXCS then -- vacation dans son etab origine 
                  call  pay(OLD.enseignant_id, OLD.etablissement_id, OLD."Nbr_heures", OLD.annee_univ, OLD.semestre);
            END IF; 

        ELSE
           call  pay(OLD.enseignant_id, OLD.etablissement_id, OLD."Nbr_heures", OLD.annee_univ, OLD.semestre);
        END IF;
    END IF;

    RETURN NEW;
END;
$BODY$;



CREATE TRIGGER check_pay
  BEFORE UPDATE 
   ON interventions 
   FOR EACH ROW
       EXECUTE PROCEDURE check_pay();



  ----------------------------------------------------------------------------------------------------------------------------------------





 
