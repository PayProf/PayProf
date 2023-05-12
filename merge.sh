#!/bin/bash

# Make sure we are on the master branch
git checkout master

# Merge the dev branch into the master branch
git merge dev

# Push the changes to the remote repository
git push origin master