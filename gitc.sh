#!/bin/bash
#set -x
cwd=$(pwd | awk -F/ '{print $NF}')
#如果第二个参数指定了要提交的库名，则覆盖目录名
if [ -n "$2" ];then
    cwd=$2
fi
echo $1
echo $cwd
if [ "$1" = 'google' ];then
    giturl=https://code.google.com/p/$cwd/
elif [ "$1" = 'github' ];then 
    giturl=git@github.com:huanle0610/$cwd.git
elif [ "$1" = 'moodle' ];then 
    giturl=git@moodle:$cwd.git
fi
echo $giturl
git remote rm origin 
git remote add origin $giturl
git remote -v
