#!/bin/bash
#
#  Script to automatically pull website from github repo.
#  Works by pulling from the git repo to a local repo,
#  then using tar to replace the contents of a directory
#  to the document root
#
#  Jared Cantilina
#

echo "checking for branch change request"
BRANCHFILE=/var/local/switchBranch.txt
cd /home/pi/Pi-in-the-Sky/
if [ -e $BRANCHFILE ]
then
	echo "Branch change requested"
	git checkout $(cat $BRANCHFILE) && rm -f $BRANCHFILE
	exit 0 #since git checkout will call this script, we don't need to do the rest.
fi

echo "Pulling data from git"
git pull

echo "checking for changes in documentRoot"
DIFF=$(diff -r /home/pi/Pi-in-the-Sky/documentRoot/ /usr/local/apache/htdocs/)
if [ "$DIFF" == "" ]
then
	echo "no changes"

else
	echo "Tarring git/documentRoot"
	cd /home/pi/Pi-in-the-Sky/documentRoot/
	tar -cvf documentRoot.tar .

	echo "cleaning apache/htdocs"
	cd /usr/local/apache/htdocs/
	rm -rf *

	echo "Unpacking"
	mv /home/pi/Pi-in-the-Sky/documentRoot/documentRoot.tar ./
	tar -xvf documentRoot.tar

	echo "Copying .htaccess"
	cp ../htaccess/.htaccess ./

	echo "Cleaning up"
	rm documentRoot.tar
fi

echo "checking for changes in cgi-bin"
DIFF=$(diff -r /home/pi/Pi-in-the-Sky/cgi-bin/ /usr/local/apache/cgi-bin/)

echo $DIFF
if [ "$DIFF" == "" ]
then
	echo "no changes"
else
	echo "Tarring git/cgi-bin"
	cd /home/pi/Pi-in-the-Sky/cgi-bin/
	tar -cvf cgi-bin.tar .

	echo "cleaning apache/cgi-bin"
	cd /usr/local/apache/cgi-bin/
	rm -rf *

	echo "Unpacking"
	mv /home/pi/Pi-in-the-Sky/cgi-bin/cgi-bin.tar ./
	tar -xvf cgi-bin.tar

	echo "Cleaning up"
	rm cgi-bin.tar
fi

echo "done!"
