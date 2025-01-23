<?php

use PHPUnit\Framework\TestCase;

class ByteBufferTest extends TestCase
{

    public function testReadInt16()
    {
        $data = pack('s', 65535);
        $buffer = new OndrejBakan\ByteBuffer\ByteBuffer($data);

        $this->assertEquals(65535, $buffer->readUint16());
    }

    public function testReadUint16()
    {
        $data = pack('v', 65535);
        $buffer = new OndrejBakan\ByteBuffer\ByteBuffer($data);

        $this->assertEquals(65535, $buffer->readUint16());
    }

    public function testReadUint32()
    {
        $data = pack('V', 4294967295);
        $buffer = new OndrejBakan\ByteBuffer\ByteBuffer($data);

        $this->assertEquals(4294967295, $buffer->readUint32());
    }

    public function testReadUint64()
    {
        $gmpValue = gmp_init("18446744073709551615");

        // Split the 64-bit number into high and low 32-bit parts
        $low = gmp_intval(gmp_mod($gmpValue, '4294967296')); // Low 32 bits
        $high = gmp_intval(gmp_div_q($gmpValue, '4294967296')); // High 32 bits

        // Pack as little-endian (low first, then high)
        $data = pack('V2', $low, $high);
        $buffer = new OndrejBakan\ByteBuffer\ByteBuffer($data);

        $this->assertEquals(2**64-1, $buffer->readUint64());
    }

    public function testReadMultiple()
    {
        $data = pack('vVP', 65535, 4294967295, 9223372036854775807);
        $buffer = new OndrejBakan\ByteBuffer\ByteBuffer($data);

        $this->assertEquals(65535, $buffer->readUint16());
        $this->assertEquals(4294967295, $buffer->readUint32());
        //$this->assertEquals(9223372036854775807, $buffer->readUint64());
    }
}
