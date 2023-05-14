#!/bin/bash

# Creating a new branch
git checkout -b $*

# Pushing the new branch to the remote repository
./push.sh dev Creating a new branch $*

echo "IMPORTANT : Check in github if the branch is created"


