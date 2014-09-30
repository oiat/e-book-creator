E-Book-Creator
==============

Der [E-Book-Creator](http://e-book-creator.at) ist ein Projekt des [ÖIAT](http://www.oiat.at/) in Kooperation mit [communautic](http://www.communautic.com/) gefördert durch die [netidee](http://www.netidee.at/).

Der E-Book-Creator wurde 2013/2014 entwickelt, mit dem Ziel, eine webbasierte Anwendung zur einfachen Erstellung von E-Books kostenfrei zur Verfügung zu stellen.

Für die Inhalte der mit dem E-Book-Creator veröffentlichten E-Books sind die jeweiligen Autor/innen verantwortlich.

Der E-Book-Creator steht als OpenSource-Anwendung (GNU General Public License (GPL) 3.0) unter https://github.com/oiat/e-book-creator zum Download zur Verfügung.


Verwendete Software/Bibliotheken
--------------------------------

easybook: http://easybook-project.org  
PrinceXML: http://www.princexml.com  
Amazon KindleGen: http://amzn.to/kindlegen  
HTML_To_Markdown: https://github.com/nickcernis/html2markdown

jQuery: http://jquery.com  
jQuery UI: http://jqueryui.com  
jQuery Form Plugin: http://malsup.com/jquery/form  
jQuery Impromptu: http://trentrichardson.com/Impromptu  
jQuery throttle / debounce: http://benalman.com/projects/jquery-throttle-debounce-plugin  
Valum's AJAX File-Uploader: http://valums-file-uploader.github.io/file-uploader  
TinyMCE: http://www.tinymce.com

Font Awesome: http://fortawesome.github.io/Font-Awesome

php: http://php.net  
MySQL: http://www.mysql.com


Installation
--------------------------------

Der Server bzw. die Hostingumgebung muss folgendes unterstützen:  
1) mit php muss das exec('php') Komando ausführbar sein

2) Zur PDF-Erstellung muss am Server PrinceXML installiert sein
(siehe http://easybook-project.org/documentation/chapter-8/requirements-2.html)

3) Zur modi-Erstellung muss am Server Amazon KindleGen installiert sein
(siehe http://easybook-project.org/documentation/chapter-7/requirements.html)


e-book-creator Code downloaden und auf den Server spielen.

Das Mysql schema unter includes/ebook.sql in der datenbank erstellen

includes/config.php anpassen
