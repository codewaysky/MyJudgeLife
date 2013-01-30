#!/usr/bin/perl
use File::Basename;
use XML::Simple;
use Data::Dumper;


my $xmlfile = dirname($0) . "/codeinfo.xml";
if (-e $xmlfile)
{
    my $xml = XML::Simple->new();
    our $codeinfo = $xml->XMLin($xmlfile);
}
