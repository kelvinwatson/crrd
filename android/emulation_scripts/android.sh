#!/bin/sh
kill -9 `ps ax | grep node | grep meteor | awk '{print $1}'`
export ANDROID_HOME=/home/kwatson/Android/Sdk
export PATH=$PATH:$ANDROID_HOME/tools:$ANDROID_HOME/platform-tools
meteor run android --verbose
