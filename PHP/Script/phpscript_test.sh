#!/bin/bash

#http://php.net/manual/en/features.commandline.options.php

echo '# simple string arg'
./phpscript foo

echo '# simple string key=val arg'
./phpscript --foo=bar

echo '# key:val string arg'
./phpscript "foo":"bar"

echo '# {key:val} string arg'
./phpscript {"foo":"bar"}

echo '# comma separated string of key:val args'
./phpscript "foo1":"bar1","foo2":"bar2","foo3":"bar3"

echo '# space separated string of key:val args'
./phpscript "foo1":"bar1" "foo2":"bar2" "foo3":"bar3"

echo '# mock array keys'
./phpscript --config_file=1 --form_type='FormBase' --inputs[0]{'foo1:bar1','foo2:bar2'}  --inputs[1]{'foo1:bar3','foo2:bar4'}

echo '# simple string piped as argument'
php -r "print 'bar';" | ./phpscript --foo

echo '# variable piped as argument'
php -r '$foo = strtoupper("bar"); print $foo;' | ./phpscript 

echo '# simple array values passed via xargs as argument'
echo {'a','b','c','d'} | xargs ./phpscript

echo '# complex array values passed via xargs as argument'
echo {1:'a',2:'b',3='c',4='d'} | xargs ./phpscript

echo '# json encoded array piped to php script'
php -r 'print json_encode(array("foo1"=>"bar1","foo2"=>"bar2"));' | ./phpscript 