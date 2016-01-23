#!/bin/sh

#navigate to project folder
meteor deploy crrd.meteor.com
meteor build ~/build-output-directory --server=crrd.meteor.com
#enter keystore passphrase
cd ~/build-output-directory/android/
jarsigner -verbose -sigalg SHA1withRSA -digestalg SHA1 release-unsigned.apk crrd
export ANDROID_HOME=/home/kwatson/Android/Sdk
$ANDROID_HOME/build-tools/23.0.2/zipalign 4 release-unsigned.apk production.apk

#if production.apk already exists, line 9 will fail, so delete production.apk, then re-run the following steps: 
#cd ~/build-output-directory/android/
#jarsigner -verbose -sigalg SHA1withRSA -digestalg SHA1 release-unsigned.apk crrd
#export ANDROID_HOME=/home/kwatson/Android/Sdk
#$ANDROID_HOME/build-tools/23.0.2/zipalign 4 release-unsigned.apk production.apk
