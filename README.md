# _foptions

This is a helper class to better handle the **Wordpress Options API**. With time I felt a lack of a better OOP side of this API that'd respect the DRY concept. So I built this one for my needs but it might fit yours.
The helper class was inspired by the one that [Carl Alexander](https://carlalexander.ca/designing-classes-wordpress-options-api/) created and modified to my own needs. Feel free to change it to yours. 

## Getting Started

All you need to do is download the [_foptions](_foptions.php) class and start using it. 

### Including 

If it's a **theme** you'll require it in you *functions.php*

```
require get_template_directory() . '/path/to/file/_foptions.php';
```
If it's a **plugin** you'll require it in yout *my_plugin_name.php*
```
require plugin_dir_path(__FILE__) . '/path/to/file/_foptions.php';
```

### Initializing

This helper class uses the [Singleton](https://carlalexander.ca/singletons-in-wordpress/) Pattern so you **don't need to instantiate.**
All methods are static, all you need to do is call them, but you can save the class in a variable if you want to.

```
$_foptions = _foptions::get_instance(); //Optional
```

### Change default variables (recommended)

As the idea of this class is not to repeat yourself, I recommend that you overwrite the default values for *$prefix* and *$default*
These are the values that we repeat alot when using the Wordpress Options API.
* *$prefix* is a recommendation in the WP world. It helps avoiding duplacation of options name.
So if you don't want to keep asking for *my_plugin_prefix_option_name* you can set the *prefix* to *my_plugin_prefix* and only ask for the 
*option_name*. The default value for this var is an empty string
* *$default* it's the default value that wordpress returns if nothing was found with the option you asked. The default value for this var
is the NULL value

If you want to change theses default values all you need to do is call the **set_settings()** function
It accepts an array with the new values

```
_foptions::set_settings(array('prefix' => 'my_theme', 'default' => 'none_found'));
```

## Set option

**Set()** does what the name says, it sets a value to an option name. It accepts 3 parameters:
* *$option*   the option name *required*
* *$value*    the value for the option name *required*
* *$prefixed* either the option name is prefixed or not. *optional, default =* **true**

```
_foptions::set('admin_name', 'fefe'); //Prefixed

_foptions::set('blerg', 'blurg', false); //Not prefixed
```

### Get option

**Get()**, does what it says, it gets the option. It accepts 3 parameters:
* *$option*   the option name *required*
* *$prefixed* either the option name is prefixed or not. *optional, default =* **true**
* *$default*  This is used if you want to overwrite the default value for this single option, or if you expect an array as default *optional, default =* **null**

```
_foptions::get('admin_name'); //Returns the option value or the default value I specified in the set_Settings()

_foptions::get('blerg', false);// Not prefixied

_foptions::get('blerg', false, array()) // Not prefixied and expects an array as default. If none is found it'll return an array with the $default inside
```

## Has option

**has()** Returns true if the option exists in the wordpress db and false in the contrary. it accepts 2 parameters:
* *$option*   the option name *required*
* *$prefixed* either the option name is prefixed or not. *optional, default =* **true**

```
_foptions::has('admin_name'); //Prefixed

_foptions::has('blerg', false); //Not prefixed
```

### Delete option

**delete()** Removes the option and its value from the database. It accepts 2 parameters:
* *$option*   the option name *required*
* *$prefixed* either the option name is prefixed or not. *optional, default =* **true**

```
_foptions::delete('admin_name'); //Prefixed

_foptions::delete('blerg', false); //Not prefixed
```
