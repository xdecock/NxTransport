<?php
namespace NxTransport\Protocol\ESMTP\Response;

class EnhancedHandler extends BasicHandler
{
    public $enhancedStatusCode=false;
    public function parseReply($connection) {
        $line = $this->parseLine($connection);
        // Do we have a reply ?
        if ($line === false) {
            throw new Exception('Got no reply or empty string');
        }
        // Do we have an enhanced status code ?
        if(!preg_match('/^([245])\\.([0-9]{1,3})\\.([0-9]{1,3}) /s', $line, $matches)) {
            throw new Exception('No enhanced status code altough advertised by the server');
        }
        // Parsing Status Code
        $esc=array((int)$matches[1], (int)$matches[2], (int)$matches[3]);
        if ($this->enhancedStatusCode === false) {
            // First Line, we store the status code
            $this->enhancedStatusCode = $esc;
            return $this->finishedParsing;
        }
        // Multiline, checking consistency
        if ($this->enhancedStatusCode[0] == $esc[0]
            && $this->enhancedStatusCode[1] == $esc[1]
            && $this->enhancedStatusCode[2] == $esc[2]) {
            return $this->finishedParsing;
        }
        throw new Exception('Status code is inconsistent, something probably went wrong');
    }
}