CREATE OR REPLACE FUNCTION public.create_user()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
declare

newemail varchar(255);	
newpassword varchar(255);	
lastid int;
newnom varchar(255);
newprenom varchar(255);
newrole int;
tablename varchar(20);
begin
	tablename := TG_TABLE_NAME;
	newnom :=new.nom;
	newprenom :=new.prenom;
	call create_email(newnom,newprenom,newemail);  -- Creation d'un email unique  
	call create_password(newpassword);				-- Generation d'un password de 8 characters aleatoires 
	
	CASE tablename									-- determination des roles 
   WHEN 'enseignants' THEN  newrole:=0;
   WHEN 'directeurs' THEN   newrole:=1;
   WHEN 'administrateurs' THEN newrole:=3;
	END case;

	select max(id) from users into lastid;		 -- Stockage de la valuer du dernier id
	lastid:=lastid+1;

	
	insert into users (id,email,password,role) values ( lastid ,newemail,newpassword,newrole);
	new.user_id := lastid;
	
	return new;
end 
$BODY$;


CREATE TRIGGER CREATE_USER   -- bind the trigger function to a table
   BEFORE INSERT
   ON enseignants --/directeurs/administrateurs
   FOR EACH ROW 
       EXECUTE PROCEDURE create_user()

----------------------------------------------------------------------------------------------------------------------------------

CREATE FUNCTION decrement_enseignant()   ---- decrementer le nombre d'enseignats dans l'etablissement  apres la suppression d'un enseignant
   RETURNS TRIGGER 
   LANGUAGE PLPGSQL
AS $$
BEGIN
  UPDATE etablissements SET "Nbrenseignants" = "Nbrenseignants"-1 where id=old.etablissement_id;
  return new;
END $$;


CREATE TRIGGER decrement_enseignant   -- bind the trigger function to a table
   AFTER DELETE
   ON enseignants
   FOR EACH ROW
       EXECUTE PROCEDURE decrement_enseignant()

 ----------------------------------------------------------------------------------------------------------------------------------
	   CREATE FUNCTION increment_enseignant()   ---- incrementer le nombre d'enseignats dans l'etablissement apres un ajout d'un enseignant
   RETURNS TRIGGER 
   LANGUAGE PLPGSQL
AS $$
BEGIN
  UPDATE etablissements SET "Nbrenseignants" += 1 where id=new.etablissement_id;
  return new;
END $$;


CREATE TRIGGER increment_enseignant   -- bind the trigger function to a table
   AFTER INSERT
   ON enseignants
   FOR EACH ROW
       EXECUTE PROCEDURE increment_enseignant()

---------------------------------------------------------------------------------------------------------------------------------
create or replace function update_etab_enseignant ()
returns trigger 
LANGUAGE 'plpgsql'
as $$

begin
		if (new.etablissement_id != old.etablissement_id ) then
		 UPDATE etablissements SET "Nbrenseignants" -= 1 where id=old.etablissement_id;
		 UPDATE etablissements SET "Nbrenseignants" += 1 where id=new.etablissement_id;
		 end if;

     return new;
end $$;


CREATE TRIGGER update_etab_enseignant   -- bind the trigger function to a table
   after update
   ON enseignants
   FOR EACH ROW 
       EXECUTE PROCEDURE update_etab_enseignant ()

-----------------------------------------------------------------------------------------------------------------------------------
create or replace function b_limit_interventions ()
returns trigger 
LANGUAGE 'plpgsql'
as $$
declare 
count_interventions int ;     

begin

-- CREATE INDEX Allinterventions        			            -- optimisation 
-- ON interventions(enseignant_id,date_debut,date_fin);

      if NEW."Nbr_heures" > 250 then 
        raise exception 'Nbre d''Nbr_heures tres grands ';
        end if;

		select count(id) into count_interventions from interventions as I 
			where I.enseignant_id = new.enseignant_id 
			and (I.date_debut <= NEW.date_fin AND I.date_fin >= NEW.date_debut)
			and I.visa_uae = TRUE 
			and I.visa_etab = TRUE ;

		if count_interventions = 5 then
				raise exception 'Le prof ne peut pas effectuer une intervention à ce moment ';
		 end if;

     return new;
end $$;

CREATE TRIGGER b_limit_interventions   -- bind the trigger function to a table
   before insert or update 
   ON interventions
   FOR EACH ROW 
       EXECUTE PROCEDURE b_limit_interventions ()

 

-----------------------------------------------------------------------------------------------------------------------------------
create or replace function a_limit_interventions ()
returns trigger 
LANGUAGE 'plpgsql'
as $$
declare 

annee1 int ;     
annee2 int ; 
semestre int;

AUXdate_debut date;
AUXdate_S2 date;
AUXdate_fin date;

begin

		
		
		SELECT (string_to_array(NEW.annee_univ, '/'))[1] into annee1;
		SELECT (string_to_array(NEW.annee_univ, '/'))[2] into annee2;
		
  if annee1 = annee2 + 1  and NEW.date_debut < NEW.date_fin then 

		SELECT CAST (SUBSTRING(NEW.semestre FROM 2 FOR 1) AS int ) into semestre;
		
		AUXdate_debut := cast (annee1||'-09-01' as date );
		AUXdate_fin := cast (annee2||'-07-01' as date );
		AUXdate_S2 :=  cast (annee2||'-02-01' as date );
		

		    case semestre
			when 1 then 
			if AUXdate_debut > NEW.date_debut OR NEW.date_fin > AUXdate_S2 then   -- Eviter l'insertion des dates illogiques
				raise exception 'Les dates insérées sont imcompatibles';
			end if;
			
			when 2 then
			if AUXdate_S2 > NEW.date_debut OR NEW.date_fin > AUXdate_fin then   -- Eviter l'insertion des dates illogiques
				raise exception 'Les dates insérées sont imcompatibles';
			end if;
			
			else raise exception 'Semestre Invalide';
			
		    end case ;

      else raise exception 'Donnée Invalide';  
    end if ;
     return new;
end $$;

CREATE TRIGGER a_limit_interventions -- bind the trigger function to a table
   before insert or update 
   ON interventions
   FOR EACH ROW 
       EXECUTE PROCEDURE a_limit_interventions ()

  ----------------------------------------------------------------------------------------------------------------------------------------

	CREATE OR REPLACE FUNCTION create_usr_id ()    --- Youssef demand
    RETURNS trigger
    LANGUAGE 'plpgsql'
	AS $$
declare 
custom_id int;
BEGIN
	select max(id) into custom_id  from users 
	new.user_id = custom_id  + 1;
  return new;
END ;
$$;

	
CREATE TRIGGER create_usr_id 
  AFTER INSERT
   ON enseignants --/ directeurs / administrateurs 
   FOR EACH ROW
       EXECUTE PROCEDURE create_usr_id ();

----------------------------------------------------------------------------------------------------------------------------------------


CREATE OR REPLACE FUNCTION delete_paiement ()    
    RETURNS trigger
    LANGUAGE 'plpgsql'
	AS $$
declare 

BEGIN
	begin									
	delete from paiements where id=OLD.paiement_id;
	commit;
	end;
	
  return old;
END ;
$$;

	
CREATE TRIGGER delete_paiement 
  AFTER DELETE
   ON interventions 
   FOR EACH ROW
       EXECUTE PROCEDURE delete_paiement ();

----------------------------------------------------------------------------------------------------------------------------------------



CREATE OR REPLACE FUNCTION pay1()
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
    IF NEW.visa_uae = TRUE AND NEW.visa_etab = TRUE THEN
        SELECT etablissement_id INTO ET_ID FROM enseignants WHERE id = NEW.enseignant_id;

        IF NEW.etablissement_id = ET_ID THEN  -- skip inserting charge statutaire et inserer juste vacations dans paiement
            SELECT SUM("Nbr_heures") INTO H_Etab_origine FROM interventions WHERE enseignant_id = NEW.enseignant_id
                AND etablissement_id = ET_ID AND annee_univ = NEW.annee_univ GROUP BY enseignant_id;

            IF H_Etab_origine > AUXCS THEN  -- purement les vacations
               call pay2(NEW.enseignant_id, NEW.etablissement_id, NEW."Nbr_heures", NEW.annee_univ, NEW.semestre);
            ELSE
                IF H_Etab_origine + NEW."Nbr_heures" > AUXCS THEN  -- eliminer la charge + vacation
                  call  pay2(NEW.enseignant_id, NEW.etablissement_id, H_Etab_origine + NEW."Nbr_heures" - AUXCS, NEW.annee_univ, NEW.semestre);
                END IF;
            END IF;  -- no else: no insertion if < charge
        ELSE
           call  pay2(NEW.enseignant_id, NEW.etablissement_id, NEW."Nbr_heures", NEW.annee_univ, NEW.semestre);
        END IF;
    END IF;

    RETURN NEW;
END;
$BODY$;


----------------------------------------------------------------------------------------------------------------------------------------