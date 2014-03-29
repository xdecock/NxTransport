<?php
namespace NxTransport\Protocol\ESMTP\Response;

use NxTransport\Connection;

class BasicHandler
{

    public $statusCode = 0;

    public $response = '';

    public $responseString = '';

    public $finishedParsing = false;

    public function __construct(array $expectedResponseCode)
    {}

    /**
     * Parse a reply, prepare the statusCode
     *
     * @param Connection $connection
     * @throws Exception
     * @return boolean finished
     */
    public function parseReply(Connection $connection)
    {
        $this->responseString .= $this->parseLine($connection);
        return $this->finishedParsing;
    }

    /**
     * Parse a reply and return
     *
     * @param Connection $line
     * @return string
     * @throws Exception
     */
    protected function parseLine(Connection $connection)
    {
        $line = $connection->readLine();
        $this->response .= $line;
        // Extract Status Code
        $status = substr($line, 0, 3);
        if (! is_numeric($status)) {
            throw new Exception('Invalid Reply, line not starting with a 3 char digit status code');
        }
        if ($this->statusCode == 0) {
            // First line of the reply
            $this->statusCode = ((int) $status);
        } elseif ($this->statusCode != $status) {
            // Next Lines
            throw new Exception('Invalid Multiline Reply, status code has changed between 2 lines');
        }
        if ($line[3] == ' ') {
            // Last Line of the response
            $finishedParsing = true;
        } elseif ($line[3] != '-') {
            // Invalid Separator
            throw new Exception('Separator is invalid - or <SP> expected, ' . $line[3] . ' received');
        }
        return substr($line, 4, - 2);
    }
}