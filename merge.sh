#!/bin/bash

# Make sure we are on the master branch
git checkout master

# Merge the client branch into the master branch
git merge client

# Create a new directory named "client" in the root of the repository
mkdir client

# Copy the contents of the client folder from the client branch into the newly created client directory
git checkout client -- client/*

# Add the new client directory to the master branch
git add client

# Commit the changes
git commit -m "$*"

git pull origin master

# Push the changes to the remote repository
git push origin master