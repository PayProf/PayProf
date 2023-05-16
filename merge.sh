#!/bin/bash

# Make sure we are on the master branch
git checkout $1

# Merge the dev branch into the master branch
git merge $2

# Push the changes to the remote repository
git push origin $1