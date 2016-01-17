#!/bin/sh

export ANDROID_HOME=/home/kwatson/Android/Sdk
export PATH=$PATH:$ANDROID_HOME/tools:$ANDROID_HOME/platform-tools
meteor run android --verbose
