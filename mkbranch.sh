#!/bin/bash

# Creating a new branch
git -b checkout $*

# Pushing the new branch to the remote repository
./push.sh Creating a new branch $*

echo "IMPORTANT : Check in github if the branch is created"


