<?php

namespace asm\utils;

// TODO continue here
/**
 * Filesystem-related utility functions.
 */
class Filesystem
{
    /**
     * Gets the filenames of all traditional simple files, in the specified directory.
     *
     * Sample use:
     * @code
     * Filesystem::getFiles("hello")
     * @endcode
     * could return, for example,
     * @code
     * Array (
     *  [0] => "hello.txt",
     *  [1] => "super.txt"
     * )
     * @endcode
     * @param $directory the directory to list files of
     * @return array all filenames
     */
    public static function getFiles($directory)
    {
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
        foreach ($scanned_directory as $key => $scannedFile) {
            if (is_dir(static::combinePaths($directory, $scannedFile)))
            {
                unset($scanned_directory[$key]);
            }
        }
        $scanned_directory = array_values($scanned_directory);
        return $scanned_directory;
    }
    /**
     * Combines all paths given as arguments into a single one, keeping the resultant path close to the originals
     * and making sure extraneous slashes are not present.
     * http://stackoverflow.com/questions/1091107/how-to-join-filesystem-path-strings-in-php
     * Example: [ 'abc', 'def' ] turns into 'abc/def'
     * Example: [ 'abc/', '/def' ] turns into 'abc/def'
     * TODO test and make sure it works on Windows
     * @return mixed
     */
    public static function combinePaths()
    {
        $paths = array();
        foreach (func_get_args() as $arg) {
            if ($arg !== '') { $paths[] = $arg; }
        }
        return preg_replace('#/+#','/',join('/', $paths));
    }
    // TODO document and test
    // TODO use path combining
    public static function copyIntoDirectory( $sourceFileOrFolder, $destinationFolder )
    {
        if( is_dir($sourceFileOrFolder) )
        {
            if (!file_exists($destinationFolder))
            {
                mkdir($destinationFolder);
            }
            else
            {
                if (!is_dir($destinationFolder))
                {
                  return false;
                }
            }
            $objects = scandir($sourceFileOrFolder);
            if( sizeof($objects) > 0 )
            {
                foreach( $objects as $file )
                {
                    if( $file == "." || $file == ".." )
                        continue;
                    // go on
                    if( is_dir( $sourceFileOrFolder.DIRECTORY_SEPARATOR.$file ) )
                    {
                        static::copyIntoDirectory( $sourceFileOrFolder.DIRECTORY_SEPARATOR.$file, $destinationFolder.DIRECTORY_SEPARATOR.$file );
                    }
                    else
                    {
                        copy( $sourceFileOrFolder.DIRECTORY_SEPARATOR.$file, $destinationFolder.DIRECTORY_SEPARATOR.$file );
                    }
                }
            }
            return true;
        }
        elseif( is_file($sourceFileOrFolder) )
        {
            return copy($sourceFileOrFolder, $destinationFolder.DIRECTORY_SEPARATOR.basename($sourceFileOrFolder));
        }
        else
        {
            return false;
        }
    }
    /**
	 * Gets absolute path from supplied relative path.
	 * @param string $path
	 * @return string absolute path
	 */
	public static function realPath ($path)
	{
		return realpath(dirname($path)) . DIRECTORY_SEPARATOR . basename($path);
	}

	/**
	 * Creates new folder (recursively).
	 * @param string $path folder path
	 * @param int $mode unix permissions
	 */
	public static function createDir ($path, $mode = 0777)
	{
		if (!is_dir($path))
		{
			return @mkdir($path, $mode, true);
		}
		else
		{
			return @chmod($path, $mode);
		}
	}

	/**
	 * (Creates folders in file path and) dumps string to file.
	 * @param string $string
	 * @param string $filename file path
	 * @param int $mode unix permissions
	 */
	public static function stringToFile ($string, $filename, $mode = 0777)
	{
		$dirname = dirname($filename);
		self::createDir($dirname, $mode);
		file_put_contents($filename, $string);
	}

	/**
	 * Deletes folder and its contents.
	 * @param string $dir folder to be deleted
	 * @return bool true if folder was successfully deleted
	 */
	public static function removeDir ($dir)
	{
		if (!file_exists($dir)) return true;
		if (!is_dir($dir) || is_link($dir)) return unlink($dir);
		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') continue;
			if (!self::removeDir($dir . "/" . $item)) {
				 chmod($dir . "/" . $item, 0777);
				 if (!self::removeDir($dir . "/" . $item)) return false;
			}
	  }
	  return rmdir($dir);
	}

	/**
	 * Deletes file.
	 * @param string $path file to be deleted
	 * @return bool true if file was deleted successfully
	 */
	public static function removeFile ($path)
	{
		if (!file_exists($path)) return true;
		if (unlink($path)) return true;
		else
		{
			chmod($path, 0777);
			return unlink($path);
		}
	}

	/**
	 * Creates temporary folder
	 * @param mixed $dir parent folder or null to create subfolder of system temp
	 * @param string $prefix folder name prefix
	 * @param int $mode unix privileges
	 * @return string temporary folder path
	 */
	public static function tempDir ($dir = null, $prefix = '', $mode = 0700)
	{
		if (!is_dir($dir))
		{
			$dir = sys_get_temp_dir();
		}

		if (substr($dir, -1) != DIRECTORY_SEPARATOR)
		{
			$dir .= DIRECTORY_SEPARATOR;
		}

		do
		{
			$path = $dir . $prefix . mt_rand(0, 9999999);
		} while (!self::createDir($path, $mode));


		return $path;
	}
}

