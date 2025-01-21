<?php

namespace OndrejBakan\ByteBuffer;

class ByteBuffer
{
    private $stream;
    private $orderLittleEndian = true;

    public function __construct($data)
    {
        $this->stream = fopen('php://memory', 'r+');

        fwrite($this->stream, $data);
        rewind($this->stream);
    }

    public function read($length)
    {
        return fread($this->stream, $length);
    }

    public function readUint16()
    {
        return unpack($this->orderLittleEndian ? 'v' : 'n', $this->read(16))[1];
    }

    public function readUint32()
    {
        return unpack($this->orderLittleEndian ? 'V' : 'N', $this->read(32))[1];
    }

    public function readUint64()
    {
        return unpack($this->orderLittleEndian ? 'P' : 'J', $this->read(64))[1];
    }

}
