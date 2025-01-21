<?php

use PHPUnit\Framework\TestCase;

class ByteBufferTest extends TestCase
{

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
        $data = pack('P', 9223372036854775807);
        $buffer = new OndrejBakan\ByteBuffer\ByteBuffer($data);

        $this->assertEquals(9223372036854775807, $buffer->readUint64());
    }
}
