#!/bin/bash

if [[ $1 != "dev" && $1 != "master" ]]; then #if we are not in dev branch
  #rediriger vers client
  git checkout dev
  #supprimer la branche remotly
  git push origin --delete $1
  #supprimer la branche localement
  git branch -d $1
else
  echo "WARNING : You're trying to remove an integral branch"
fi
