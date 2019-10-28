<form autocomplete="off" action="index.php?action=<?=bereinige($action) ?>" method="post">
    <div id="std-container">
        <div class="content" id="main">

            <div class="eintrag info">
                <div class="box left">
                    <h3><?= $ueberschrift ?></h3>
                </div>
            </div>

            <input type="hidden" name="id" value="<?= (int)$nachricht->getId() ?>" />

            <div class="eintrag">
                <label for="klientenwahl">Zuweisen an:</label>
                <select class="item" name="klientenwahl[]" id="klientenwahl" multiple>

                    <?php foreach ($nutzerliste as $nutzer) { ?>

                        <option value="<?= $nutzer->getId() ?>" <?php
                            $nachrichten = Nachricht::findXfromObject("Klient", $nutzer->getId(), "*");
                            $unique = true;
                            foreach ($nachrichten as $msg) {

                                if ((int)$msg->getId() == (int)$nachricht->getId()) {
                                    $unique = false;
                                }
                            }
                            if (!$unique) {
                                ?> selected <?php
                            }
                            ?> > <?=
                                $nutzer->getVorname() ." ". $nutzer->getName();
                                ?> </option>
                    <?php } ?>
                </select>
            </div>

            <div class="eintrag">
                <div class="box left">
                    <label for="text" class="item">Nachricht</label>
                    <input class="item" type="text" name="text" id="text" placeholder="Text" value="<?= bereinige($nachricht->getText()) ?>" />
                </div>
            </div>

            <div class="eintrag">
                <div class="box left">
                    <label for="wichtigkeit" class="item">Wichtigkeit</label>
                    <input class="item" type="number" name="wichtigkeit" id="wichtigkeit" placeholder="Wichtigkeit" value="<?= bereinige($nachricht->getWichtigkeit()) ?>" />
                </div>
            </div>

            <div class="eintrag">
                <div class="box left">
                <label for="start" class="item">Startdatum</label>
                <input class="item" type="date" id="start" name="datestart"
                       value="<?= $nachricht->getDatestart(); ?>"
                >
                </div>
            </div>
            <div class="eintrag">
                <div class="box left">
                <label for="end" class="item">Enddatum</label>
                <input class="item" type="date" id="end" name="dateend"
                       value="<?= $nachricht->getDateend(); ?>"
                >
                </div>
            </div>

            <div class="eintrag info">

                <div class="box left wdhbox">
                    <label for="checkDaily" class="item">Wiederholung</label>
                    <input type="radio" id="checkDaily" name="wiederholungsart" value="daily" <?php if ($nachricht->getWiederholungsart() == 1){ ?> checked <?php } ?> >Täglich
                    <input type="radio" id="checkWeekly" name="wiederholungsart" value="weekly" <?php if ($nachricht->getWiederholungsart() == 2){ ?> checked <?php } ?> >Wöchentlich
                    <!--<input type="radio" id="checkMonthly" name="wiederholungsart" value="monthly" <?php if ($nachricht->getWiederholungsart() == 3){ ?> checked <?php } ?> >Monatlich-->

                    <div class="weekdaysBoxes eintrag info noline">
                        <h3 class="item">Wiederholung:</h3>
                        <div>
                            <input type="checkbox" id="monday" name="monday" value="monday" <?php if ($nachricht->isMonday()){ ?> checked <?php } ?> >
                            <label for="monday">Montags</label>
                        </div>
                        <div>
                            <input type="checkbox" id="tuesday" name="tuesday" value="tuesday" <?php if ($nachricht->isTuesday()){ ?> checked <?php } ?> >
                            <label for="tuesday">Dienstags</label>
                        </div>
                        <div>
                            <input type="checkbox" id="wednesday" name="wednesday" value="wednesday" <?php if ($nachricht->isWednesday()){ ?> checked <?php } ?> >
                            <label for="wednesday">Mittwochs</label>
                        </div>
                        <div>
                            <input type="checkbox" id="thursday" name="thursday" value="thursday" <?php if ($nachricht->isThursday()){ ?> checked <?php } ?> >
                            <label for="thursday">Donnerstags</label>
                        </div>
                        <div>
                            <input type="checkbox" id="friday" name="friday" value="friday" <?php if ($nachricht->isFriday()){ ?> checked <?php } ?> >
                            <label for="friday">Freitags</label>
                        </div>
                        <div>
                            <input type="checkbox" id="saturday" name="saturday" value="saturday" <?php if ($nachricht->isSaturday()){ ?> checked <?php } ?> >
                            <label for="saturday">Samstags</label>
                        </div>
                        <div>
                            <input type="checkbox" id="sunday" name="sunday" value="sunday" <?php if ($nachricht->isSunday()){ ?> checked <?php } ?> >
                            <label for="sunday">Sonntags</label>
                        </div>
                    </div>

                    <div class="eintrag">
                        <div class="left">
                            <label for="wiederholungsrate" class="item">Wiederholungsrate</label>
                            <input class="item" type="number" name="wiederholungsrate" id="wiederholungsrate" placeholder="wiederholungsrate" value="<?= bereinige($nachricht->getWiederholungsrate()) ?>" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="box right">
                <input class="item left" type="submit" value="speichern">
            </div>

            <a id="my_popup_date" href="#" class="popup"></a>
            <div class="popup">
                <p>Anfangs- und Enddatum können nicht leer sein.</p>
                <a class="button close" href="#">Ok</a>
            </div>

            <a id="my_popup_text" href="#" class="popup"></a>
            <div class="popup">
                <p>Inhalt der Nachricht kann nicht leer sein.</p>
                <a class="button close" href="#">Ok</a>
            </div>
        </div>
    </div>
</form>