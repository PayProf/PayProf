CREATE OR REPLACE PROCEDURE public.create_password(
	OUT mypassword character varying)
LANGUAGE 'plpgsql'
AS $BODY$
declare
  rand text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
  i integer := 0;
begin
	mypassword :='';
  for i in 1..8 loop
    mypassword := mypassword || rand[1+random()*(array_length(rand, 1)-1)];
  end loop;

end;
$BODY$;

------------------------------------------------------------------------------------------------------------------------------------------------

CREATE OR REPLACE PROCEDURE public.create_email(
	IN mynom character varying,
	IN myprenom character varying,
	OUT myemail character varying)
LANGUAGE 'plpgsql'
AS $BODY$
declare 
count_enseignants int :=0;
count_directeurs int :=0;
count_administrateurs int :=0;
final_count int:=0;

begin
 
 select count(id) from enseignants as E into count_enseignants where E.nom = mynom and E.prenom = myprenom;
 select count(id) from directeurs as D into count_directeurs where D.nom = mynom and D.prenom = myprenom;
 select count(id) from administrateurs as A into count_administrateurs where A.nom = mynom and A.prenom = myprenom;
 
 final_count := count_enseignants + count_directeurs + count_administrateurs;
 
 if final_count != 0 then 
 	myemail := myprenom ||'.'||mynom || final_count || '@domain.com';
 else 
 	myemail := myprenom ||'.'||mynom ||'@domain.com';
	
 end if;
end;
$BODY$;


------------------------------------------------------------------------------------------------------------------------------------------------

create or replace function grade_infos (IN enseignant_ID bigint  )   --- return charge statutaire et taux horaire d'un enseignant
returns int []
language plpgsql
as $$
declare
AUXresult int[];
AUX_CS int ;   -- charge statutaire
AUX_TH int ;   -- taux horaire 
AUXgrade int ;
begin
	
	select grade_id into AUXgrade from enseignants where id=enseignant_ID;
	
	select charge_statutaire into AUX_CS from grades where id=AUXgrade;
	AUXresult := AUXresult || AUX_CS;
	
	select "Taux_horaire_vacation" into AUX_TH from grades where id=AUXgrade;
	AUXresult := AUXresult || AUX_TH;
	
	return AUXresult;

end; $$   --- select (grade_infos(8))[1]


------------------------------------------------------------------------------------------------------------------------------------------------

create or replace function calcul_salaire (IN AUXVH int,IN AUXTH int )   -- calculer BRUT NET IR pour un enseignant 
returns int []
language plpgsql
as $$
declare
AUXresult int[];

begin
	

	AUXresult := AUXresult || AUXVH * AUXTH ;  -- BRUT 
	
	AUXresult := AUXresult || AUXVH * AUXTH * 0.38 ;  --IMPOT 
	
	AUXresult := AUXresult || AUXVH * AUXTH * ( 1 - 0.38 ) ; --NET 
	
	
	return AUXresult;

end; $$ 

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------


CREATE OR REPLACE PROCEDURE pay2 (
    IN auxenseignant_id BIGINT,
    IN auxetablissement_id BIGINT,
    IN aux_vh INT,
    IN aux_annee_univ CHARACTER VARYING(255),
    IN aux_semestre CHARACTER VARYING(255)
)
LANGUAGE plpgsql
AS $$
DECLARE
    sum_vh INT;
    tab INT[];
    auxth INT;
BEGIN
    auxth := (grade_infos(auxenseignant_id))[2];

    SELECT SUM("VH") INTO sum_vh FROM paiements WHERE enseignant_id = auxenseignant_id
        AND "Semestre" = aux_semestre AND "Annee_univ" = aux_annee_univ;

    IF sum_vh >= 100 THEN
        INSERT INTO paiements (enseignant_id, etablissement_id, "VH", "Taux_H", "Brut", "IR", "Net", "Annee_univ", "Semestre")
        VALUES (auxenseignant_id, auxetablissement_id, aux_vh, 0, 0, 0, 0, aux_annee_univ, aux_semestre);
    ELSE
        IF sum_vh + aux_vh > 100 THEN
		
            tab := calcul_salaire(100 - sum_vh, auxth);

            INSERT INTO paiements (enseignant_id, etablissement_id, "VH", "Taux_H", "Brut", "IR", "Net", "Annee_univ", "Semestre")
            VALUES (auxenseignant_id, auxetablissement_id, 100 - sum_vh, auxth, tab[1], tab[2], tab[3], aux_annee_univ, aux_semestre);

            INSERT INTO paiements (enseignant_id, etablissement_id, "VH", "Taux_H", "Brut", "IR", "Net", "Annee_univ", "Semestre")
            VALUES (auxenseignant_id, auxetablissement_id, sum_vh + aux_vh - 100, 0, 0, 0, 0, aux_annee_univ, aux_semestre);
        ELSE
            tab := calcul_salaire(aux_vh, auxth);

            INSERT INTO paiements (enseignant_id, etablissement_id, "VH", "Taux_H", "Brut", "IR", "Net", "Annee_univ", "Semestre")
            VALUES (auxenseignant_id, auxetablissement_id, aux_vh, auxth, tab[1], tab[2], tab[3], aux_annee_univ, aux_semestre);
        END IF;
    END IF;
END;
$$;


----------------------------------------------------------------------------------------------------------------------------------------------------------------------------




-- Must add a trigger after update using the pay2 function 
-- query optimisation 