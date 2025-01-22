<?php

namespace OndrejBakan\ByteBuffer;

class ByteBuffer
{
    private $stream;
    private string $endianness;

    const LITTLE_ENDIAN = 'little';
    const BIG_ENDIAN = 'big';

    public function __construct($data, $endianness = SELF::LITTLE_ENDIAN)
    {
        $this->stream = fopen('php://memory', 'r+');
        $this->endianness = $endianness;

        if (!is_string($data))
            $data = strval($data);

        fwrite($this->stream, $data);
        rewind($this->stream);
    }

    public function limit(): int
    {
        return fstat($this->stream)['size'];
    }

    public function position(): int|false
    {
        return ftell($this->stream);
    }

    public function read(int $length = 1): string|false
    {
        return fread($this->stream, $length);
    }

    public function readUint16(): int|false
    {
        return $this->unpackData('v', 'n', $this->read(2));
    }

    public function readUint32(): int|false
    {
        return $this->unpackData('V', 'N', $this->read(4));
    }

    public function readUint64(): int|false
    {
        return $this->unpackData('P', 'J', $this->read(8));
    }

    public function seek(int $offset, int $whence = SEEK_SET)
    {
        fseek($this->stream, $offset, $whence);
    }

    public function skip(int $offset)
    {
        fseek($this->stream, $offset, SEEK_CUR);
    }

    private function unpackData($littleEndianFormat, $bigEndianFormat, $data): int|null
    {
        return unpack($this->endianness === self::LITTLE_ENDIAN ? $littleEndianFormat : $bigEndianFormat, $data)[1];
    }

}
