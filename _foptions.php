<?php 

/**
 * @author  Fernando Cabral https://github.com/fernandoanael
 */
class _foptions
{
	/**
	 * Contains the class instance
	 * @var _foptions static object
	 */
	private static $instance;

	/**
	 * Contains the prefix for all the options
	 * @var string
	 */
	private static $prefix = '';

	/**
	 * Contains the default value for no-found options
	 * @var mixed
	 */
	public static $default = null;

	/**
	 * Singleton, private constructor.
	 */
	private function __construct(){}

	/**
	 * Returns the static object
	 * @return Object
	 */
	public static function get_instance(){
		if(self::$instance === null){
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Set the values of prefix or default
	 * @param array $settings contains the configuration of prefix and default value if none is found.
	 */
	public static function set_settings($settings = array()){
		if(isset($settings['prefix'])){
			self::$prefix 	= is_string($settings['prefix']) ? $settings['prefix'] : '';
		}

		if(isset($settings['default'])){
			self::$default 	= is_string($settings['default']) ? $settings['default'] : null;
		}
	}

	/**
	 * Return the option name with it's prefix
	 * @param  String $option the name of the Wp option
	 * @return String         The prefixed option name
	 */
	private static function prefixify($option){
		return self::$prefix.'_'.$option;
	}
	
	/**
	 * Set the Wp option with a specific value.
	 * @param String $option Wp Option name
	 * @param Mixed $value   The option value.
	 * @param boolean $prefixed Tells if is a prefixed value or not
	 */
	public static function set($option, $value, $prefixed = true){
		if($prefixed){
			update_option( self::prefixify($option), $value );
		}else{
			update_option($option, $value);
		}

	}

	/**
	 * Get the Wp option
	 * @param  String  $option   The Wp option name
	 * @param  boolean $prefixed Tells if the options is prefixed or not
	 * @param  mixed  $default   Overwrites the self::$default if needed
	 * @return mixed             The Wp option from de Wp db
	 */
	public static function get($option, $prefixed = true, $default = null){
		$default = isset($default) ? $default : self::$default;
		if($prefixed){
			$fetch = get_option(self::prefixify($option), $default);
			if(is_array($default) && !is_array($fetch)){
				$fetch = (array) $fetch;
			}
			return $fetch;
		}else{
			$fetch = get_option($option, $default);
			if(is_array($default) && !is_array($fetch)){
				$fetch = (array) $fetch;
			}
			return $fetch;
		}
	}

	/**
	 * Checks if option exist or not, value is compared with the default value or Null if none is given
	 * @param  String  $option   Wp option name
	 * @param  boolean $prefixed Tells if it's prefixed or not
	 * @return boolean           
	 */
	public static function has($option, $prefixed = true){
		if($prefixed){
			if(self::get($option) !== self::$default){
				return true;
			}else{
				return false;
			}
		}else{
			if(self::get($option, false) !== self::$default){
				return true;
			}else{
				return false;
			}
		}
	}

	/**
	 * Removes the option with the given name
	 * @param  String  $option   Wp option name
	 * @param  boolean $prefixed Tells if it's a prefixed option or not
	 */
	public static function delete($option, $prefixed = true){
		if($prefixed){
			delete_option( self::prefixify($option) );
		}else{
			delete_option($option);
		}
	}
}
