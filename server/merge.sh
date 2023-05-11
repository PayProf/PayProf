#!/bin/bash

# Make sure we are on the master branch
git checkout master

# Merge the server branch into the master branch
git merge server

# Create a new directory named "server" in the root of the repository
mkdir server

# Copy the contents of the server folder from the server branch into the newly created server directory
git checkout server -- server/*

# Add the new server directory to the master branch
git add server

# Commit the changes
git commit -m "$*"

git pull origin master

# Push the changes to the remote repository
git push origin master