#!/usr/bin/perl
use File::Basename;
#$< = $>;
#print $!;
open FILE,">".dirname($0)."/running" or print("ERROR");
$req = dirname($0)."/judge_module.pl";
require $req;
$req = dirname($0)."/clean.pl";
#require $req;

unlink dirname($0)."/running";
