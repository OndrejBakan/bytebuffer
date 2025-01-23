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
        $result = fread($this->stream, $length);
        if ($result === false) {
            throw new \RuntimeException("Failed to read from stream");
        }
        return $result;
    }

    public function readUint16(): int|null
    {
        return $this->unpackData('v', 'n', $this->read(2))[1];
    }

    public function readUint32(): int|null
    {
        return $this->unpackData('V', 'N', $this->read(4))[1];
    }

    public function readUint64(): string|null
    {
        $data = $this->unpackData('Vlow/Vhigh', 'Nlow/Nhigh', $this->read(8));

        $high = gmp_init($data['high']);
        $low = gmp_init($data['low']);

        $result = gmp_strval(gmp_add(gmp_mul($high, gmp_init("4294967296")), $low));
        return $result;
    }

    public function seek(int $offset, int $whence = SEEK_SET)
    {
        fseek($this->stream, $offset, $whence);
    }

    public function skip(int $offset)
    {
        fseek($this->stream, $offset, SEEK_CUR);
    }

    private function unpackData(string $littleEndianFormat, string $bigEndianFormat, $data): array|false
    {
        return unpack($this->endianness === self::LITTLE_ENDIAN ? $littleEndianFormat : $bigEndianFormat, $data);
    }

}
