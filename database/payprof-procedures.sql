-- Active: 1683941185561@@127.0.0.1@5432@postgres

------------------------------------------------------------------------------------------------------------------------------------------------

-- Procedure pour tirer les informations du grade d'un enseignants donné

CREATE OR REPLACE FUNCTION grade_infos(IN enseignant_ID BIGINT)
RETURNS INT[]
LANGUAGE plpgsql
AS $$
DECLARE
    AUXresult INT[];
    AUX_CS INT;  -- charge statutaire
    AUX_TH INT;  -- taux horaire
BEGIN

   SELECT g.charge_statutaire, g."Taux_horaire_vacation"
    INTO AUX_CS, AUX_TH
    FROM enseignants e
    JOIN grades g ON e.grade_id = g.id
    WHERE e.id = enseignant_ID;

    AUXresult := ARRAY[AUX_CS, AUX_TH];
    
    -- Return the result array
    RETURN AUXresult;
END;
$$;

------------------------------------------------------------------------------------------------------------------------------------------------

-- Procedure pour calculer le salaire en fonction du volume horaire et du taux horaire d'un enseignant 

CREATE OR REPLACE FUNCTION calcul_salaire(IN AUXVH INT, IN AUXTH INT)
RETURNS INT[]
LANGUAGE plpgsql
AS $$
DECLARE
    AUXresult INT[];
BEGIN
    -- Calculate BRUT
    AUXresult := AUXresult || AUXVH * AUXTH;

    -- Calculate IMPOT
    AUXresult := AUXresult || AUXVH * AUXTH * 0.38;

    -- Calculate NET
    AUXresult := AUXresult || AUXVH * AUXTH * (1 - 0.38);

    -- Return the result array
    RETURN AUXresult;
END;
$$;


--------------------------------------------------------------------------------------------------------------------------------------------------------------------------


-- Procedure pour valider l'insertion des paiements

CREATE OR REPLACE PROCEDURE pay (
	IN auxenseignant_id bigint,
	IN auxetablissement_id bigint,
	IN aux_vh integer,
	IN aux_annee_univ character varying,
	IN aux_semestre character varying)
LANGUAGE 'plpgsql'
AS $BODY$
DECLARE
    sum_vh INT;
    tab INT[];
    auxth INT;
BEGIN
    auxth := (grade_infos(auxenseignant_id))[2];

    SELECT SUM("VH") INTO sum_vh FROM paiements WHERE enseignant_id = auxenseignant_id
        AND "Semestre" = aux_semestre AND "Annee_univ" = aux_annee_univ;
    
            if sum_vh IS NULL then
            sum_vh := 0;
            END if;

    IF sum_vh >= 100 THEN
        INSERT INTO paiements (enseignant_id, etablissement_id, "VH", "Taux_H", "Brut", "IR", "Net", "Annee_univ", "Semestre")
        VALUES (auxenseignant_id, auxetablissement_id, aux_vh, 0, 0, 0, 0, aux_annee_univ, aux_semestre)
        ON CONFLICT ON CONSTRAINT unique_paiement
        DO UPDATE SET "VH" = paiements."VH" + aux_vh;
    ELSE  -- sum_vh < 100

        IF sum_vh + aux_vh > 100 THEN -- happens one time 
            tab := calcul_salaire(100 - sum_vh, auxth);
        ELSE  -- sum_vh + aux_vh <= 100
            tab := calcul_salaire(aux_vh, auxth);
        END IF;    
            INSERT INTO paiements (enseignant_id, etablissement_id, "VH", "Taux_H", "Brut", "IR", "Net", "Annee_univ", "Semestre")
            VALUES (auxenseignant_id, auxetablissement_id, aux_vh, auxth, tab[1], tab[2], tab[3], aux_annee_univ, aux_semestre)
            ON CONFLICT ON CONSTRAINT unique_paiement
            DO UPDATE SET "VH" = paiements."VH" + aux_vh, "Brut" = paiements."Brut" + tab[1], "IR" = paiements."IR" + tab[2], "Net" = paiements."Net" + tab[3];
        
    END IF;

END;
$BODY$;

