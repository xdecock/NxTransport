<?php
/**
 * NxTransport ESMTP Protocol Handler
 * This Class Handles an ESMTP Dialog with the server
 * It's not responsible for establishing connection
 * It works in a simple state tracking non-blocking way
 *
 * Typical use is
 * $esmtp = new Esmtp;
 * $esmtp->handleKeyword('DSN', Keyword\DSN);
 * $esmtp->setConnection(new Connexion(''));
 * foreach ($recipients as $recipien) {
 *   $esmtp->send($swiftMessage, $recipient);
 * }
 *
 */
namespace NxTransport\Protocol;

class Esmtp
{

    public function __construct()
    {}

    public function HandleKeyword($keyword, $handler)
    {}

    public function setConnection($newConnection)
    {}

    public function send(\Swift_Message $message, $to)
    {}

    public function getState()
    {}

    public function reset()
    {}

    public function work()
    {}
}