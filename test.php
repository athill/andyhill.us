<?php
/*
$DOMXML = new DOMDocument();

$root = $DOMXML->createElement('root');
$DOMXML->appendChild($root);

$elt1 = $DOMXML->createElement('el1');
$root->appendChild($elt1);


$DOMXML2 = new DOMDocument();

$root2 = $DOMXML2->createElement('root');
$DOMXML2->appendChild($root2);

$elt3 = $DOMXML2->createElement('el1');
$root2->appendChild($elt1);

$elt3->appendChild($root);

echo $DOMDXML->saveXML();
*/

$orgdoc = new DOMDocument;
$orgdoc->loadXML("<root><element><child>text in child</child></element></root>");

// The node we want to import to a new document
$node = $orgdoc->getElementsByTagName("element")->item(0);


// Create a new document
$newdoc = new DOMDocument;
$newdoc->formatOutput = true;

// Add some markup
$newdoc->loadXML("<root><someelement>text in some element</someelement></root>");

echo "The 'new document' before copying nodes into it:\n";
echo $newdoc->saveXML();

// Import the node, and all its children, to the document
$node = $newdoc->importNode($node, true);
// And then append it to the "<root>" node
$newdoc->documentElement->appendChild($node);

echo "\nThe 'new document' after copying the nodes into it:\n";
echo $newdoc->saveXML();
?>
