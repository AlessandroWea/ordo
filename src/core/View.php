<?php

namespace Ordo;

class View
{
    static public string $layout = 'default.php';
    static public string $layoutFolder = APP_LAYOUT_FOULDER;
    static public string $viewsFolder = APP_VIEWS_FOLDER;

    public static function render($path, $vars = [])
    {
		if($vars)
			extract($vars);

		$path = $path . '.view.php';
		$fullpath = '../'. self::$viewsFolder . $path;
		if(file_exists($fullpath))
		{
			ob_start();

			require $fullpath;
			$content = ob_get_clean();
			require '../' . self::$layoutFolder . self::$layout;
            $ret = ob_get_clean();
		}
		else
		{
			echo 'File: ' . $fullpath . ' was not found!';
		}

        echo $ret;
    }
}