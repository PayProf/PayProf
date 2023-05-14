#!/bin/bash

if[$1 -ne "dev" -a $1 -ne "master"] #Si notre Branch n'est pas la Branch client ou server
{
  #rediriger vers client
  git checkout dev
  #supprimer la branche remotly
  git push origin --delete $1
  #supprimer la branche localement
  git branch -d $1
}
else
{
  echo "WARNING : You're trying to remove an integral branch"
}

