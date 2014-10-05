<?php

namespace asm\core;
use Exception;

/**
 * Provides access to application configuration (kept in separate INI file) @module.
 *
 * To use this class, it must be initialized using init() method. All configuration
 * properties are then accessible using virtual .
 *
 * Implemented as internal-singleton module.
 */
class Config
{
	/// default separator of section name and key in folder structure variables
	const defaultFolderDelimiter = '.';
	/// name of folder structure section (contains relationships between other
	/// configuration properties resolved to be resolved as part of initialization)
	const folderStructureId = 'folderStructure';
	/// key of custom folder delimiter (value with this key in folder structure
	/// section is used instead of @ref defaultFolderDelimiter if present)
	const folderDelimiterId = 'delimiter';

    /** @var Config */
	protected static $instance;	///< singleton instance

	/**
	 * Initializes this class' singleton instance from supplied INI file.
	 * @param string $iniFile path to INI file with application configuration
     * // TODO update documentation
	 */
	public static function init ()
	{
        // Load all specified .ini files
		self::$instance = new self(func_get_args());
	}

    // TODO wtf why magic method?
	/**
	 * Makes directly inaccessible singleton instance accessible as module.
	 *
	 * Provides static access to get() method if singleton instance is initialized,
	 * otherwise throws an exception.
	 */
	public static function __callStatic ($method, $arguments)
	{
		if (!self::$instance)
		{
			throw new Exception("Configuration is not initialized");
		}

		if ($method == 'get')
		{
			return call_user_func_array(array(self::$instance, $method), $arguments);
		}
        if ($method == 'getHttpRoot')
        {
            return call_user_func_array(array(self::$instance, $method), $arguments);
        }

		return null;
	}

	protected $config;	///< associative array with configuration properties

	/**
	 * Parses supplied INI file and initializes instance with extracted data.
	 *
	 * Section @ref folderStructureId is removed from data and used to turn partial
	 * paths in configuration into full paths.
	 * @param string $iniFile path to INI file
     * // TODO update documentation
	 */
	protected function __construct ($iniFiles)
	{
        $config = array();
        foreach($iniFiles as $iniFile)
        {
            $configFile = parse_ini_file($iniFile, true);
            $config = array_merge($config, $configFile);
        }

        // TODO scream loudly on failure
        if (isset($config[self::folderStructureId]))
        {
            $folderStructure = $config[self::folderStructureId];
            unset($config[self::folderStructureId]);

            $delimiter = self::defaultFolderDelimiter;
            if (isset($folderStructure[self::folderDelimiterId]))
            {
                $delimiter = $folderStructure[self::folderDelimiterId];
                unset($folderStructure[self::folderDelimiterId]);
            }

            $config = $this->resolvePaths($config, $folderStructure, $delimiter);
        }
        $this->config = $config;
	}




	/**
	 * Resolves supplied partial path using supplied base.
	 * @param string $parent base for @c $child
	 * @param string $child partial path to be resolved
	 * @return string absolute path of @c $child appended to @c $parent with
	 *		OS-dependent directory separators replaced by UNIX-style slashes (or
	 *		@c $child if <tt>$parent . $child</tt> path doesn't exist)
	 */
	protected function resolvePath ($parent, $child)
	{
		$realPath = realpath($parent . $child);
		if ($realPath !== false)
		{
			$realPath = str_replace('\\', '/', $realPath);
			return (is_dir($realPath) ? $realPath . '/' : $realPath);
		}
		return $child;
	}

	/**
	 * Resolves parent-child relationships in configuration using supplied data.
	 * @param array $config unresolved configuration
	 * @param array $folderStructure parent-child key-value pairs
	 * @param string $delimiter separator of section names and property keys
	 * @return array configuration with relationships resolved
	 */
	protected function resolvePaths ($config, $folderStructure, $delimiter)
	{
		foreach ($folderStructure as $parent => $children)
		{
			list($parentSection, $parentName) = explode($delimiter, $parent);
			if (!isset($config[$parentSection][$parentName]))
			{
				continue; // TODO throw exception? YES YES YES YES YES YES
			}

			foreach ($children as $child)
			{
				list($childSection, $childName) = explode($delimiter, $child);
				if (!isset($config[$childSection]))
				{
					continue; // TODO throw exception?
				}

				if (isset($childName))
				{
					if (isset($config[$childSection][$childName]))
					{
						$config[$childSection][$childName] = $this->resolvePath(
								$config[$parentSection][$parentName], $config[$childSection][$childName]);
					}
					// TODO else throw exception?
				}
				else
				{
					foreach ($config[$childSection] as $key => $val)
					{
						$config[$childSection][$key] = $this->resolvePath(
								$config[$parentSection][$parentName], $val);
					}
				}
			}
		}

		return $config;
	}

	/**
	 * Gets configuration property with supplied section name and key (or whole section).
	 * @param string $section section name
	 * @param mixed $name property key (string) or null
	 * @return mixed property value (if @c $name is not null) or array with all
	 *		properties from @c $section
	 */
	protected function get ($section, $name = null)
	{
		if ($name === null)
		{
			return (isset($this->config[$section]) ? $this->config[$section] : null);
		}

		
		return (isset($this->config[$section][$name]) ? $this->config[$section][$name] : null);
	}

    protected function getHttpRoot()
    {
        return $this->get('roots', 'http');
    }
}

