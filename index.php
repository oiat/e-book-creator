<?php include("includes/session.php"); ?>
<?php include_once("templates/header.php"); ?>
<div id="banner-wrapper">
	<div id="banner">
        <div>
            <h1>E-Books einfach erstellen!</h1>
            <a href="#"><div class="rahmen-gross">
                <div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div>
                <div class="rahmen-content"><img src="img/logobild.png" width="422" height="237" alt="E-Book-Creator" /></div>
            </div></a>
        </div>
        <div>
            <p>E-Books einfach erstellen! Mit dem E-Book-Creator ist das möglich:<br>
Registrieren - Inhalte eingeben - fertig. <br>
<br>
            </p>
            <ul>
                <li>Keine Installation erforderlich</li>
                <li>Intuitiv und leicht zu bedienen</li>
                <li>Unterstützung aller gängigen E-Book-Formate</li>
                <li>Einfache Veröffentlichung</li>
                <li>Kostenfrei</li>
            </ul>
        </div>
    </div>
</div>
<div id="content">
    <div class="rahmen-reihe">
        <a href="/ebooks.php"><div class="rahmen">
                <div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div>
                <div class="rahmen-content"><p>E-Book-Katalog</p></div>
            </div></a>
            <a href="/ebook.php?id=57"><div class="rahmen">
                <div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div>
                <div class="rahmen-content"><p>Anleitung E-Book-Creator</p></div>
            </div></a>
            <a href="/login.php"><div class="rahmen" style="margin-right: 0;">
                <div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div>
                <div class="rahmen-content"><p>E-Book erstellen</p></div>
            </div></a>
    </div>
    <div id="icon-reihe">
    <span>Texte</span><span>Bilder</span><span>Videos/Sounds</span><span>Tests/Quizzes</span>
    </div>
</div>
<?php include_once("templates/footer.php"); ?>
</body>
</html>
