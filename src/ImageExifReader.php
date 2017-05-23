<?php

namespace Freeman\ImageExifReader;

use \Exception;

class ImageExifReader {

	/**
	 * Gets the Exif data array from image on local file system
	 *
	 * @param string $imagePath Path to image
	 *
	 * @return array|null Returns array of exif data or null
	 * @throws Exception Throws Exception if file is not found
 	 */
	public function getExifData( string $imagePath ) {
		return $this->checkImage( $imagePath ) ? exif_read_data( $imagePath ) : null;
	}

	/**
	 * Gets a specific key of the Exif data array from image on local file system
	 *
	 * @param string $imagePath Path to image
	 * @param string $key Name of the key to fetch data from
	 *
	 * @return mixed Returns data from selected key, otherwise null
	 * @throws Exception Throws Exception if file is not found
	 */
	public function getExifDataByKey( string $imagePath, string $key ) {
		if ( ! $this->checkImage( $imagePath ) ) {
			return null;
		}
		$data = exif_read_data( $imagePath );

		return  $data[ $key ] ?? null;
	}

	/**
	 * Checks if image is of compatible type and exists in the local file system
	 *
	 * @param string $imagePath Path to image
	 *
	 * @return bool Returns true if image is found and compatible, false if not.
	 * @throws Exception Throws Exception if file is not found
	 */
	protected function checkImage( string $imagePath ): bool {
		if ( ! file_exists( $imagePath ) ) {
			throw new Exception( "File not found: $imagePath" );
		}
		$imageType = $this->getImageType( $imagePath );

		return $imageType === IMAGETYPE_JPEG || $imageType === IMAGETYPE_TIFF_II || $imageType === IMAGETYPE_TIFF_MM;
	}

	/**
	 * Returns image format as PHP image type constant and suppresses potential E_NOTICE
	 *
	 * @param string $imagePath Path to image
	 *
	 * @return int|bool Returns integer corresponding to PHP's IMAGETYPE constants or false
	 */
	protected function getImageType( $imagePath ) {
		return @exif_imagetype( $imagePath );
	}
}