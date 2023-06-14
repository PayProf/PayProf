-- Active: 1683941185561@@127.0.0.1@5432@postgres
------------------------------------------------------------------------------------------------------------------------------------------------
 -- Ce code ne sera pas utiliser dans notre project Payprof au raison de sécurité
------------------------------------------------------------------------------------------------------------------------------------------------
--  Procedure pour creer un mot de passe 

CREATE OR REPLACE PROCEDURE create_password(
    OUT mypassword CHARACTER VARYING
)
LANGUAGE plpgsql
AS $BODY$
DECLARE
    rand TEXT[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    i INTEGER := 0;
BEGIN
    mypassword := '';
    FOR i IN 1..8 LOOP
        mypassword := mypassword || rand[1+random()*(array_length(rand, 1)-1)];
    END LOOP;
END;
$BODY$;


------------------------------------------------------------------------------------------------------------------------------------------------

--  Procedure pour creer un email

CREATE OR REPLACE PROCEDURE create_email(
    IN mynom CHARACTER VARYING,
    IN myprenom CHARACTER VARYING,
    OUT myemail CHARACTER VARYING
)
LANGUAGE plpgsql
AS $BODY$
DECLARE
    count_enseignants INT := 0;
    count_directeurs INT := 0;
    count_administrateurs INT := 0;
    final_count INT := 0;
BEGIN
    CREATE INDEX idx_enseignants_email ON enseignants(nom,prenom);
    -- Count records in enseignants table with matching nom and prenom
    SELECT COUNT(id) INTO count_enseignants FROM enseignants AS E WHERE E.nom = mynom AND E.prenom = myprenom;

    CREATE INDEX idx_directeurs_email ON directeurs(nom,prenom);
    -- Count records in directeurs table with matching nom and prenom
    SELECT COUNT(id) INTO count_directeurs FROM directeurs AS D WHERE D.nom = mynom AND D.prenom = myprenom;

    CREATE INDEX idx_administrateurs_email ON administrateurs(nom,prenom);
    -- Count records in administrateurs table with matching nom and prenom
    SELECT COUNT(id) INTO count_administrateurs FROM administrateurs AS A WHERE A.nom = mynom AND A.prenom = myprenom;

    -- Calculate the final count
    final_count := count_enseignants + count_directeurs + count_administrateurs;

    -- Generate the email address based on the final count
    IF final_count != 0 THEN
        myemail := myprenom || '.' || mynom || final_count || '@ac.uae.ma';
    ELSE
        myemail := myprenom || '.' || mynom || '@ac.uae.ma';
    END IF;
END;
$BODY$;


------------------------------------------------------------------------------------------------------------------------------------------------

-- Trigger pour creer un utilisateur dans la table users après l'insertion d'une personne dans les tables enseignants ou directeurs ou administrateurs

CREATE OR REPLACE FUNCTION create_user()  
    RETURNS TRIGGER
    LANGUAGE plpgsql
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
DECLARE
    newemail VARCHAR(255);
    newpassword VARCHAR(255);
    lastid INT;
    newnom VARCHAR(255);
    newprenom VARCHAR(255);
    newrole INT;
    tablename VARCHAR(20);
BEGIN
    tablename := TG_TABLE_NAME;
    newnom := NEW.nom;
    newprenom := NEW.prenom;
    CALL create_email(newnom, newprenom, newemail);  -- Creation of a unique email
    CALL create_password(newpassword);              -- Generation of an 8-character random password

    CASE tablename                                 -- Determination of roles
        WHEN 'enseignants' THEN
            newrole := 0;
        WHEN 'directeurs' THEN
            newrole := 1;
        WHEN 'administrateurs' THEN
            newrole := 3;
    END CASE;

    SELECT MAX(id) FROM users INTO lastid;         -- Storage of the value of the last id
    lastid := lastid + 1;

    INSERT INTO users (id, email, password, role) VALUES (lastid, newemail, newpassword, newrole);
    NEW.user_id := lastid;

    RETURN NEW;
END
$BODY$;

CREATE TRIGGER create_user
    BEFORE INSERT
    ON enseignants
    FOR EACH ROW
    EXECUTE PROCEDURE create_user();


------------------------------------------------------------------------------------------------------------------------------------------------