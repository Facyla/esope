<?php
/**
 * This file is part of PHPPresentation - A pure PHP library for reading and writing
 * presentations documents.
 *
 * PHPPresentation is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPPresentation/contributors.
 *
 * @copyright   2010-2014 PhpPresentation contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 * @link        https://github.com/PHPOffice/PHPPresentation
 */

namespace PhpOffice\PhpPresentation\Tests;

use PhpOffice\PhpPresentation\Slide;
use PhpOffice\PhpPresentation\Shape\Hyperlink;
use PhpOffice\PhpPresentation\Shape\RichText;
use PhpOffice\PhpPresentation\Style\Border;
use PhpOffice\PhpPresentation\Style\Fill;
use PhpOffice\PhpPresentation\Style\Shadow;

/**
 * Test class for Autoloader
 */
class AbstractShapeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Register
     */
    public function testConstruct()
    {
        $object = new RichText();

        $this->assertEquals(0, $object->getOffsetX());
        $this->assertEquals(0, $object->getOffsetY());
        $this->assertEquals(0, $object->getHeight());
        $this->assertEquals(0, $object->getRotation());
        $this->assertEquals(0, $object->getWidth());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Style\\Border', $object->getBorder());
        $this->assertEquals(Border::LINE_NONE, $object->getBorder()->getLineStyle());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Style\\Fill', $object->getFill());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Style\\Shadow', $object->getShadow());
    }

    public function testFill()
    {
        $object = new RichText();

        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setFill());
        $this->assertNull($object->getFill());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setFill(new Fill()));
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Style\\Fill', $object->getFill());
    }

    public function testHeight()
    {
        $object = new RichText();

        $value = rand(1, 100);
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setHeight());
        $this->assertEquals(0, $object->getHeight());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setHeight($value));
        $this->assertEquals($value, $object->getHeight());
    }

    public function testHyperlink()
    {
        $object = new RichText();

        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setHyperlink());
        $this->assertFalse($object->hasHyperlink());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Shape\\Hyperlink', $object->getHyperlink());
        $this->assertTrue($object->hasHyperlink());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setHyperlink(new Hyperlink('http://www.google.fr')));
        $this->assertTrue($object->hasHyperlink());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Shape\\Hyperlink', $object->getHyperlink());
        $this->assertTrue($object->hasHyperlink());
    }

    public function testOffsetX()
    {
        $object = new RichText();

        $value = rand(1, 100);
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setOffsetX());
        $this->assertEquals(0, $object->getOffsetX());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setOffsetX($value));
        $this->assertEquals($value, $object->getOffsetX());
    }

    public function testOffsetY()
    {
        $object = new RichText();

        $value = rand(1, 100);
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setOffsetY());
        $this->assertEquals(0, $object->getOffsetY());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setOffsetY($value));
        $this->assertEquals($value, $object->getOffsetY());
    }

    public function testRotation()
    {
        $object = new RichText();

        $value = rand(1, 100);
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setRotation());
        $this->assertEquals(0, $object->getRotation());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setRotation($value));
        $this->assertEquals($value, $object->getRotation());
    }

    public function testShadow()
    {
        $object = new RichText();

        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setShadow());
        $this->assertNull($object->getShadow());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setShadow(new Shadow()));
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\Style\\Shadow', $object->getShadow());
    }

    public function testWidth()
    {
        $object = new RichText();

        $value = rand(1, 100);
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setWidth());
        $this->assertEquals(0, $object->getWidth());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setWidth($value));
        $this->assertEquals($value, $object->getWidth());
    }

    public function testWidthAndHeight()
    {
        $object = new RichText();

        $value = rand(1, 100);
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setWidthAndHeight());
        $this->assertEquals(0, $object->getWidth());
        $this->assertEquals(0, $object->getHeight());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setWidthAndHeight($value));
        $this->assertEquals($value, $object->getWidth());
        $this->assertEquals(0, $object->getHeight());
        $this->assertInstanceOf('PhpOffice\\PhpPresentation\\AbstractShape', $object->setWidthAndHeight($value, $value));
        $this->assertEquals($value, $object->getWidth());
        $this->assertEquals($value, $object->getHeight());
    }
}
