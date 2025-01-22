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
        $data = pack('P', 9223372036854775807);
        $buffer = new OndrejBakan\ByteBuffer\ByteBuffer($data);

        $this->assertEquals(9223372036854775807, $buffer->readUint64());
    }

    public function testReadMultiple()
    {
        $data = pack('vVP', 65535, 4294967295, 9223372036854775807);
        $buffer = new OndrejBakan\ByteBuffer\ByteBuffer($data);

        $this->assertEquals(65535, $buffer->readUint16());
        $this->assertEquals(4294967295, $buffer->readUint32());
        $this->assertEquals(9223372036854775807, $buffer->readUint64());
    }
}
