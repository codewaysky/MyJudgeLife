#!/usr/bin/perl
use File::Basename;

open FILE,">".dirname($0)."/running" or print("ERROR");

for(;;) {}

unlink dirname($0)."/running";
