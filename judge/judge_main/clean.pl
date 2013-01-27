#!/usr/bin/perl

use File::Basename;

unlink dirname($0)."/codeinfo.xml";
unlink dirname($0)."/judge_code.pas";
unlink dirname($0)."/judge_code.c";
unlink dirname($0)."/judge_code.cpp";
unlink dirname($0)."/judge_code";
unlink dirname($0)."/error.txt";

return true;