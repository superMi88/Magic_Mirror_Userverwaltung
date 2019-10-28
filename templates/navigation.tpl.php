
<div id="nav-container">

    <ul class="content" id="navi">
        <li><a <?php if ($action == 'index') { ?>id="active"<?php } ?> href="index.php">Startseite</a></li>

        <li><a <?php if ($action == 'userliste') { ?>id="active"<?php } ?> href="index.php?action=userliste">Betreuer</a></li>

        <li><a <?php if ($action == 'klientliste') { ?>id="active"<?php } ?> href="index.php?action=klientliste">Klienten</a></li>

        <li><a <?php if ($action == 'nachrichtenliste') { ?>id="active"<?php } ?> href="index.php?action=nachrichtenliste">Nachrichten</a></li>

        <li class="dropdown">

            <a class="profileBoxButton" href="index.php?action=logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>

        </li>

    </ul>
</div>