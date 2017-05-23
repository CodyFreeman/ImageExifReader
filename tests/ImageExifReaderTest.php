<?php

namespace Freeman\ImageExifReader\Tests;

use Freeman\ImageExifReader\ImageExifReader;
use PHPUnit\Framework\TestCase;


class ImageExifReaderTest extends TestCase {

	/** @var ImageExifReader */
	public $exifReader;

	public const IMAGE_FOLDER = __DIR__ . DIRECTORY_SEPARATOR . 'testFiles' . DIRECTORY_SEPARATOR;

	public function setUp() {
		$this->exifReader = new ImageExifReader();
	}

	public function tearDown() {
		unset( $this->exifReader );
	}

	/* SETTING UP DATA PROVIDERS */

	public function provideValidImagePaths() {
		return [
			[ self::IMAGE_FOLDER . 'test.jpg' ],
			[ self::IMAGE_FOLDER . 'testII.tif' ],
			[ self::IMAGE_FOLDER . 'testMM.tif']
		];
	}

	public function provideValidImagePathsAndExifField() {

		return [
			[ self::IMAGE_FOLDER . 'test.jpg', 'FileName', 'string' ],
			[ self::IMAGE_FOLDER . 'test.jpg', 'COMPUTED', 'array' ],
			[ self::IMAGE_FOLDER . 'test.jpg', 'FileSize', 'int' ],
			[ self::IMAGE_FOLDER . 'testII.tif', 'FileName', 'string' ],
			[ self::IMAGE_FOLDER . 'testII.tif', 'COMPUTED', 'array' ],
			[ self::IMAGE_FOLDER . 'testII.tif', 'FileSize', 'int' ],
			[ self::IMAGE_FOLDER . 'testMM.tif', 'FileName', 'string' ],
			[ self::IMAGE_FOLDER . 'testMM.tif', 'COMPUTED', 'array'],
			[ self::IMAGE_FOLDER . 'testMM.tif', 'FileSize', 'int' ]

		];
	}

	/* TESTING PUBLIC METHOD getExifData */

	/**
	 * @dataProvider provideValidImagePaths
	 */
	public function testGetExifDataReturnsArray( $imagePath ) {
		$output = $this->exifReader->getExifData( $imagePath );
		$this->assertInternalType( 'array', $output );
	}

	public function testGetExifDataFileNotFound() {
		$inputPath = self::IMAGE_FOLDER . 'notAnImageInTheFolder.jpg';

		$this->expectException( 'Exception' );
		$this->exifReader->getExifData( $inputPath );
	}

	public function testGetExifDataIncompatibleImageType() {
		$inputPath = self::IMAGE_FOLDER . 'test.png';

		$output = $this->exifReader->getExifData( $inputPath );
		$this->assertNull( $output );
	}

	public function testGetExifDataUriFails() {
		$inputPath = $inputPath = 'http://redwoodmanagement.dk/wp-content/themes/Redwood/img/Icon1.png';

		$this->expectException( 'Exception' );
		$this->exifReader->getExifData( $inputPath );
	}

	public function testGetExifDataAudioFails() {
		$inputPath = self::IMAGE_FOLDER . 'test.wav';

		$output = $this->exifReader->getExifData( $inputPath );
		$this->assertNull( $output );

	}

	/* TESTING PUBLIC METHOD getExifDataByField */

	/**
	 * @dataProvider provideValidImagePathsAndExifField
	 */
	public function testGetExifDataByKeyReturnsCorrectType( $inputPath, $field, $expected ) {

		$output = $this->exifReader->getExifDataByKey( $inputPath, $field );
		$this->assertInternalType( $expected, $output );
	}

	public function testGetExifDataByKeyFileNotFound() {
		$inputPath = self::IMAGE_FOLDER . 'notAnImageInTheFolder.jpg';
		$field     = 'FileName';

		$this->expectException( 'Exception' );
		$this->exifReader->getExifDataByKey( $inputPath, $field );
	}

	public function testGetExifDataByKeyIncompatibleImageType() {
		$inputPath = self::IMAGE_FOLDER . 'test.png';
		$field     = 'FileName';

		$output = $this->exifReader->getExifDataByKey( $inputPath, $field );
		$this->assertNull( $output );
	}

	public function testGetExifDataByKeyFieldDoesNotExist() {
		$inputPath = self::IMAGE_FOLDER . 'test.jpg';
		$field     = 'WrongFieldName';

		$output = $this->exifReader->getExifDataByKey( $inputPath, $field );
		$this->assertNull( $output );
	}

	public function testGetExifDataByKeyUriFails() {
		$inputPath = $inputPath = 'https://raw.githubusercontent.com/CodyFreeman/ImageExifReader/master/tests/testFiles/test.jpg';
		$field     = 'FileName';

		$this->expectException( 'Exception' );
		$this->exifReader->getExifDataByKey( $inputPath, $field );
	}
}