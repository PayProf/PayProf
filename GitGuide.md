# Git Guide For This Project

Made By: **Reda Mountassir**
___

This is A guide For Payprof Project to make Git/github use easy for you
___

## If you Want to get your branch (cloning):

1-open the folder you wanna clone in

2-open git bash in it

3-type this:

```bash
git clone -b branch-name https://github.com/PayProf/PayProf.git
```

**NOTE 1 :** *only clone dev branch*

**NOTE 2 :** *if you want to modify the code add a branch with a understandable name and start pushing to it*

___

## How to add a branch:

To add a branch I made a ready scriptshell for it

1-make sure you're in the local directory 

2-open git bash in it

3-type this:

```bash
./mkbranch.sh branch-name
```

___

## How to push to a branch:

* One of the most important things is to put checkpoints!

* Thanks to the commit and push feature on git we can do that

* To do that you have to follow these steps:

1-open git bash in the folder you wanna push in

2-type this (Ready script shell):

```bash
  ./push.sh branch-name your commit message
```

* Only push to the branch you created!

___

## How to pull changes in a branch:

* **For example**: Imad made authentification and merged his branch dev branch , Youssef and Oussama need the updated dev branch on their local repository to do that follow these steps:

1-Make sure you're in the folder you wanna pull in

2-open git bash in it

3-Make sure you're in the branch you wanna pull in

4-type this:

```bash

git pull origin branch-name

```

for Youssef and Oussama branch-name is dev!

___


## If you wanna make a pull request to dev branch:

1-Go to github

2-Go to the repository

3-click on "Pull requests"

4-click on "New pull request"

5-choose the branch you wanna merge

* base : the branch you wanna merge to (dev)
* compare : the branch you wanna merge from (your branch)

6-click on "Create pull request" with a title and a description

7-Wait for the aproval of the pull request (merge)
___

## If you want to delete a branch:

It's very important to delete the branch after merging it to the dev branch

you can do that by following these steps and using the ready script shell for it:

1-open git bash in the folder you wanna delete the branch in

2-type this:

```bash
./rmbranch.sh branch-name
```

3-you're then redirected to the parent branch dev
___

## Important Rules to follow (Workflow):

* **Never** push to dev branch
* **Never** push to a branch you didn't create
* **Never** and **Never Ever** push to the master branch
* If you want to add something (Feature or bugfix), create a branch with a understandable name and push to it, then when you're done make a pull request to dev branch
* **Always** pull the dev branch after someone merges his branch to it
* 1 person and 1 person only should work on a branch
* **Always** put checkpoints (commit and push) when you finish a part of the work
* **Always** Comment your code , Uncommented or badly commented code will be refused on the pull request!
* Master Branch is the branch that contains the ready version of the project (that could be integrally tested)

___


## Testing

This part is for the testers of the project

if you want to test the project you have to follow these steps:

1-determine the purpose of the test (during dev or when a version is ready to be tested)

2-clone the branch you wanna test

3-create a branch for your tests (with a understandable name)

4-test the project

5-make an issue on github with the results of your tests

6-delete the branch you created for the tests when done

___





