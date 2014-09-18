<?php
// /opt/rh/php54/root/usr/bin/php --version


// WEB
system('php book publish easybook-doc-en website', $retval);
// http://ebook.communautic.com/easybook/doc/easybook-doc-en/Output/website/book

// EPUB
//system('php book publish easybook-doc-en ebook', $retval);
// http://ebook.communautic.com/easybook/doc/easybook-doc-en/Output/ebook/book.epub

// MOBI
//system('php book publish easybook-doc-en kindle', $retval);
// http://ebook.communautic.com/easybook/doc/easybook-doc-en/Output/kindle/book.mobi

// PDF
//system('php book publish das-guni-buch print', $retval);
// http://ebook.communautic.com/easybook/doc/easybook-doc-en/Output/print/book.pdf

echo $retval;
?>