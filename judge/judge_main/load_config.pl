#!/usr/bin/perl
use File::Basename;
use XML::Simple;
use Data::Dumper;


my $xmlfile = dirname($0) . "/config.xml";
if (-e $xmlfile)
{
    my $userxs = XML::Simple->new();
    our $userxml = $userxs->XMLin($xmlfile);
}
