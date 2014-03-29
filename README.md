NxTransport
===========

NxTransport, an alternative ESMTP transport layer, depending on swiftmailer to compose the mime content

This aims to implement an event based transport layer, the implementation is not the purpose of this library, it's goal is to mess with implementation, and still keep swiftmailer for the mail composition.

Swiftmailer ESMTP Plugins will still be supported with added benefits of DSN, SIZE=, PIPELINING