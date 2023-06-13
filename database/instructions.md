

**Made by** Maftouhi Bilal


# Etapes à suivre 

  * Faire la migration des tables .
  
  * Executer  :
  
  ```sql
    ALTER TABLE paiements  
    ADD CONSTRAINT unique_paiement UNIQUE (enseignant_id,etablissement_id, "Annee_univ","Semestre");


    CREATE INDEX index_interventions
    ON interventions (enseignant_id,etablissement_id)
    WHERE visa_uae = true
    AND visa_etab = true ;

    CREATE INDEX index_enseignants
    ON enseignants (id,etablissement_id);
    

  ```
  
  *  Executer les procedures dans le fichier payprof-procedures.sql une par une.
  
  *  Executer les triggers dans le fichier payprof-triggers.sql un par un.
  
### Fin

