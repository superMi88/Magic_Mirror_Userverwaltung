<div class="content">

    <?php

    if($klientliste == NULL){
        ?> Sie haben keine zugewiesenen Klienten <?php
    }


    foreach ($klientliste as $id => $klient):
        if (!empty($nachrichtenliste[$klient->getId()])) {
        ?>
        <div class="eintrag buch"
            <?php if($ersterEintrag == true) {?>
                id="ersterEintrag"
                <?php
                $ersterEintrag = false;
            } ?>
        >
            <div class="eintrag">
                <div class="eintrag">
                    <a class="item left strong" href="index.php?action=zeigeKlient&id=<?= (int)$klient->getId() ?>">
                        <?= bereinige($klient->getName()) ?>
                    </a>
                    <a class="item left strong" href="index.php?action=zeigeKlient&id=<?= (int)$klient->getId() ?>">
                        <?= bereinige($klient->getVorname()) ?>
                    </a>
                </div>

                <?php
                foreach ($nachrichtenliste[$klient->getId()] as $nid => $nachricht){
                ?>

                    <div class="eintrag">
                        <a class="item textRight nachricht" href="index.php?action=zeigeNachricht&id=<?= (int)$nachricht->getId() ?>">
                            <span class="left"><?= bereinige($nachricht->getText()) ?></span>
                            <span class="textRight"><?= bereinige($nachricht->getNextDate()) ?></span>
                        </a>
                    </div>

                <?php
                }
                ?>
            </div>

        </div>
    <?php } endforeach; ?>

</div>



