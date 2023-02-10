<?php
$data = file_get_contents("php://input");
$event = json_decode($data);

//declare(strict_types=1);
include 'includes/class-autoload.inc.php';


if ($event->event == "messages.upsert") {

    $from = $event->data->messages[0]->key->{'fromMe'};

    if ($from == false) {

        $latitude = $event->data->messages[0]->message->{'locationMessage'}->degreesLatitude;
        $longitude = $event->data->messages[0]->message->{'locationMessage'}->degreesLongitude;
        $jid = $event->data->messages[0]->key->{'remoteJid'};
        $buttonId = $event->data->messages[0]->message->{'buttonsResponseMessage'}->selectedButtonId;
        $listId = $event->data->messages[0]->message->{'listResponseMessage'}->singleSelectReply->selectedRowId;
        $number = (int) filter_var($jid, FILTER_SANITIZE_NUMBER_INT);
        $conversation = $event->data->messages[0]->message->{'conversation'};
        $pushName = $event->data->messages[0]->pushName;


        //*registration
        include './includes/botquery.inc.php';
        //*
        include './includes/bloodquery.inc.php';
        include './includes/driverquery.inc.php';
        include './includes/businessquery.inc.php';
        include './includes/professionquery.inc.php';
        include './includes/earnwithtown.inc.php';
        //*//


        //*search
        include './includes/search.inc.php';

    }
}
?>