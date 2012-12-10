#!/usr/bin/perl

open(COUNT, "<counter.dat");
$count = <COUNT>;
close(COUNT);

print "Content-type: text/html\n\n";

print "<html><head></head><body bgcolor=black text=white>";

print "<h3 align=center>You are visitor number: $count since 8/8/02</h3>";

print "</body></html>"
