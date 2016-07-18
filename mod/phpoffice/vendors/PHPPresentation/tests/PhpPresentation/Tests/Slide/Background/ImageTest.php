<?php

namespace PhpOffice\PhpPresentation\Tests\Slide\Background;

use PhpOffice\PhpPresentation\Slide\Background\Image;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    public function testColor()
    {
        $object = new Image();

        $imagePath = PHPPRESENTATION_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'PhpPresentationLogo.png';
        $numSlide = rand(1, 100);

        $this->assertNull($object->getPath());
        $this->assertEmpty($object->getFilename());
        $this->assertEmpty($object->getExtension());
        $this->assertEquals('background_' . $numSlide . '.', $object->getIndexedFilename($numSlide));

        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Slide\\Background\\Image', $object->setPath($imagePath));
        $this->assertEquals($imagePath, $object->getPath());
        $this->assertEquals('PhpPresentationLogo.png', $object->getFilename());
        $this->assertEquals('png', $object->getExtension());
        $this->assertEquals('background_' . $numSlide . '.png', $object->getIndexedFilename($numSlide));

        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Slide\\Background\\Image', $object->setPath(null, false));
        $this->assertNull($object->getPath());
        $this->assertEmpty($object->getFilename());
        $this->assertEmpty($object->getExtension());
        $this->assertEquals('background_' . $numSlide . '.', $object->getIndexedFilename($numSlide));
    }
}
